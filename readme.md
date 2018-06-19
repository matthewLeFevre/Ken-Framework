# Extendable PHP Backend

## Preforming Http/Fetch requests

### Post

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
}

// Create an object to make the request

const myInit = {
  method: 'POST',
  headers: {
    'content-Type': 'application/json'
  },
  body: JSON.Stringify(data),
}
fetch("url", myInit)...
```