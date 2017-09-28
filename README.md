# Neighborhoods Yelp-Fusion Library

[![Build Status](https://travis-ci.org/neighborhoods/Yelp-Fusion.svg?branch=master)](https://travis-ci.org/neighborhoods/Yelp-Fusion)

[![Latest Stable Version](https://poser.pugx.org/neighborhoods/yelp-fusion/version)](https://packagist.org/packages/neighborhoods/yelp-fusion)

[![Total Downloads](https://poser.pugx.org/neighborhoods/yelp-fusion/downloads)](https://packagist.org/packages/neighborhoods/yelp-fusion)

[![License](https://poser.pugx.org/neighborhoods/yelp-fusion/license)](https://packagist.org/packages/neighborhoods/yelp-fusion)

A library that interfaces with the Yelp Fusion (v3) API.

## Installation

#### Requirements
* PHP >= 5.6
* Yelp Fusion API credentials

#### Installation

`composer require neighborhoods/yelp-fusion`

## Usage

#### Getting Yelp Bearer Oath Token

Replace `CLIENT_ID` and `CLIENT_SECRET` with _your_ assigned client id and secret.

```php
$yelp = new Yelp();
$oauthTokenData = $yelp->getBearerTokenObject('CLIENT_ID', 'CLIENT_SECRET');
$oauthToken = $oauthTokenData->access_token;
```

`getBearerTokenObject` returns a json object with the properties: `access_token`, `token_type`, and `expires_in`. These are defined in the [Yelp's authentication documentation](https://www.yelp.com/developers/documentation/v3/authentication).

###### Note:

You should cache the token and reuse it until it expires or is revoked.
 
#### Search

```php
$params = [
    'categories' => 'arts',
    'latitude'   => 41.879562,
    'longitude'  => -87.624205,
    'radius'     => 16093,
];

$yelpData = $this->yelp->search($params, $oauthToken);
$businesses = $yelpData->businesses;
```

See [Yelp's business search documentation](https://www.yelp.com/developers/documentation/v3/business_search) for the list of available search parameters and the shape of the results object.