![Ken Framework Logo](https://github.com/matthewLeFevre/Ken-Framework/blob/master/Ken%20Logo.png)

# Ken Framework

[![GitHub license](https://img.shields.io/github/license/Naereen/StrapDown.js.svg)](https://github.com/matthewLeFevre/Ken-Framework/blob/master/LICENSE) ![version](https://img.shields.io/badge/version-0.6.3-green.svg)

Ken is a simple PHP framework adapted to create custom REST API's. Ken supplies middleware tools to developers to simplify web application creation.

## Table of Contents

- [Installation](#user-content-installation)
- [Usage](#user-content-usage)
  - [Setup](#user-content-setup)
- [Contributing](#user-content-contributing)
- [License](#user-content-license)

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

4. Ensure that you have phpMyAdmin installed and configured in your local enviornment. The built in model class is only compatable with mySQL.

- Create a new database
- Fill in the correct enviornment variables

5. If you have XAMPP installed either require composer into your htdocs folder. If you don't have XAMPP installed or do not want to run the server on localhost be sure to create virtual hosts on your operating system and in your apache server configuration.

## Contributing

Pull requests are welcome!

## License

Take a look at the `LICENSE.md`
