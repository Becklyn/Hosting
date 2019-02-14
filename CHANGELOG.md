Changelog for 2.1.0
===================

*   Added new Twig test `hosting_tier` that allows you to integrate your own custom logic based on the hosting tier
    
    ```twig
    {%- if "dev" is hosting_tier -%}
        {# do something on dev #}
    {%- endif -%}
    ```

Changelog for 2.0.0
===================

*   The monitoring bundle (`becklyn/monitoring`) was integrated into this bundle and will be replaced by it from now on.
