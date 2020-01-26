# Change Log

## v0.7.0

### Alteration to the Endpoint API

- Instead of having to import the response object it is now included in the route callback fundtion parameters.

## v0.6.4 - v0.6.6

### Small Bug Fixes

- Improved route matching
- Gracefully handle null values from the client

## v0.6.3

### Added Controller functionality

- The constructor of a controller now has an options array
- The options array has one possible parameter called route
  - route will be applied to all of the endpoint route strings saving the time of the developer by not forceing them to be repeated

## v0.6.2

### Added clarifying comments

- Comments are not entirely done but more have been added and updated
- The model class can now accept null or an empty array for the \$data parameter and will not throw an error

## v0.6.1

### Changes to binding parameters function

- Fixed a bug where routes that don't have params weren't run

## v0.6.0

### Massive changes to the structure of the library

- Now using PSR-4 autoloading. No need for a massive include file.
- Dispatcher class renamed to model class. Intended to be extended by features to create models.
- Controller class now intended to be extended to describe feature controllers.
- Ken core will be its own project and files have been removed.
- Enviornment variables have been added to securely setup server configuration.
- PHPUnit has been required by composer and will be used to test the library

## v0.5.2

### More In Code Documentation

- Additional comments added to the request object in the ken.php file.
- Response object now sends correct http status codes back to the client instead of always returning 200

## v0.5.1

### Working On Stabalizing API

- Changed controllers
- Reworked endpoint creation

## v0.5.0

### Complete API overhaul

- Actions are now called routes and can be created by specifying get, post, put, or delte in the controller.
- Request parameters are now much simpler to define and are more traditional in use.
- Functionality updates to the dispatcher class.

## v0.4.2

### Updates to Controller Class Input Filtering

- Error with exemptions fixed.

## v0.4.1

### Include and Dispatcher cleanup

- Small cleanup to include file and Dispatcher Class

## v0.4.0

### Improvements to Ken Class and Dispatcher Class

- When token validation is set to true an array of exemption actions can be specified to run them even when a token is not sent with the requests.
- A new isExemptionAction() method has been added to the ken class to be used internally only.
- Added an options array to individual dispatches to provide more capabilities but in doing this boilerplate has increased.
- Added bound variable parsing to Dispatcher class with regular expressions, removing the need to define fields in the class.

## v0.3.1

### Minor Edits to Dispatcher Class

- Added the ability to include all SQL statements to be used on instantiation so that they can be reused throughout the actions.
- Added a helper function to get the SQL statements stored by key.

## v0.3.0

### Updates to JWT Class

- Added the capability to specify claims in JWT Class.
- Added a simplified base 64encoding function to JWT Class.
- Minor edits to Ken Class.
- Added the capability to add more than one exemptions to the Controller::filterPayload().
- Minor changes to Dispatcher Class.

## v0.2.0

### Alpha Dispatcher Class

- Dispatcher class makes database interactions dynamic by drying up the code needed to create models in the PHP generic way.
- Model and controller now can be combined removing the need for a seperate file.
- Removed old code from the framework.

## v0.1.0

### Welcome Ken Framework

- PHP Generic becomes Ken Framework.
- Standard module is removed but will be built into a seperate repository.
- JWT class created to facilitate authentication with JWT's.
