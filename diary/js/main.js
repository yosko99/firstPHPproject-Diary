const textarea = document.querySelector(".textArea");

const xhr = new XMLHttpRequest();

let formdata = new FormData();

textarea.addEventListener("keyup", (e) => {
  xhr.onreadystatechange = function () {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 0 || (xhr.status >= 200 && xhr.status < 400)) {
        formdata.append("text", textarea.value);
      } else {
        alert("Failed");
      }
    }
  };
  xhr.open("POST", "addText.php", true);
  xhr.send(formdata);
});
