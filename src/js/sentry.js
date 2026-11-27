/**
 * Sentry browser SDK for local development sites only.
 *
 * includes/sentry.php enqueues this file and sets window.lsxToSentry only when
 * Tour Operator runs its own Sentry client (no site-level Sentry is present).
 * The built file is not part of the WordPress.org release.
 *
 * Session Replay is deliberately not loaded. It records page content, which can
 * include enquiries and traveller details, and needs its own privacy review and
 * approval before it is turned on (TO-271).
 *
 * Tour Operator extensions report through this same SDK. Their script URLs come
 * in window.lsxToSentry.components, and each error is tagged with the extension
 * it came from.
 */
import * as Sentry from '@sentry/browser';

const config = window.lsxToSentry;

/**
 * Tour Operator and its extensions, longest URL first so the most specific match wins.
 * Older configs without `components` fall back to Tour Operator alone.
 */
const components = (
    Array.isArray(config?.components) && config.components.length
        ? config.components
        : [{ name: 'tour-operator', url: config?.pluginUrl }]
)
    .filter((component) => typeof component.url === 'string' && component.url)
    .sort((a, b) => b.url.length - a.url.length);

/**
 * The component a script URL belongs to.
 *
 * @param {string} filename Frame URL.
 * @return {Object|undefined} The component, if the URL is under one.
 */
const componentFor = (filename) =>
    typeof filename === 'string' &&
    // The SDK wraps timers and event listeners, so its own bundle appears in other
    // scripts' stack traces. Those frames don't count.
    !filename.includes('/build/sentry.js')
        ? components.find((component) => filename.startsWith(component.url))
        : undefined;

/**
 * Finds the Tour Operator component closest to where the error was raised.
 *
 * The browser SDK sees errors from every script on the page. Like the PHP side,
 * only errors that run through Tour Operator or one of its extensions belong in
 * this project. Frames run from the oldest call to the newest, so they are read
 * newest first.
 *
 * @param {Object} event Sentry event.
 * @return {Object|undefined} The component, or undefined when none is involved.
 */
const findComponent = (event) => {
    for (const exception of event.exception?.values || []) {
        const frames = exception.stacktrace?.frames || [];
        for (let i = frames.length - 1; i >= 0; i--) {
            const component = componentFor(frames[i].filename);
            if (component) {
                return component;
            }
        }
    }
    return undefined;
};

/**
 * Secrets that extensions put in URLs: the Wetu API key in the path, and keys or
 * tokens in query strings (openexchangerates.org's app_id). Matches includes/sentry.php.
 */
const SECRET_PATTERNS = [
    [/(wetu\.com\/API\/[A-Za-z]+\/)(?!V\d+\/)[^/\s?#"'<>]+/gi, '$1[Filtered]'],
    [
        /([?&](?:app_id|api_key|apikey|key|token|access_token|auth|password|secret)=)[^&\s#"'<>]+/gi,
        '$1[Filtered]',
    ],
];

/**
 * Redacts secrets from text such as an error message.
 *
 * @param {*} value Text that might contain a URL.
 * @return {*} The value with secrets replaced; non-strings unchanged.
 */
const redact = (value) =>
    typeof value === 'string'
        ? SECRET_PATTERNS.reduce(
              (text, [pattern, replacement]) =>
                  text.replace(pattern, replacement),
              value
          )
        : value;

/**
 * Tags an error event with its component and release, and redacts secrets.
 *
 * @param {Object} event     Sentry error event.
 * @param {Object} component The component the error belongs to.
 * @return {Object} The same event.
 */
const tagEvent = (event, component) => {
    event.tags = {
        ...event.tags,
        component: component.name,
        ...(component.version
            ? { 'component.version': component.version }
            : {}),
    };
    if (component.release) {
        event.release = component.release;
    }
    (event.exception?.values || []).forEach((exception) => {
        exception.value = redact(exception.value);
    });
    event.message = redact(event.message);
    return event;
};

/**
 * Removes query strings and fragments from a URL, or from URLs inside a span
 * description such as "GET https://example.com/?email=x".
 *
 * Query strings can carry enquiry and traveller details, search terms or tokens.
 *
 * @param {*} value A URL or text containing URLs.
 * @return {*} The value without query strings or fragments; non-strings unchanged.
 */
const stripQuery = (value) =>
    typeof value === 'string'
        ? redact(value).replace(/[?#][^\s]*/g, '')
        : value;

const URL_KEYS = ['url', 'from', 'to', 'http.url', 'server.address'];
const QUERY_KEYS = ['http.query', 'http.fragment', 'url.query', 'url.full'];

/**
 * Strips query strings from URL fields and drops query-only fields of a data object.
 *
 * @param {Object|undefined} data Breadcrumb or span data.
 */
const scrubData = (data) => {
    if (!data) {
        return;
    }
    URL_KEYS.forEach((key) => {
        if (key in data) {
            data[key] = stripQuery(data[key]);
        }
    });
    QUERY_KEYS.forEach((key) => delete data[key]);
};

/**
 * Removes query strings from everything in an event that holds a URL.
 *
 * @param {Object} event Sentry error or transaction event.
 * @return {Object} The same event.
 */
const scrubEvent = (event) => {
    if (event.request) {
        event.request.url = stripQuery(event.request.url);
        delete event.request.query_string;
        delete event.request.cookies;
        if (event.request.headers) {
            delete event.request.headers.Referer;
            delete event.request.headers.referer;
        }
    }
    event.transaction = stripQuery(event.transaction);
    (event.breadcrumbs || []).forEach((crumb) => scrubData(crumb.data));
    (event.spans || []).forEach((span) => {
        span.description = stripQuery(span.description);
        scrubData(span.data);
    });
    scrubData(event.contexts?.trace?.data);
    return event;
};

if (config && config.dsn) {
    Sentry.init({
        dsn: config.dsn,
        environment: config.environment,
        release: config.release,
        integrations: [Sentry.browserTracingIntegration()],
        tracesSampleRate: config.tracesSampleRate,
        // Send trace headers to this site only (REST API and admin-ajax), so PHP joins the trace.
        tracePropagationTargets: [config.siteUrl],
        initialScope: {
            tags: { component: 'tour-operator' },
        },
        // No IPs, cookies or user details (the SDK default, kept explicit).
        sendDefaultPii: false,
        beforeSend: (event) => {
            const component = findComponent(event);
            return component ? scrubEvent(tagEvent(event, component)) : null;
        },
        beforeSendTransaction: scrubEvent,
        beforeBreadcrumb: (breadcrumb) => {
            scrubData(breadcrumb.data);
            breadcrumb.message = stripQuery(breadcrumb.message);
            return breadcrumb;
        },
    });
}
