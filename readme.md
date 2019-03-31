# Ken Framework v0.1.1

Ken is a simple PHP framework adapted to create custom REST API's. Ken supplies a suite of middleware tools to developers to simplify web application creation. In a nutshell Ken uses a server file to handle requests from a client, the request has to be sent with specific criteria to be able to preform an action.

Actions represent a single operation that a user undertakes, this could be registering an account, logging in, or uploading a file.

# Change Log

## v0.1.1

### Alpha Dispatcher Class

- Dispatcher class makes database interactions dynamic be drying up the code needed to create models in the PHP generic way.
- Model and controller now can be combined removing the need for a seperate file

## v0.1.0

### Welcome Ken Framework

- PHP Generic becomes Ken Framework
- Standard module is removed but will be built into a seperate repository
- JWT class created to facilitate authentication with JWT's