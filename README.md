# Screenshotter

API for creating Screenshots of a website.

## Todo

- Tests
    - add missing tests
    - fix tests in docker
    - check deprecation messages
- Deploy
- fix dying browsershot instances (see logs)
- sentry, uptimerobot
- docs

## Commands

```
# remove expired screenshots, should be called via cron regularily
bin/console app:cleanup-screenshots

# create a new client to use the api
bin/console app:create-client
```
