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

#### Getting API key

Yelp Fusion API uses private API Keys to authenticate requests. In order to set up your access to Yelp Fusion API, you need to create an app with Yelp.

See [Yelp's authentication documentation](https://www.yelp.com/developers/documentation/v3/authentication) for instructions.

#### Search

```php
$params = [
    'categories' => 'arts',
    'latitude'   => 41.879562,
    'longitude'  => -87.624205,
    'radius'     => 16093,
];

$yelpData = $this->yelp->search($params, $apiKey);
$businesses = $yelpData->businesses;
```

See [Yelp's business search documentation](https://www.yelp.com/developers/documentation/v3/business_search) for the list of available search parameters and the shape of the results object.
