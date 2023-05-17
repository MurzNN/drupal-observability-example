# Observability with Drupal example

This example demonstrates integration of observability tools (traces linked to
logs, metrics) with Drupal, to get a full tracing information from a frontend
application to the Drupal at the backend.

It is based on [DDEV](https://ddev.readthedocs.io/) project to quickly get a full
local working instance with all required services:
- NPM for the frontend app (React).
- PHP and Nginx for the backend app (Drupal).
- Tempo for collecting traces.
- Loki for collecting logs.
- Prometheus for collecting metrics.
- Grafana for visualizing traces, metrics and logs.

## Quick start

```
git clone https://github.com/MurzNN/drupal-observability-example.git
cd drupal-observability-example
ddev config --docroot=web --project-type=drupal10 --create-docroot
ddev start
ddev exec "composer install"
ddev exec "drush site-install -y"
ddev exec "drush pm:install observability_example -y"
ddev exec "drush devel-generate:content"
drush uli
```

Then open in your browser the React app on the url
https://drupal-observability-example.ddev.site:8443/
and see the loaded articles.

Then - open Grafana at the url
https://drupal-observability-example.ddev.site:3000/
and go to Explore, select "Tempo" datasource, choose Query type "Search", press "Run query" and see the traces.

To see how custom spans in Drupal code work - open the url
https://drupal-observability-example.ddev.site/observability-example
several times (it produces exceptions in 30% of calls - it's intendend)
and then - refresh the list of traces.
