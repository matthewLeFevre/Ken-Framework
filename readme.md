# Ken Framework v0.3.1

Ken is a simple PHP framework adapted to create custom REST API's. Ken supplies a suite of middleware tools to developers to simplify web application creation. In a nutshell Ken uses a server file to handle requests from a client, the request has to be sent with specific criteria to be able to preform an action.

Actions represent a single operation that a user undertakes, this could be registering an account, logging in, or uploading a file.

# Change Log

## v0.3.1

### Minor Edits to Dispatcher Class

  - Added the ability to include all SQL statements to be used on instantiation so that they can be reused throughout the actions.
  - Added a helper function to get the SQL statements stored by key

## v0.3.0

### Updates to JWT Class

  - Added the capability to specify claims in JWT Class
  - Added a simplified base 64encoding function to JWT Class
  - Minor edits to Ken Class
  - Added the capability to add more than one exemptions to the Controller::filterPayload()
  - Minor changes to Dispatcher Class

## v0.2.0

### Alpha Dispatcher Class

- Dispatcher class makes database interactions dynamic by drying up the code needed to create models in the PHP generic way.
- Model and controller now can be combined removing the need for a seperate file
- Removed old code from the framework

## v0.1.0

### Welcome Ken Framework

- PHP Generic becomes Ken Framework
- Standard module is removed but will be built into a seperate repository
- JWT class created to facilitate authentication with JWT's