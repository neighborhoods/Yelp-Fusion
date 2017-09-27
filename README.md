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

Replace `CLIENT_ID` and `CLIENT_SECRET` with _your_ assigned client id and secret from Yelp.

```php
$yelp = new Yelp();
$oauthTokenData = $yelp->getBearerTokenObject("CLIENT_ID", "CLIENT_SECRET");
$oauthToken = $oauthTokenData->access_token;
```

`Yelp::getBearerTokenObject` returns a json object consisting with the properties: `access_token`, `token_type`, and `expires_in`. These are defined in the [Yelp's authentication documentation](https://www.yelp.com/developers/documentation/v3/authentication). `$oauthToken->access_token` is the data you _should_ cache.

#### Requesting a search

You can reference [Yelp's business search documentation](https://www.yelp.com/developers/documentation/v3/business_search) to find which parameters you'd like your application to use.

`$params` is an associative array. So for example your params could look like:
```php
$params = [
    'categories' => 'arts',
    'latitude'   => 41.879562,
    'longitude'  => -87.624205,
    'radius'     => 16093,
];
```

Would return businesses under the category 'arts' in downtown Chicago within a ten mile radius (16093 meters).

```php
$yelpData = $this->yelp->search($params, $oauthToken);
$businesses = $yelpData->businesses;
foreach ($businesses as $business) {
    //...
}
```

With `$business` you can now access a business' properties, examples: `$business->name`, `$business->rating`.
