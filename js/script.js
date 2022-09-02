var fileInput = document.getElementById("file");
var buttonText = document.getElementById("SelectFiles");
fileInput.onchange = function () { fileChange() };
//function on any change in FileInput
function fileChange() {
    var FilesList = "";
    var inp = document.getElementById('file');
    if (inp.files.length > 5) {
        alert("Maximum 5 files are allowed!!!");
        buttonText.innerText = "Select Files ( Upto 5 Files )";
        clearFileInput(fileInput);
        return;
    }
    for (var i = 0; i < inp.files.length; ++i) {
        var name = inp.files.item(i).name;
        var fsize = inp.files.item(i).size;
        const fsizeKBs = fsize / 1024;
        if (fsizeKBs > 100) {
            alert("Maximum allowed file size per file is 100K !!!");
            buttonText.innerText = "Select Files ( Upto 5 Files )";
            clearFileInput(fileInput);
            return;
        }
        FilesList = FilesList + "Selected File #" + (i + 1) + " : " + name + " Size : " + fsizeKBs.toFixed(1) + " KB\n";
    }
    if (FilesList !== "") {
        var text = "";
        alert(FilesList);
        if (inp.files.length === 1) {
            text = inp.files.length + " file selected";
        }
        else {
            text = inp.files.length + " files selected";
        }
        buttonText.innerText = text;
    }
}
//function to clear fileInput field
function clearFileInput(element) {
    try {
        element.value = null;
    } catch (ex) { }
    if (element.value) {
        element.parentNode.replaceChild(element.cloneNode(true), element);
    }
}