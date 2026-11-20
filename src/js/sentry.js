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
	} );
}
