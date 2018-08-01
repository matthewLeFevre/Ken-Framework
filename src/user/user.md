# User Controller Documentation

## Index

### Actions
  - loginUser (passing)
  - checkLogin (untested)
  - logoutUser (untested)
  - registerUser (retest)
  - updateUser (unfinished)
  - updateUsePassword (unfinished)
  - deleteUser (unfinished)

### Login User

`loginUser` is a `POST` action that authenticates the user and returns data about that authenticated user to the client.

#### Request Syntax

```javascript
const data = {
  userName: "your requestor userName",
  userPassword: "your requestor userPassword"
}

const myInit = {
  
}
```

#### Successful Response

```javascript
{
  userId,
  userName,
  userEmail,
  apiToken,
}
```

The `apiToken` will only be returned on servers configured for token validation.

### check Login 

`checkLogin` is a `GET` request that can be make by the client to verify if there is still an active session for an authenticated user. If there is then the data of that user is sent to the client and it is made avaliable.

#### Successful Response

**See Login User**

### Logout User

`logoutUser` is a `POST` request that can be made by the client to __logout__ a user. Returns only a confirmation message.

#### Request Syntax

```javascript
const data = {
  userName: "your requestor userName",
  userPassword: "your requestor userPassword"
}

const myInit = {
  
}
```

### Register User

`registerUser` is a `POST` request that can be made by the client to create a new user account in the database. 

#### Request Syntax

```javascript
const data = {
  userName: "your requestor userName",
  userPassword: "your requestor userPassword"
}

const myInit = {
  
}
```
