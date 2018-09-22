const fileInput = document.getElementById("imageUpload");
const fileUpBtn = document.getElementById("imageUploadButton");
const url = 'http://site2/server.php';
const testUrl = 'http://site2/src/classes/generic.php';



// image upload
fileUpBtn.addEventListener("click", function() {
  let formData = new FormData();

  formData.append('controller', "asset");
  formData.append('action', "createAsset");
  formData.append('userId', "1");
  formData.append('assetStatus', "saved");
  formData.append('fileUpload', fileInput.files[0]);

  fetch( url, {
    method: 'POST',
    body: formData,
  })
  .then(response => response.json())
  .catch(error => console.error('error:', error))
  .then(response => console.log("success:", response));

});

//createArticle
function createArticle () {
  let data = {
    controller: "article",
    action: "createArticle",
    payload: {
      'articleTitle': makeWord(12),
      'articleSummary': makeSentence(20),
      'articleBody': makeParagraph(6),
      'articleStatus': 'published',
      'articleLink': 'www.google.com',
      'articleImage': 'null',
      'userId': '1'
    }
  }
  let req = {
    method: 'POST',
    headers: {
      "Content-Type": "application/json",
      "Accept": "application/json"
    },

    body: JSON.stringify(data),
  }

  fetch(url, req)
  .then(response => response.json())
  .then(data => console.log(data));
}

function createProject () {
  let data = {
    controller: "project",
    action: "createProject",
    payload: {
      'projectTitle': makeWord(12),
      'projectStatus': 'published',
      'userId': '1'
    }
  }
  let req = {
    method: 'POST',
    headers: {
      "Content-Type": "application/json",
      "Accept": "application/json"
    },

    body: JSON.stringify(data),
  }

  fetch(url, req)
  .then(response => response.json())
  .then(data => console.log(data));
}

function createStyleGuide () {
  let data = {
    controller: "styleGuide",
    action: "createStyleGuide",
    payload: {
      'styleGuideTitle': makeWord(12),
      'styleGuideStatus': 'published',
      'projectId': '11'
    }
  }
  let req = {
    method: 'POST',
    headers: {
      "Content-Type": "application/json",
      "Accept": "application/json"
    },

    body: JSON.stringify(data),
  }

  fetch(url, req)
  .then(response => response.json())
  .then(data => console.log(data));
}

function makeWord(length) {
  var word = "";
  var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
  let wordLength = Math.floor(Math.random() * length) + 1;

  for (let i = 0; i < wordLength; i++) {
    word += possible.charAt(Math.floor(Math.random() * possible.length));
  }
    

  return word;
}

function makeSentence(length) {
  let sentence = "";
  let sentenceLength = Math.floor(Math.random() * length) + 4;

  for( let i = 0; i < sentenceLength; i++) {
    sentence += " " + makeWord(12);
  }

  sentence += ".";

  return sentence;
}

function makeParagraph(length) {
  let para = " ";
  
  for( let i = 0; i < length; i++) {
    para += " " + makeSentence(12);
  }

  return para;
}

function testController() {
  let data = {
    controller: "testController",
    action: "test",
    payload: {
      conductTest: "blueheron",
      testPhp: "test success",
      action: "test",
    }
  }
  let req = {
    method: 'POST',
    headers: {
      "Content-Type": "application/json",
      "Accept": "application/json"
    },

    body: JSON.stringify(data),
  }

  fetch(url, req)
  .then(response => response.json())
  .then(data => console.log(data));
}

// Get articles request syntax
// fetch(url + "?controller=article&action=getNumberOfArticles&articleNumber=5")
// .then(response => response.json())
// .then(data => console.log(data));

fetch(url + "?controller=project&action=getProjectById&projectId=11")
.then(response => response.json())
.then(data => console.log(data));

function assignAsset () {
  const assignedId = document.getElementById('articleId').value;
  const assetId = document.getElementById('assetId').value;
  const assignedTable = "article";

  const data = {
    controller: "asset",
    action: "assignAsset",
    payload: {
      assignedId: assignedId,
      assetId: assetId,
      assignedTable: assignedTable
    }
  }

  const myInit = {
    method: 'POST',
    headers: {
      'content-Type': 'application/json'
    },
    body: JSON.stringify(data),
  }

  fetch(url, myInit)
  .then(response => response.json())
  .then(data => console.log(data));
}


function oopTest() {
  const reqStr = doucment.getElementById('ooptest').value;
  const data = {
    controller: "test",
    action: "print",
    payload: reqStr,
  }

  const myInit = {
    method: 'POST',
    headers: {
      'content-Type': 'application/json'
    },
    body: JSON.stringify(data),
  }

  fetch(testUrl, myInit)
  .then(response => response.json())
  .then(data => console.log(data));
}