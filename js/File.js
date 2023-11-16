document.querySelector("#files").onchange = function() {
    const fileName = this.files[0]?.name;
    const label = document.querySelector("label[for=files]");
    label.innerText = fileName ?? "Browse Files";
  };