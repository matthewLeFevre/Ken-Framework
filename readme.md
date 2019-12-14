![Ken Framework Logo](https://github.com/matthewLeFevre/Ken-Framework/blob/master/Ken%20Logo.png)

# Ken Framework

[![GitHub license](https://img.shields.io/github/license/Naereen/StrapDown.js.svg)](https://github.com/matthewLeFevre/Ken-Framework/blob/master/LICENSE) ![version](https://img.shields.io/badge/version-0.6.0-green.svg)

Ken is a simple PHP framework adapted to create custom REST API's. Ken supplies middleware tools to developers to simplify web application creation. In a nutshell Ken uses an api file to handle requests from a client, the request has to be sent with specific criteria to be able to preform an action.

Actions represent a single operation that a user undertakes, this could be registering an account, logging in, or uploading a file.

## Table of Contents

- [Installation](#user-content-installation)
- [Usage](#user-content-usage)
  - [Setup](#user-content-setup)

## Installation

Official installation is through composer.

```
composer require matthewlefevre/Ken-Framework
```

## Usage

Use Ken Framework to create rest applications with php. The following steps can be followed to get started quickly.

### Setup

1. Create an api.php file that follows the pattern in `api.php.example`

```php
<?php

/**
 * Sample Server File
 *
 * This outlines the general structure of the
 * server file.
 */

use KenFramework\Utilities\Ken;

// CSRF (cross-site request forgery) vulnerability
// due to serving spa's on seprate local server for
// development. Remove headers before launching
// product

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Access-Control-Allow-Methods: GET,POST,PUT,DELETE,OPTIONS");

// Always returns JSON to the client
header("Content-Type: application/json");

// Instantiate app
$app = new Ken();
$app->start();
```

2. Require vlucas/phpdotenv package to manage global variables ken uses

```
composer require vlucal/phpdotenv
```

3. Create .env file with the following attributes after the manner of .env.example

```
KEN_SECRET=""
KEN_DB=""
KEN_DB_USER=""
KEN_DB_PASSWORD=""
KEN_SERVER=""
```
