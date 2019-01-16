Hosting Bundle
==============

Eases the integration with several hosting-related topics.

Config
------


* `tier`: the tier the app is currently deployed to. Normally something like `"production"`, `"staging"` or `"development"`.
* `project_name`: the token used for uptime monitoring
* `trackjs`: the token for the integration with TrackJS.


Getting the Hosting Config
--------------------------

Just fetch the `Becklyn\Hosting\Config\HostingConfig` service and you have access to the hosting configuration. 


Features
--------

*   The bundle automatically adds a `<!-- uptime monitor: $project_name -->` comment to all HTML responses. Use this for integration into uptime monitors.
*   If you set a `trackjs` token, you can include the monitoring JS:
    
    ```twig
    {% block javascripts %}
        {{- hosting_embed_monitoring() -}}
    
        {# .. your other JS imports #}
    {% endblock %}
    ```


Assets Bundle Integration
-------------------------

This bundle registers a `@hosting` namespace in the becklyn assets bundle.
