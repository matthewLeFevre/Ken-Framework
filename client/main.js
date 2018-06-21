const fileInput = document.getElementById("imageUpload");
const fileUpBtn = document.getElementById("imageUploadButton");
const url = 'http://site2/server.php';


// image upload
fileUpBtn.addEventListener("click", function() {
  let formData = new FormData();

  formData.append('controller', "asset");
  formData.append('action', "createAsset");
  formData.append('userId', "1");
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