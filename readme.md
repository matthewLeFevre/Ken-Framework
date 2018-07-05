# Extendable PHP Backend

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