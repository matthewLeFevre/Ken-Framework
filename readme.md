# php_generic

Server side php architecture/framework. Adapted from an MVC method to coincide with SPAs (Single Page Applications) front end frameworks. Can be extended to meet a variety of needs.

## Install php_generic

First time framework creator here and the only way to have access to the server is cloning and downloading this repository. Make sure to have [XAMPP](https://www.apachefriends.org/index.html "Apache Friends Website") (or a similar alternative) installed on your desired operating system.

## Setup

To setup php_generic use the `server.php` as a template. `server.php` is an example of an application including some of the php_generic built in features, these features are optional and do not have to be included in the application.

### Database Connection

Using the [XAMPP](https://www.apachefriends.org/index.html "Apache Friends Website") environment ensure that along with PHP mySQL was also installed by clicking on the enviornment icon. Navigate to PHPMyAdmin and create a new database with your desired name. If you are using the built in features with php_generic you can simply import the `generic_db.sql` file and configure the `src/utilities/db_connect.php` file to point to your local environment.

#### Custom Database Setup

**If you use this method you will be unable to use any of the custom controllers avaliable in php_generic**

After you have installed [XAMPP](https://www.apachefriends.org/index.html "Apache Friends Website") you can create your own database through PHPMyAdmin or as I like to do it through ERD diagrams avaliable in [MySQL Workbench](https://dev.mysql.com/downloads/workbench/ "MySQL Workbench download") and then importing it into PHPMyAdmin. In order to connect to the database you wil need to add your work enviornment details into the `db_connect.php` file avaliable in the `src/utilities/` directory.

### Minimum Code requirements

To get started with the server all you need to do is create a new instance of the server and run the `start()` method once you have added all of your controllers. The `start()` method will begin to listen for any `GET` or `POST` request that is inbound and it will send it to the corresponding controller or it will throw an error.

```php
<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/src/include.php';

$app = new Generic();

// Add controllers to the server
// $app->addController($your_controller);

$app->start();
```


# Talking with the front end

php_generic was built to serve SPAs (Single Page Applications like: Angular, React, and Vue apps) it does not control the front end at all like in more traditional MVC frameworks. This means that in development you will have to enable a few headers so that your front end and back end can talk despite being on different domains. These headers are already enabled in the `server.php` file but just to help explain their purpose I will include the code here as well.

```php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Access-Control-Allow-Methods: GET,POST,PUT,DELETE,OPTIONS");
```

These headers enable the php_generic to share resources with requests from other domains. Do not keep this enabled in production because it poses a significan security vulnerability called CSRF (cross-site request forgery). When using php_generic in production simply swap the `*` for the domain you are using the front end on, this will whitelist all other domain except the one provided.

## Preforming Http/Fetch requests

The `window.fetch` api is the recomended http request method to gain access to php_generic API.

### Generic POST Request Syntax

```javascript

// Create a data object that contains
// 1. a specific controller
// 2. an action for that controller to preform
// 3. the data that controller expects to recieve

const data = {
  contoller: "",
  action: "",
  payload:  {
    key: "value"
  }
};

// Create an object to make the request

const myInit = {
  method: 'POST',
  headers: {
    'content-Type': 'application/json'
  },
  body: JSON.stringify(data)
};

fetch("url", myInit)
// php_generic will respond with JSON
// including success or failure details
.then(response => response.json())
// After you have parsed the json data 
// you may use it wherever you like
.then(data => console.log(data));

```

### Special POST Request Syntax

If you are sending something other than json data to the server to either be stored on the server or in the database you will need to ensure that the data is supported by php_generic and the database. 

#### POST FILE Upload Request

Uploading files is one of the default features of php_generic and it comes included in the base server code, however it does have a special syntax required in javascript to be able to handle the file upload.

```javascript
let fileData = new FormData();

fileData.append('controller', "asset");
fileData.append('action', "createAsset");
fileData.append('userId', "ID of authenticated/validated user");
fileData.append('assetStatus', 'published or saved');
fileData.append('fileUpload', fileInput.files[0]);

const myInit = {
  method: 'POST',
  body: fileData,
};

fetch('url', myInit)
// php_generic will respond with JSON
// including success or failure details
.then(response => response.json())
// After you have parsed the json data 
// you may use it wherever you like
.then(response => console.log("success: ", response));
```