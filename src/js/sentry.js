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
 */
import * as Sentry from '@sentry/browser';

const config = window.lsxToSentry;

/**
 * Whether any stack frame of the event comes from a Tour Operator script.
 *
 * The browser SDK sees errors from every script on the page. Like the PHP side,
 * only errors that run through Tour Operator belong in this project.
 *
 * @param {Object} event Sentry event.
 * @return {boolean} True when a frame's URL is under the plugin URL.
 */
const involvesTourOperator = (event) =>
    (event.exception?.values || []).some((exception) =>
        (exception.stacktrace?.frames || []).some(
            (frame) =>
                typeof frame.filename === 'string' &&
                frame.filename.startsWith(config.pluginUrl) &&
                // The SDK wraps timers and event listeners, so its own bundle appears in
                // other scripts' stack traces. Those frames don't count.
                !frame.filename.includes('/build/sentry.js')
        )
    );

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
    typeof value === 'string' ? value.replace(/[?#][^\s]*/g, '') : value;

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
        beforeSend: (event) =>
            involvesTourOperator(event) ? scrubEvent(event) : null,
        beforeSendTransaction: scrubEvent,
        beforeBreadcrumb: (breadcrumb) => {
            scrubData(breadcrumb.data);
            breadcrumb.message = stripQuery(breadcrumb.message);
            return breadcrumb;
        },
    });
}
