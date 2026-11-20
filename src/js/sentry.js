/**
 * Sentry browser SDK for development and staging sites.
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
const involvesTourOperator = ( event ) =>
	( event.exception?.values || [] ).some( ( exception ) =>
		( exception.stacktrace?.frames || [] ).some(
			( frame ) =>
				typeof frame.filename === 'string' &&
				frame.filename.startsWith( config.pluginUrl ) &&
				// The SDK wraps timers and event listeners, so its own bundle appears in
				// other scripts' stack traces. Those frames don't count.
				! frame.filename.includes( '/build/sentry.js' )
		)
	);

if ( config && config.dsn ) {
	Sentry.init( {
		dsn: config.dsn,
		environment: config.environment,
		release: config.release,
		integrations: [ Sentry.browserTracingIntegration() ],
		tracesSampleRate: config.tracesSampleRate,
		// Send trace headers to this site only (REST API and admin-ajax), so PHP joins the trace.
		tracePropagationTargets: [ config.siteUrl ],
		initialScope: {
			tags: { component: 'tour-operator' },
		},
		beforeSend: ( event ) =>
			involvesTourOperator( event ) ? event : null,
	} );
}
