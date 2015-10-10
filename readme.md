# URL Shortener

## Requirements
* PHP 5.3+
* mySQL 5.6+
* Apache 2.4+
  * Modules:
      * rewrite

## Setup

* Create a database
* Copy /api/include/constants.example.php to /api/include/constants.php and fill in with appropriate details
* Create a /config/config.js file with your url shortener domain in place of: 'http://url-shortener.local.dev/'
  ```javascript
  api_domain = 'http://url-shortener.local.dev/';
  ```
* Navigate to the URL you chose


## API

If API access is available at your equvilalent to http://url-shortener.local.dev/api

#### API Use:

##### GET full url form short url:

* When using the API the short url should be sent as the 'short_url' GET parameter

  EG:

    http://url-shortener.local.dev/gh

    becomes

    http://url-shortener.local.dev/api/?short_url=gh

* Result is returned as a JSON object

  eg:

  ```json
  {"full_url":"https:\/\/github.com"}
  ```
##### Shortening URLs:

* When using the API the full url should be sent as the 'url' GET parameter and the preferred short url as the 'preferred_short_url' parameter

  EG:

    http://url-shortener.local.dev/api/?url=https://github.com&preferred_short_url=gh

* Result is stored in the database and is URL is returned as a JSON object indicating a successful operation. If the preferred short url is already taken, a random short url will be assigned and returned. Therefore if using the API, any software should use the returned short url value as opposed to the one sent to the server

  eg:

  ```json
  {"short_url":"gh"}
  ```
