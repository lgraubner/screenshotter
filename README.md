# Screenshotter

Simple service based on [Symfony](https://symfony.com/) to create screenshots from websites.

## Api

```
POST http://localhost:8080/api/v1/screenshot
content-type: application/json

{
    "url": "https://heise.de"
}
```

### Options

| Name     | Default | Description           |
|----------|---------|-----------------------|
| delay    | 0       | Delay after page load |
| quality  | 70      | JPEG image quality    |
| width    | 1280    | Browser window width  |
| height   | 800     | Browser window height |
| fullPage | false   | Full page screenshot  |

## Commands

```
# run PHPStan
composer stan

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
dep deploy
```
