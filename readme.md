# Ken Framework v0.6.0

Ken is a simple PHP framework adapted to create custom REST API's. Ken supplies middleware tools to developers to simplify web application creation. In a nutshell Ken uses an api file to handle requests from a client, the request has to be sent with specific criteria to be able to preform an action.

Actions represent a single operation that a user undertakes, this could be registering an account, logging in, or uploading a file.

# Change Log

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
