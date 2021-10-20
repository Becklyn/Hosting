3.2.2
=====

*   (improvement) Require the latest version of `sentry/sentry-symfony` in order to fix deprecation warning.
*   (improvement) Upgrade all dependencies to their latest version.


3.2.1
=====

*   (bug) Fix Sentry exception filter not properly working after upgrading the Sentry SDK.


3.2.0
=====

*   (improvement) Bump minimum required version of PHP to 7.4 and add support for 8.0+.
*   (improvement) Upgrade Sentry SDK to the newest version.
*   (internal) Upgrade `becklyn/php-cs` to the newest versions.
*   (internal) Move CI over to CircleCI.
*   (internal) Add tests, courtesy of @apfelbox and @mangoischke.
*   (improvement) Enable CoverAlls code coverage.


3.1.4
=====

*   (improvement) Also ignore Mayd's `InternalRedirectException`.


3.1.3
=====

*   (improvement) Also ignore Doctrine Migration's `NoMigrationsToExecute`.


3.1.2
=====

*   (improvement) Also ignore symfony console's `CommandNotFoundException`.


3.1.1
=====

*   (improvement) Also ignore Mayd's `RequestMatchException`.


3.1.0
=====

*   (feature) Add Twig function `hosting_embed_html_meta()`


3.0.5
=====

*   (improvement) Don't log the current user in sentry. This improves the performance as it does not longer access the `session` in every request.


3.0.4
=====

*   (improvement) Don't use deprecated options.


3.0.3
=====

*   (bug) Fix failing git integration command.


3.0.2
=====

*   (bug) Properly handle `tier` config with env vars.


3.0.1
=====

*   (bug) Improve handling of empty env vars for TrackJS token


3.0.0
=====

*   (bc) Require Symfony 5 and change required config.
*   (bug) Properly support Symfony 5.
*   (improvement) Bump required packages.
*   (internal) Bump sentry packages.
*   (feature) Add `project` + `installation` config options.


2.3.0
=====

*   (feature) Add Twig function `hosting_embed_html_meta()`


2.2.5
=====

*   (improvement) Don't log the current user in sentry. This improves the performance as it does not longer access the `session` in every request.


2.2.4
=====

*   (bug) Explicitly wire sentry client. The actual client is a subclass of `Raven_Client` and is therefor
    not picked up by autowiring.


2.2.3
=====

*   (bug) Remove symfony 5 from the dependencies since the new config of the updated bundles includes breaking changes.


2.2.2
=====

*   (improvement) Add support for Symfony 5.


2.2.1
=====

*   (improvement) Re-add support for PHP 7.1
*   (internal) Code cleanup


2.2.0
=====


2.1.1
=====

*   Add PHP Code Style fixer to bundle.
*   Add phpstan stan.
*   Add PHPUnit.
*   Add CODEOWNERS file.
*   Add travis configuration
*   Add becklyn/assets-bundle to require dev to prevent phpstan errors.

2.1.0
=====

*   Added new Twig function `hosting_tier` that allows you to integrate your own custom logic based on the hosting tier
    
    ```twig
    {%- if "dev" == hosting_tier() -%}
        {# do something on dev #}
    {%- endif -%}
    ```

2.0.0
=====

*   The monitoring bundle (`becklyn/monitoring`) was integrated into this bundle and will be replaced by it from now on.
