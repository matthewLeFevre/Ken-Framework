#Extendable PHP Backend

##Preforming Http/Fetch requests

### Post

```javascript
const data = {
  contoller: "",
  action: "",
  payload:  {
    key: "value"
  }
}
const myInit = {
  method: 'POST',
  headers: {
    'content-Type': 'application/json'
  },
  body: JSON.Stringify(data),
}
fetch("url", myInit)...
```