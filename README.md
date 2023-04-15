# Drupal with OpenTelemetry module example

This example demonstrates how to get a full tracing information from React frontend app to the Drupal at the backend.

It is based on (DDEV)[htts://ddev.readthedocs.io/] project to quickly get a full local working instance with all required services:
- NPM for the frontend app (React).
- PHP and Nginx for the backend app (Drupal).
- Tempo for collecting traces.
- Grafana for visualizing traces.

## Quick start

```
git clone https://github.com/MurzNN/drupal-opentelemetry-example.git
cd drupal-opentelemetry-example
ddev config --docroot=web --project-type=drupal10 --create-docroot
ddev start
ddev ssh
composer install
drush site-install
drush pm:install devel_generate opentelemetry web restui
drush devel-generate:content
cd frontend
npm install
npm run-script start
```
