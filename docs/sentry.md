---
title: Sentry Error Monitoring
description: Set up, check, turn off and roll back Sentry error monitoring for Tour Operator on a local development site
category: Documentation
type: Guide
audience: Developers
date: 2026-11-26
---

# Sentry Error Monitoring

Tour Operator can send its PHP and browser errors to Sentry while you work on a **local development site**. It never runs on staging or live sites, and the WordPress.org release contains no Sentry code.

Related records: [TO-271](https://linear.app/lightspeedwp/issue/TO-271) (this setup) and [INT-193](https://linear.app/lightspeedwp/issue/INT-193) (the company-wide Sentry decisions).

## How it works

| Part | Where |
| --- | --- |
| PHP SDK (`sentry/sentry`) | Composer **dev** dependency, loaded by `includes/sentry.php` |
| Browser SDK (`@sentry/browser`) | npm **dev** dependency, built from `src/js/sentry.js` to `build/sentry.js` |
| PHP errors | Sentry project `tour-operator-server` |
| Browser errors | Sentry project `tour-operator-frontend` |
| Releases, commits and source maps | `.github/workflows/sentry-release.yml`, on every push to `develop` |

`/vendor` and `build/sentry.*` are excluded from the release zip by `.distignore`, and `build/sentry.*` is also gitignored. The release workflow fails if either ends up in the zip.

### Modes

On `plugins_loaded`, the plugin picks one of three modes. Check which one a site is in with `wp eval 'echo lsx_to_sentry_mode();'`.

| Mode | When | What Tour Operator does |
| --- | --- | --- |
| `shared` | The site already runs its own Sentry client (from `wp-config.php`, an mu-plugin or a monitoring plugin) | Doesn't start its own client or load its browser script. It only adds `component` and `component.version` tags to events that run through Tour Operator code. |
| `own` | No site client, **and** the environment type is `local` or `development`, **and** the dev packages are installed, **and** `LSX_TO_SENTRY_DSN` is set | Starts its own client and sends only errors that involve Tour Operator code. Errors from WordPress core or other plugins are dropped. |
| `off` | Anything else | Nothing loads or sends. This is the normal state on staging and live sites. |

### What gets sent

The plugin collects the minimum it needs:

- **Sent:** the exception and its stack trace, the URL path, the HTTP method, environment, release and the `component` tags.
- **Not sent:** user details or IP addresses, cookies, headers, request bodies, URL query strings, database query values, stack frame arguments.
- **Browser:** query strings and `#fragments` are stripped from URLs, breadcrumbs and spans. The Referer header is dropped.
- **Session Replay is not loaded.** It needs its own privacy review first.
- **Sentry-side safeguards:** both projects discard IP addresses and scrub extra fields (email, phone, names, traveller or passenger, passport, ID number, date of birth, address, enquiry, booking reference). The frontend project only accepts events from `*.local`, `localhost` and `127.0.0.1`.

Local sites often run on copies of live data, so treat anything you trigger as potentially real.

## Set it up on your local site

You need access to the LightSpeed Sentry organisation and a local site that's a git checkout of this plugin.

1. **Mark the site as local.** WordPress treats a site as `production` unless told otherwise, and own mode won't start there. In `wp-config.php`:

   ```php
   define( 'WP_ENVIRONMENT_TYPE', 'local' );
   ```

   WordPress Studio and Local set this for you. Check with `wp eval 'echo wp_get_environment_type();'`.

2. **Install the dev packages** in the plugin folder:

   ```bash
   composer install
   ```

   ```bash
   npm ci && npm run build
   ```

   `npm run build` builds `build/sentry.js` along with the rest of the plugin's scripts.

3. **Get the two DSNs** from the Sentry CLI (or Sentry → Settings → Projects → the project → Client Keys):

   ```bash
   sentry dsn list lightspeedwp/tour-operator-server
   ```

   ```bash
   sentry dsn list lightspeedwp/tour-operator-frontend
   ```

4. **Add them to `wp-config.php`.** Never commit them or paste them into Linear or GitHub.

   ```php
   // Sentry for the Tour Operator plugin (local only; see tour-operator/docs/sentry.md).
   define( 'LSX_TO_SENTRY_DSN', '<tour-operator-server DSN>' );
   define( 'LSX_TO_SENTRY_BROWSER_DSN', '<tour-operator-frontend DSN>' );
   ```

   The environment variables `SENTRY_DSN` and `SENTRY_BROWSER_DSN` work too.

5. **Check the mode:** `wp eval 'echo lsx_to_sentry_mode();'` should print `own`.

## Check it's working

**PHP:** this calls a Tour Operator function with the wrong argument, so it throws an error inside the plugin:

```bash
wp eval 'lsx_to_sentry_tag_component( "sentry-check" );'
```

Within a minute, a new `Error: Call to a member function getTags() on string` issue should appear in [`tour-operator-server`](https://lightspeedwp.sentry.io/issues/?project=tour-operator-server). Check that it has:

- `environment: local`
- a release of `tour-operator@<version>+<short sha>`, matching `git rev-parse --short HEAD`
- the tags `component: tour-operator` and `component.version`
- only `tour-operator/…` frames marked as the plugin's own code (in-app)
- no request body, cookies, query string or user

Then resolve the issue in Sentry.

**Browser:** open any front-end page and check that the page source has `<meta name="sentry-trace" …>` and loads `build/sentry.js`. In the browser console, `window.lsxToSentry` should show the config. Errors only reach Sentry when a Tour Operator script (any file under the plugin's URL except `build/sentry.js`) is in the stack trace. Errors typed into the console or thrown by other plugins are dropped on purpose.

## Releases and source maps

Each push to `develop` runs the **Sentry release** workflow. It:

1. creates the release `tour-operator@<version>+<short sha>` in both projects
2. links the commits, which is what lets Sentry suggest which commit caused an issue
3. builds the plugin with hidden source maps and uploads them
4. finalises the release

It uses the `SENTRY_GITHUB_ACTIONS` repository secret, and skips itself when that secret is missing.

A source map only matches if the freshly built JS file is identical to the committed one in `build/`. When they differ, the workflow warns `Fresh build differs from the committed file` and skips that map. The fix is to rebuild and commit `build/`.

Local commits that were never pushed to `develop` have no matching release. Their events still arrive, just without linked commits or source maps.

## Turn it off

Start with the first option and go further down only if you need to.

| Scope | How | Effect |
| --- | --- | --- |
| Your site, for now | Remove or comment out the two `LSX_TO_SENTRY_*` constants | Mode becomes `off`. Nothing loads. |
| Your site, without touching `wp-config.php` | `add_filter( 'lsx_to_sentry_use_own_client', '__return_false' );` in an mu-plugin | Mode becomes `off`. A site-level client still gets tags. |
| Your site, fully | `composer install --no-dev`, and delete `build/sentry.js` and `build/sentry.asset.php` | The SDKs are gone, so nothing can load. |
| Everyone, immediately | Sentry → the project → Client Keys → disable the key | Sentry rejects every event sent with that DSN. Nothing changes in the plugin. |
| Release workflow | Disable the **Sentry release** workflow in GitHub Actions, or remove the `SENTRY_GITHUB_ACTIONS` secret | No new releases, commits or source maps. Events still arrive. |

## Roll it back

To remove Sentry from the plugin completely, revert the merge commits of these PRs, newest first:

1. [#1425](https://github.com/lightspeedwp/tour-operator/pull/1425): own client on local sites only
2. [#1424](https://github.com/lightspeedwp/tour-operator/pull/1424): plugin-only frames, minimum data, commit-based releases and the release workflow
3. [#1423](https://github.com/lightspeedwp/tour-operator/pull/1423): the original integration

Then run `composer update` so `sentry/sentry` and its dependencies leave `composer.lock`, and remove `@sentry/browser` from `package.json`. Keep the PHP 8.2 platform pin in `composer.json`, which was added separately in #1422. Developers should also remove the `LSX_TO_SENTRY_*` constants from their `wp-config.php`.

The Sentry projects, their settings and any stored events are separate and stay until someone removes them in Sentry.

## For extensions

Tour Operator extensions don't need their own Sentry setup. To have their errors tagged with their own name and version, register the plugin path:

```php
add_filter(
    'lsx_to_sentry_components',
    function ( $components ) {
        $components[ plugin_dir_path( __FILE__ ) ] = array(
            'name'    => 'to-faq',
            'version' => '1.0.0',
        );
        return $components;
    }
);
```

In own mode, errors from a registered extension are sent too, because they now count as Tour Operator components.

## Troubleshooting

| Problem | Check |
| --- | --- |
| Mode is `off` | `wp eval 'echo wp_get_environment_type();'` must print `local` or `development`. Check `vendor/autoload.php` exists and both constants are defined. |
| Mode is `shared` | Something on the site already starts Sentry. Tour Operator is only adding tags to that client's events, which go to its project. |
| No browser script | Mode must be `own`, `LSX_TO_SENTRY_BROWSER_DSN` must be set, and `build/sentry.asset.php` must exist (run `npm run build`). |
| An error didn't appear | Only errors with a Tour Operator frame in the stack trace are sent. Deprecation notices and notices aren't reported. |
| `composer install` fails on PHP 8.2 | `composer.json` pins the platform to PHP 8.2. Run `composer update` rather than editing `composer.lock` by hand. |

## Known limits

- Events still include the developer's machine name (`server_name`), full local file paths, and a city-level location that Sentry works out from the IP address before discarding it.
- Session Replay is off, and alerts are off: every event comes from a developer's machine, so issues are reviewed in Sentry rather than emailed.
- A site-level Sentry client on staging or live would receive Tour Operator's tags. Whether that is allowed is still an open question on INT-193.
