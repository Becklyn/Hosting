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
