<?php
/**
 * Sentry error monitoring and tracing for local development sites only.
 *
 * Tour Operator never competes with site-level monitoring. It works in one of
 * three modes, decided on `plugins_loaded`:
 *
 * - shared: the site already runs a Sentry client (from wp-config.php, an
 *   mu-plugin or a monitoring plugin). Tour Operator does not start its own SDK.
 *   It only tags events whose stack trace runs through Tour Operator (or a
 *   registered extension) with `component` and `component.version`, so they can
 *   be told apart in the site's Sentry project.
 * - own: no site-level client exists, the site is a local or development site
 *   (wp_get_environment_type()), the Sentry SDK is installed and a DSN is
 *   configured. Tour Operator starts its own client and sends only events that
 *   involve Tour Operator code. Errors from WordPress core or other plugins are
 *   dropped, because they belong to the site's monitoring, not this project.
 * - off: neither of the above. Nothing is loaded or sent.
 *
 * The Sentry PHP SDK (sentry/sentry) and browser SDK (@sentry/browser) are dev
 * dependencies, installed only on developers' local sites. Staging and live sites
 * never have them, and /vendor and build/sentry.* are excluded by .distignore, so
 * the WordPress.org release contains no Sentry code. Own mode also refuses to start
 * outside local and development environments, even if the SDK were present.
 *
 * Settings for own mode, in wp-config.php or the server environment:
 *     define( 'LSX_TO_SENTRY_DSN', '...' );          // PHP errors (tour-operator-server).
 *     define( 'LSX_TO_SENTRY_BROWSER_DSN', '...' );  // Browser errors (tour-operator-frontend).
 * The environment variables SENTRY_DSN and SENTRY_BROWSER_DSN work too.
 *
 * Tour Operator extensions report through these same clients and projects; they
 * never ship or start a Sentry SDK of their own. Known extensions are registered
 * automatically from their LSX_*_PATH, LSX_*_URL and LSX_*_VER constants (see
 * lsx_to_sentry_known_extensions()). Other plugins can register with the
 * `lsx_to_sentry_components` filter (plugin path => array( name, version, url )).
 *
 * @package tour-operator
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Reads a setting from a constant first, then from an environment variable.
 *
 * @param string $constant Constant name.
 * @param string $env      Environment variable name.
 * @return string The value, or an empty string when neither is set.
 */
function lsx_to_sentry_setting( $constant, $env ) {
	if ( defined( $constant ) && is_string( constant( $constant ) ) ) {
		return trim( constant( $constant ) );
	}

	$value = getenv( $env );

	return is_string( $value ) ? trim( $value ) : '';
}

/**
 * The Sentry client Tour Operator started itself, if any.
 *
 * @param \Sentry\ClientInterface|null $client Set the client (used once, by lsx_to_sentry_init()).
 * @return \Sentry\ClientInterface|null
 */
function lsx_to_sentry_own_client( $client = null ) {
	static $own_client = null;

	if ( null !== $client ) {
		$own_client = $client;
	}

	return $own_client;
}

/**
 * The client currently in charge of capturing errors for this request.
 *
 * @return \Sentry\ClientInterface|null
 */
function lsx_to_sentry_current_client() {
	if ( ! class_exists( '\Sentry\SentrySdk' ) ) {
		return null;
	}

	return \Sentry\SentrySdk::getCurrentHub()->getClient();
}

/**
 * How Tour Operator takes part in Sentry monitoring for this request.
 *
 * @return string 'own', 'shared' or 'off'.
 */
function lsx_to_sentry_mode() {
	$client = lsx_to_sentry_current_client();

	if ( null === $client ) {
		return 'off';
	}

	return lsx_to_sentry_own_client() === $client ? 'own' : 'shared';
}

/**
 * Whether Tour Operator's own Sentry client is running for this request.
 *
 * @return bool
 */
function lsx_to_sentry_is_active() {
	return 'own' === lsx_to_sentry_mode();
}

/**
 * Tour Operator extensions that report through Tour Operator's Sentry projects.
 *
 * Each extension only runs when Tour Operator is active, so its errors belong in
 * the same projects. The extension needs no code: it is registered when its
 * `<PREFIX>_PATH` and `<PREFIX>_VER` constants are defined.
 *
 * @return array<string, string> Component name (the repository slug) => constant prefix.
 */
function lsx_to_sentry_known_extensions() {
	return array(
		'to-faq'        => 'LSX_TO_FAQ',
		'to-team'       => 'LSX_TO_TEAM',
		'to-reviews'    => 'LSX_TO_REVIEWS',
		'to-specials'   => 'LSX_TO_SPECIALS',
		'to-search'     => 'LSX_TO_SEARCH',
		'wetu-importer' => 'LSX_WETU_IMPORTER',
		'to-currencies' => 'LSX_CURRENCIES',
	);
}

/**
 * The components whose code Sentry events are attributed to.
 *
 * @return array<string, array{name: string, version: string, url?: string}> Keyed by absolute plugin path.
 */
function lsx_to_sentry_components() {
	$components = array(
		LSX_TO_PATH => array(
			'name'    => 'tour-operator',
			'version' => LSX_TO_VER,
			'url'     => LSX_TO_URL,
		),
	);

	foreach ( lsx_to_sentry_known_extensions() as $name => $prefix ) {
		if ( ! defined( $prefix . '_PATH' ) || ! defined( $prefix . '_VER' ) ) {
			continue;
		}

		$components[ trailingslashit( (string) constant( $prefix . '_PATH' ) ) ] = array(
			'name'    => $name,
			'version' => (string) constant( $prefix . '_VER' ),
			'url'     => defined( $prefix . '_URL' ) ? trailingslashit( (string) constant( $prefix . '_URL' ) ) : '',
		);
	}

	/**
	 * Filters the components used for Sentry attribution.
	 *
	 * Known Tour Operator extensions are already included. Another plugin can add
	 * itself, or an extension can be removed by unsetting its path:
	 *     $components[ plugin_dir_path( __FILE__ ) ] = array(
	 *         'name'    => 'to-example',
	 *         'version' => '1.0.0',
	 *         'url'     => plugin_dir_url( __FILE__ ), // Optional: browser errors.
	 *     );
	 *
	 * @param array $components Keyed by absolute plugin path (with trailing slash).
	 */
	$components = apply_filters( 'lsx_to_sentry_components', $components );

	return is_array( $components ) ? $components : array();
}

/**
 * Finds the component closest to where the error was raised.
 *
 * Frames run from the oldest call to the newest, so they are read newest first.
 * An error raised in an extension that Tour Operator called is attributed to the
 * extension, not to Tour Operator.
 *
 * @param \Sentry\Event $event The event.
 * @return array{name: string, version: string, path: string}|null
 */
function lsx_to_sentry_find_component( $event ) {
	$stacktraces = array();

	foreach ( $event->getExceptions() as $exception ) {
		if ( null !== $exception->getStacktrace() ) {
			$stacktraces[] = $exception->getStacktrace();
		}
	}

	if ( null !== $event->getStacktrace() ) {
		$stacktraces[] = $event->getStacktrace();
	}

	if ( empty( $stacktraces ) ) {
		return null;
	}

	$components = lsx_to_sentry_components();

	foreach ( $stacktraces as $stacktrace ) {
		foreach ( array_reverse( $stacktrace->getFrames() ) as $frame ) {
			$file = $frame->getAbsoluteFilePath();

			if ( ! is_string( $file ) || '' === $file ) {
				continue;
			}

			foreach ( $components as $path => $component ) {
				if ( is_string( $path ) && '' !== $path && 0 === strpos( $file, $path ) && isset( $component['name'] ) ) {
					return array(
						'name'    => (string) $component['name'],
						'version' => isset( $component['version'] ) ? (string) $component['version'] : '',
						'path'    => $path,
					);
				}
			}
		}
	}

	return null;
}

/**
 * Event processor: tags events that run through Tour Operator or a registered extension.
 *
 * It runs for every Sentry client in the request, so it also works when the
 * site's own client is in charge (shared mode). It never drops events.
 *
 * In own mode, an event from an extension also gets the extension's release
 * (`to-faq@0.1.0+abc1234`), so Sentry links it to that repository's commits.
 * In shared mode the site's release is left alone and the extension's release
 * is only added as the `component.release` tag.
 *
 * Secrets that extensions put in URLs are redacted from every event this
 * processor attributes to a component, and from every event in own mode.
 *
 * @param \Sentry\Event $event The event.
 * @return \Sentry\Event
 */
function lsx_to_sentry_tag_component( $event ) {
	$tags      = $event->getTags();
	$own_mode  = lsx_to_sentry_is_active();
	$component = isset( $tags['component'] ) ? null : lsx_to_sentry_find_component( $event );

	if ( null !== $component ) {
		$event->setTag( 'component', $component['name'] );

		if ( '' !== $component['version'] ) {
			$event->setTag( 'component.version', $component['version'] );
		}

		$release = lsx_to_sentry_component_release( $component['name'], $component['version'], $component['path'] );
		$event->setTag( 'component.release', $release );

		if ( $own_mode ) {
			$event->setRelease( $release );
		}
	}

	if ( $own_mode || null !== $component || isset( $tags['component'] ) ) {
		lsx_to_sentry_redact_event( $event );
	}

	return $event;
}

/**
 * Patterns for secrets that Tour Operator extensions put in URLs.
 *
 * The SDK settings already drop request data and stack frame arguments, but an
 * exception or warning message can still quote a URL, for example a failed
 * download from the Wetu API, whose key is part of the URL path.
 *
 * @return array<string, string> Regular expression => replacement.
 */
function lsx_to_sentry_redaction_patterns() {
	$patterns = array(
		// Wetu API key in the path: wetu.com/API/Pins/<key>/..., wetu.com/API/Itinerary/<key>/...
		// The versioned endpoints (API/Itinerary/V8/Get) carry no key.
		'#(wetu\.com/API/[A-Za-z]+/)(?!V\d+/)[^/\s?\#"\'<>]+#i' => '$1[Filtered]',
		// Keys and tokens in query strings, such as openexchangerates.org/...?app_id=<key>.
		'#([?&](?:app_id|api_key|apikey|key|token|access_token|auth|password|secret)=)[^&\s\#"\'<>]+#i' => '$1[Filtered]',
	);

	/**
	 * Filters the secret patterns redacted from Sentry events.
	 *
	 * @param array<string, string> $patterns Regular expression => replacement for preg_replace().
	 */
	$patterns = apply_filters( 'lsx_to_sentry_redaction_patterns', $patterns );

	return is_array( $patterns ) ? $patterns : array();
}

/**
 * Redacts secrets from a string.
 *
 * @param string $value Text that might contain a URL.
 * @return string
 */
function lsx_to_sentry_redact( $value ) {
	if ( ! is_string( $value ) || '' === $value ) {
		return $value;
	}

	foreach ( lsx_to_sentry_redaction_patterns() as $pattern => $replacement ) {
		$redacted = preg_replace( $pattern, $replacement, $value );

		if ( is_string( $redacted ) ) {
			$value = $redacted;
		}
	}

	return $value;
}

/**
 * Redacts secrets from strings, recursively through arrays.
 *
 * @param mixed $value A breadcrumb metadata value.
 * @return mixed
 */
function lsx_to_sentry_redact_value( $value ) {
	if ( is_string( $value ) ) {
		return lsx_to_sentry_redact( $value );
	}

	if ( is_array( $value ) ) {
		return array_map( 'lsx_to_sentry_redact_value', $value );
	}

	return $value;
}

/**
 * Redacts secrets from an event's exception values, message and breadcrumbs.
 *
 * @param \Sentry\Event $event The event.
 * @return void
 */
function lsx_to_sentry_redact_event( $event ) {
	foreach ( $event->getExceptions() as $exception ) {
		$exception->setValue( lsx_to_sentry_redact( $exception->getValue() ) );
	}

	$message = $event->getMessage();

	if ( is_string( $message ) && '' !== $message ) {
		$formatted = $event->getMessageFormatted();
		$event->setMessage(
			lsx_to_sentry_redact( $message ),
			lsx_to_sentry_redact_value( $event->getMessageParams() ),
			is_string( $formatted ) ? lsx_to_sentry_redact( $formatted ) : null
		);
	}

	$breadcrumbs = array();

	foreach ( $event->getBreadcrumbs() as $breadcrumb ) {
		$crumb_message = $breadcrumb->getMessage();

		if ( is_string( $crumb_message ) && '' !== $crumb_message ) {
			$breadcrumb = $breadcrumb->withMessage( lsx_to_sentry_redact( $crumb_message ) );
		}

		foreach ( $breadcrumb->getMetadata() as $key => $value ) {
			$breadcrumb = $breadcrumb->withMetadata( $key, lsx_to_sentry_redact_value( $value ) );
		}

		$breadcrumbs[] = $breadcrumb;
	}

	$event->setBreadcrumb( $breadcrumbs );
}

/**
 * Own mode only: sends error events that involve Tour Operator code, drops the rest.
 *
 * Event processors run before this callback, so a matching event already carries
 * the `component` tag.
 *
 * @param \Sentry\Event $event The event.
 * @return \Sentry\Event|null
 */
function lsx_to_sentry_before_send( $event ) {
	$tags = $event->getTags();

	return isset( $tags['component'] ) ? $event : null;
}

/**
 * The Sentry release name: the plugin version, plus the commit on git checkouts.
 *
 * Local sites run a git checkout, so `tour-operator@2.2.0+abc1234` ties each
 * event to the exact commit. .github/workflows/sentry-release.yml creates the
 * same release for every push to develop, with its commits and source maps.
 *
 * @return string
 */
function lsx_to_sentry_release() {
	return lsx_to_sentry_component_release( 'tour-operator', LSX_TO_VER, LSX_TO_PATH );
}

/**
 * The release name for a component: `<name>@<version>`, plus `+<short sha>` on git checkouts.
 *
 * @param string $name    Component name, such as `to-faq`.
 * @param string $version Component version.
 * @param string $path    Absolute plugin path, with trailing slash.
 * @return string
 */
function lsx_to_sentry_component_release( $name, $version, $path ) {
	static $releases = array();

	$key = $name . '|' . $version . '|' . $path;

	if ( isset( $releases[ $key ] ) ) {
		return $releases[ $key ];
	}

	$release = $name . '@' . ( '' !== (string) $version ? $version : 'unknown' );
	$sha     = lsx_to_sentry_git_sha( $path );

	if ( '' !== $sha ) {
		$release .= '+' . substr( $sha, 0, 7 );
	}

	$releases[ $key ] = $release;

	return $release;
}

/**
 * The commit a plugin's git checkout is on, read straight from .git.
 *
 * @param string $path Absolute plugin path, with trailing slash. Defaults to Tour Operator.
 * @return string The full SHA, or an empty string when it can't be read.
 */
function lsx_to_sentry_git_sha( $path = LSX_TO_PATH ) {
	$git_dir = trailingslashit( $path ) . '.git/';

	// In a linked worktree, .git is a file pointing at the real git directory.
	if ( is_file( rtrim( $git_dir, '/' ) ) ) {
		$pointer = trim( (string) file_get_contents( rtrim( $git_dir, '/' ) ) ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents -- Local file.

		if ( ! preg_match( '#^gitdir: (.+)$#', $pointer, $gitdir ) ) {
			return '';
		}

		$git_dir = trailingslashit( path_is_absolute( $gitdir[1] ) ? $gitdir[1] : trailingslashit( $path ) . $gitdir[1] );
	}

	if ( ! is_readable( $git_dir . 'HEAD' ) ) {
		return '';
	}

	$head = trim( (string) file_get_contents( $git_dir . 'HEAD' ) ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents -- Local file.

	if ( preg_match( '/^[0-9a-f]{40}$/', $head ) ) {
		return $head; // Detached HEAD.
	}

	if ( ! preg_match( '#^ref: (refs/[^\s]+)$#', $head, $match ) ) {
		return '';
	}

	$ref = $match[1];

	// A linked worktree keeps its branches in the main repository's git directory.
	if ( ! is_readable( $git_dir . $ref ) && is_readable( $git_dir . 'commondir' ) ) {
		$common  = trim( (string) file_get_contents( $git_dir . 'commondir' ) ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents -- Local file.
		$git_dir = trailingslashit( path_is_absolute( $common ) ? $common : $git_dir . $common );
	}

	if ( is_readable( $git_dir . $ref ) ) {
		$sha = trim( (string) file_get_contents( $git_dir . $ref ) ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents -- Local file.
		return preg_match( '/^[0-9a-f]{40}$/', $sha ) ? $sha : '';
	}

	// Refs can also live in packed-refs: "<sha> refs/heads/name" per line.
	if ( is_readable( $git_dir . 'packed-refs' ) ) {
		foreach ( (array) file( $git_dir . 'packed-refs', FILE_IGNORE_NEW_LINES ) as $line ) {
			if ( preg_match( '#^([0-9a-f]{40}) ' . preg_quote( $ref, '#' ) . '$#', $line, $packed ) ) {
				return $packed[1];
			}
		}
	}

	return '';
}

/**
 * Whether this is a developer's local or development site, the only place own mode runs.
 *
 * @return bool
 */
function lsx_to_sentry_is_local_environment() {
	return in_array( wp_get_environment_type(), array( 'local', 'development' ), true );
}

/**
 * The trace sample rate. Own mode runs on local sites only, so every trace is kept.
 *
 * @return float
 */
function lsx_to_sentry_traces_sample_rate() {
	return 1.0;
}

/**
 * Loads the plugin's Composer dev dependencies without overriding other plugins.
 *
 * Composer puts its autoloader first in the queue, which would make the plugin's
 * dev copies of shared libraries (PSR packages, Symfony components) win over the
 * copies other plugins ship. Re-registering it at the end of the queue means
 * other plugins' classes always load first.
 *
 * @return void
 */
function lsx_to_sentry_load_sdk() {
	$autoload = LSX_TO_PATH . 'vendor/autoload.php';

	if ( ! is_readable( $autoload ) ) {
		return;
	}

	$loader = require_once $autoload;

	if ( $loader instanceof \Composer\Autoload\ClassLoader ) {
		$loader->unregister();
		$loader->register( false );
	}
}

/**
 * Decides the mode and, in own mode, starts Tour Operator's Sentry client.
 *
 * Runs on `plugins_loaded`, after wp-config.php, mu-plugins and every plugin file
 * have loaded, so any site-level client has had the chance to start first.
 *
 * @return void
 */
function lsx_to_sentry_init() {
	// Shared mode: the site already monitors errors. Add attribution only.
	if ( null !== lsx_to_sentry_current_client() ) {
		\Sentry\State\Scope::addGlobalEventProcessor( 'lsx_to_sentry_tag_component' );
		return;
	}

	$dsn = lsx_to_sentry_setting( 'LSX_TO_SENTRY_DSN', 'SENTRY_DSN' );

	/**
	 * Filters whether Tour Operator may start its own Sentry client when the site has none.
	 *
	 * @param bool $use_own_client Defaults to true when a DSN is configured.
	 */
	if ( '' === $dsn || ! lsx_to_sentry_is_local_environment() || ! apply_filters( 'lsx_to_sentry_use_own_client', true ) ) {
		return;
	}

	if ( ! function_exists( '\Sentry\init' ) ) {
		lsx_to_sentry_load_sdk();
	}

	if ( ! function_exists( '\Sentry\init' ) ) {
		return;
	}

	\Sentry\init(
		array(
			'dsn'                => $dsn,
			'environment'        => wp_get_environment_type(),
			'release'            => lsx_to_sentry_release(),
			'traces_sample_rate' => lsx_to_sentry_traces_sample_rate(),
			// Local sites often run on copies of live data (enquiries, traveller details), so
			// collect the minimum: no user info or IPs, cookies, headers, request bodies, URL query
			// strings, database query values or stack frame arguments.
			'send_default_pii'   => false,
			'data_collection'    => array(
				'user_info'             => false,
				'cookies'               => array( 'mode' => 'off' ),
				'http_headers'          => array(
					'request'  => array( 'mode' => 'off' ),
					'response' => array( 'mode' => 'off' ),
				),
				'http_bodies'           => array(),
				'url_query_params'      => array( 'mode' => 'off' ),
				'gen_ai'                => array(
					'inputs'  => false,
					'outputs' => false,
				),
				'database_query_data'   => false,
				'stack_frame_variables' => false,
			),
			// WordPress core and other plugins raise many deprecation notices; report warnings and worse.
			'error_types'        => E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED & ~E_NOTICE & ~E_USER_NOTICE,
			// Mark only Tour Operator and extension frames as in-app. The SDK treats every frame as
			// in-app unless a path is excluded; include wins over exclude, so excluding everything (the
			// WordPress root, any absolute path and WP-CLI's phar) leaves just the components in. Every
			// plugin file has loaded by plugins_loaded, so the extensions' constants are defined.
			'in_app_exclude'     => array( ABSPATH, '/', 'phar://' ),
			'in_app_include'     => array_values( array_filter( array_keys( lsx_to_sentry_components() ), 'is_string' ) ),
			'before_send'        => 'lsx_to_sentry_before_send',
		)
	);

	lsx_to_sentry_own_client( lsx_to_sentry_current_client() );

	\Sentry\State\Scope::addGlobalEventProcessor( 'lsx_to_sentry_tag_component' );

	lsx_to_sentry_start_transaction();

	register_shutdown_function( 'lsx_to_sentry_shutdown' );
}
add_action( 'plugins_loaded', 'lsx_to_sentry_init', 0 );

/**
 * Reports exceptions from scheduled actions, which Action Scheduler catches itself.
 *
 * Action Scheduler marks the action as failed and moves on, so the SDK's error
 * handler never sees the exception. Own mode only; the event processor and
 * before_send keep the event only if a component's code is in its stack trace
 * (for example the Wetu importer's sync actions).
 *
 * @param int|string $action_id Action Scheduler action ID.
 * @param \Throwable $exception The exception the action threw.
 * @return void
 */
function lsx_to_sentry_capture_scheduled_action( $action_id, $exception ) {
	if ( ! $exception instanceof \Throwable || ! lsx_to_sentry_is_active() ) {
		return;
	}

	\Sentry\withScope(
		function ( \Sentry\State\Scope $scope ) use ( $action_id, $exception ) {
			$scope->setTag( 'action_scheduler', 'failed_execution' );
			$scope->setContext( 'action_scheduler', array( 'action_id' => (string) $action_id ) );
			\Sentry\captureException( $exception );
		}
	);
}
add_action( 'action_scheduler_failed_execution', 'lsx_to_sentry_capture_scheduled_action', 10, 2 );

/**
 * Starts a transaction for this web request, continuing a trace started in the browser.
 *
 * @return void
 */
function lsx_to_sentry_start_transaction() {
	if ( 'cli' === PHP_SAPI ) {
		return;
	}

	$sentry_trace = isset( $_SERVER['HTTP_SENTRY_TRACE'] ) ? sanitize_text_field( wp_unslash( $_SERVER['HTTP_SENTRY_TRACE'] ) ) : '';
	$baggage      = isset( $_SERVER['HTTP_BAGGAGE'] ) ? sanitize_text_field( wp_unslash( $_SERVER['HTTP_BAGGAGE'] ) ) : '';
	$method       = isset( $_SERVER['REQUEST_METHOD'] ) ? sanitize_key( wp_unslash( $_SERVER['REQUEST_METHOD'] ) ) : 'get';
	$request_uri  = isset( $_SERVER['REQUEST_URI'] ) ? esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '/';
	$path         = wp_parse_url( $request_uri, PHP_URL_PATH );

	$context = \Sentry\continueTrace( $sentry_trace, $baggage );
	$context->setOp( 'http.server' );
	$context->setName( strtoupper( $method ) . ' ' . ( $path ? $path : '/' ) );
	$context->setSource( \Sentry\Tracing\TransactionSource::url() );

	$transaction = \Sentry\startTransaction( $context );
	\Sentry\SentrySdk::getCurrentHub()->setSpan( $transaction );
}

/**
 * Finishes the request transaction and sends any buffered logs.
 *
 * @return void
 */
function lsx_to_sentry_shutdown() {
	if ( ! lsx_to_sentry_is_active() ) {
		return;
	}

	$transaction = \Sentry\SentrySdk::getCurrentHub()->getTransaction();

	if ( null !== $transaction ) {
		$status = http_response_code();
		if ( is_int( $status ) ) {
			$transaction->setHttpStatus( $status );
		}
		$transaction->finish();
	}

	\Sentry\logger()->flush();
}

/**
 * Prints the trace meta tags, so the browser SDK joins the PHP request's trace.
 *
 * Own mode only: in shared mode the site's monitoring prints its own tags.
 *
 * @return void
 */
function lsx_to_sentry_trace_meta() {
	if ( ! lsx_to_sentry_is_active() ) {
		return;
	}

	printf( '<meta name="sentry-trace" content="%s" />' . "\n", esc_attr( \Sentry\getTraceparent() ) );
	printf( '<meta name="baggage" content="%s" />' . "\n", esc_attr( \Sentry\getBaggage() ) );
}
add_action( 'wp_head', 'lsx_to_sentry_trace_meta', 1 );
add_action( 'admin_head', 'lsx_to_sentry_trace_meta', 1 );

/**
 * Loads the browser SDK on the front end, in wp-admin and in the block editor.
 *
 * Own mode only, so it never starts a second browser SDK beside a site-level one.
 * It also needs a browser DSN and a built build/sentry.js (not part of the release).
 *
 * @return void
 */
function lsx_to_sentry_enqueue_browser() {
	$dsn        = lsx_to_sentry_setting( 'LSX_TO_SENTRY_BROWSER_DSN', 'SENTRY_BROWSER_DSN' );
	$asset_file = LSX_TO_PATH . 'build/sentry.asset.php';

	if ( '' === $dsn || ! lsx_to_sentry_is_active() || ! is_readable( $asset_file ) ) {
		return;
	}

	$asset = require $asset_file;

	// Tour Operator first, then each extension that has a URL, for browser attribution.
	$components = array();

	foreach ( lsx_to_sentry_components() as $path => $component ) {
		if ( ! is_string( $path ) || empty( $component['name'] ) || empty( $component['url'] ) ) {
			continue;
		}

		$version      = isset( $component['version'] ) ? (string) $component['version'] : '';
		$components[] = array(
			'name'    => (string) $component['name'],
			'version' => $version,
			'url'     => (string) $component['url'],
			'release' => lsx_to_sentry_component_release( (string) $component['name'], $version, $path ),
		);
	}

	wp_enqueue_script(
		'lsx-to-sentry',
		LSX_TO_URL . 'build/sentry.js',
		$asset['dependencies'],
		$asset['version'],
		array( 'in_footer' => false )
	);

	wp_add_inline_script(
		'lsx-to-sentry',
		'window.lsxToSentry = ' . wp_json_encode(
			array(
				'dsn'              => $dsn,
				'environment'      => wp_get_environment_type(),
				'release'          => lsx_to_sentry_release(),
				'tracesSampleRate' => lsx_to_sentry_traces_sample_rate(),
				'siteUrl'          => home_url( '/' ),
				'pluginUrl'        => LSX_TO_URL,
				'components'       => $components,
			)
		) . ';',
		'before'
	);
}
add_action( 'wp_enqueue_scripts', 'lsx_to_sentry_enqueue_browser', 1 );
add_action( 'admin_enqueue_scripts', 'lsx_to_sentry_enqueue_browser', 1 );
