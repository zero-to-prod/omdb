# Zerotoprod\Omdb

![](art/logo.png)

[![Repo](https://img.shields.io/badge/github-gray?logo=github)](https://github.com/zero-to-prod/omdb)
[![GitHub Actions Workflow Status](https://img.shields.io/github/actions/workflow/status/zero-to-prod/omdb/test.yml?label=tests)](https://github.com/zero-to-prod/omdb/actions)
[![Packagist Downloads](https://img.shields.io/packagist/dt/zero-to-prod/omdb?color=blue)](https://packagist.org/packages/zero-to-prod/omdb/stats)
[![Packagist Version](https://img.shields.io/packagist/v/zero-to-prod/omdb?color=f28d1a)](https://packagist.org/packages/zero-to-prod/omdb)
[![License](https://img.shields.io/packagist/l/zero-to-prod/omdb?color=red)](https://github.com/zero-to-prod/omdb/blob/main/LICENSE.md)
[![wakatime](https://wakatime.com/badge/github/zero-to-prod/omdb.svg)](https://wakatime.com/badge/github/zero-to-prod/omdb)
[![Hits-of-Code](https://hitsofcode.com/github/zero-to-prod/omdb?branch=main)](https://hitsofcode.com/github/zero-to-prod/omdb/view?branch=main)

## Contents

- [Introduction](#introduction)
- [TLDR](#tldr)
- [Requirements](#requirements)
    - [Getting an OMDb API Key](#getting-an-omdb-api-key)
- [Installation](#installation)
- [Usage](#usage)
    - [poster()](#poster)
    - [byIdOrTitle()](#byidortitle)
    - [search()](#search)
    - [Factories](#factories)
    - [Mocking](#mocking)
- [Local Development](#local-development)
    - [Prerequisites](#prerequisites)
    - [Initializing](#initializing)
    - [Testing](#testing)
    - [Configuration](#configuration)
- [Contributing](#contributing)

## Introduction

`Zerotoprod\OmdbApi` is a PHP cURL wrapper for the [OMDb API](https://www.omdbapi.com/) with full object support.
It allows you to search for movies, series, and other media, retrieve detailed information using IMDb IDs or titles, and fetch poster images.

It wraps the [OmdbApi](https://github.com/zero-to-prod/omdb-api) and returns fully hydrated models using the
[OmdbModels](https://github.com/zero-to-prod/omdb-models) package.

## TLDR

```php
use Zerotoprod\Omdb\Omdb;

$Omdb = Omdb::from('apiKey');

// Get the poster art of a title by its ImdbID
$Omdb->poster('tt0499549'); // https://img.omdbapi.com/?apikey=8f8423aa&i=tt0499549

// Find a title by ImdbID (Internet Movie DataBase ID) or title
$Omdb->byIdOrTitle('Avatar')->Title; // 2009

// Find multiple titles
$Omdb->search('Avatar')->Search['tt0499549']->Year; // 2009
```

## Requirements

- PHP 8.1 or higher.
- cURL extension enabled (typically enabled by default in most PHP installations).
- A valid [OMDb API key](https://www.omdbapi.com/apikey.aspx). A free key is typically available.

### Getting an OMDb API Key

1. Go to the [OMDb API website](https://www.omdbapi.com/apikey.aspx).
2. Sign up for a free or paid plan depending on your usage requirements.
3. After registering, you will receive an API Key that you must pass to the OmdbApi class during initialization.

## Installation

Install `Zerotoprod\Omdb` via [Composer](https://getcomposer.org/):

```shell
composer require zero-to-prod/omdb
```

This will add the package to your project’s dependencies and create an autoloader entry for it.

## Usage

Initialization:

```php
use Zerotoprod\Omdb\Omdb;

$Omdb = Omdb::from('apiKey');
```

You can also customize the base URL and the poster URL if you need to (for example, to proxy through another service):

```php
use Zerotoprod\Omdb\Omdb;

$Omdb = Omdb::from(
    apikey: 'apiKey',
    base_url: 'https://www.omdbapi.com/',
    img_url: 'https://img.omdbapi.com/'
);
```

### poster()

Get the poster art of a title by its ImdbID

```php
$Omdb->poster('tt0499549'); // https://img.omdbapi.com/?apikey=8f8423aa&i=tt0499549
```

### byIdOrTitle()

Find a title by ImdbID (Internet Movie DataBase ID) or title.

Returns a [Title DataModel](https://github.com/zero-to-prod/omdb-models/blob/main/src/Title.php).

```php
$Omdb->byIdOrTitle('Avatar')->Title; // 2009
```

### search()

Find multiple titles. Note the `imdbID` value is used as the key for each movie.

Returns a [SearchResults DataModel](https://github.com/zero-to-prod/omdb-models/blob/main/src/SearchResults.php).

```php
$Omdb->search('Avatar')->Search['tt0499549']->Year; // 2009
```

### Factories

You can use the [provided factories](https://github.com/zero-to-prod/omdb-models#factories) without going through the api like this:

```php
\Zerotoprod\OmdbModels\Factories\TitleFactory::factory()->setTitle('Avatar')->make();
```

### Mocking

You can mock the api by implementing
the [Zerotoprod\OmdbApi\OmdbApiInterface](https://github.com/zero-to-prod/omdb-api/blob/main/src/OmdbApiInterface.php):

```php
use Zerotoprod\OmdbApi\OmdbApiInterface;
use Zerotoprod\Omdb\Omdb;

class OmdbApiFake implements OmdbApiInterface
{
    public function search()
}

$Omdb = new Omdb(new OmdbApiFake());

$Omdb->search('Avatar');
```

## Local Development

This project provides a convenient [dock](https://github.com/zero-to-prod/dock) script to simplify local development workflows within Docker
containers.

You can use this script to initialize the project, manage Composer dependencies, and run tests in a consistent PHP environment.

### Prerequisites

- Docker installed and running
- A `.env` file (created automatically via the `dock init` command, if it doesn’t already exist)

### Initializing

Use the following commands to set up the project:

```shell
sh dock init
sh dock composer update
```

### Testing

This command runs PHPUnit inside the Docker container, using the PHP version specified in your `.env` file.
You can modify or extend this script to include additional tests or commands as needed.

```shell
sh dock test
```

Run the test suite with all versions of php:

```shell
sh test.sh
```

### Configuration

Before starting development, verify that your `.env` file contains the correct settings.

You can specify which PHP version to use for local development, debugging, and Composer operations by updating these variables in your `.env` file:

```dotenv
PHP_VERSION=8.1
PHP_DEBUG=8.1
PHP_COMPOSER=8.1
```

Make sure these values reflect the PHP versions you intend to use.
If the `.env` file does not exist, run the `sh dock init` command to create one from the `.env.example` template.

Ensure you have installed all the development dependencies (composer install) before running the tests.

## Contributing

Contributions, issues, and feature requests are welcome!
Feel free to check the [issues](https://github.com/zero-to-prod/omdb/issues) page if you want to contribute.

1. Fork the repository.
2. Create a new branch (`git checkout -b feature-branch`).
3. Commit changes (`git commit -m 'Add some feature'`).
4. Push to the branch (`git push origin feature-branch`).
5. Create a new Pull Request.