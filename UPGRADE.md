2.x to 3.0
==========

*   Support for `symfony/assets` was dropped.
*   Support for Symfony < v5 was dropped.
*   The config values changed.
    *   Previously: `project_name` is now `installation` and must match `a-z 0-9 -_`
    *   New: required option `project` is the clear text project name.


1.x to 2.0
==========

*   Move all config from `becklyn/monitoring` to this bundle.
*   The twig function `monitoring_embed` was renamed to `hosting_embed_monitoring`.
