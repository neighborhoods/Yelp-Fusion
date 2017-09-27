# Neighborhoods Yelp-Fusion Library

A library that interfaces with the Yelp Fusion (v3) API, utilizing the GuzzleHttp client.

## Installation

#### Requirements
* PHP >= 5.6
* [GuzzleHttp 6.0](http://docs.guzzlephp.org/)
* [Composer (for installation)](https://getcomposer.org/)
* Yelp Fusion API authorization: Client ID and Client Secret

#### Installation

1. Add `"neighborhoods/yelp-fusion": "<version>"` to the composer.json file's `required` section.
    * Create a composer.json file in your project's root directory _if_ one does not exist.
    * Add the following to the new composer.json.
      ```
      {
        "require": {
          	"neighborhoods/yelp-fusion": "<version>"
          }
      }
      ```
2. Run `composer update --no-dev` (if you already have your project set up with composer) or `composer install --no-dev` to install Neighborhoods Yelp-Fusion Library.

## Usage

Before we go into the main usage of the this library, we recommend (as do Yelp themselves) caching your Yelp Oath Token.

#### Getting your Yelp Bearer Oath Token

```php
$yelp = new Yelp();
$oauthTokenData = $yelp->getBearerTokenObject("CLIENT_ID", "CLIENT_SECRET");
$token = $oauthTokenData->access_token;
```

`Yelp::getBearerTokenObject` returns a json object consisting with the properties: `access_token`, `token_type`, and `expires_in`. These are defined in the [Yelp's authentication documentation](https://www.yelp.com/developers/documentation/v3/authentication). `$oauthTokenData->access_token` is what you _should_ cache.

#### Requesting a search

```php

```

