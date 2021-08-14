# Screenshotter

API for creating Screenshots of a website.

## Todo

- Test create client command
- sentry
- fix dying browsershot instances (see logs)
- docs

## Commands

```
# apply code formatting
composer php-cs-fixer

# run tests
composer test

# remove expired screenshots, should be called via cron regularily
bin/console app:cleanup-screenshots

# create a new client to use the api
bin/console app:create-client

# create test db schema
php bin/console doctrine:schema:create --env=test

# load fixtures
php bin/console doctrine:fixtures:load --env=test
```

## Deployment

```
# deploy
dep deploy
```
