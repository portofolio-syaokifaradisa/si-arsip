function setFileNameUploaded(){
    const fileForm = document.getElementById('uploaded-file-form');
    const fileName = fileForm.value.split('\\').pop();

    document.getElementById('uploaded-file-label').innerHTML = fileName;
}

document.addEventListener("DOMContentLoaded", function(){
    document.getElementById('uploaded-file-form').addEventListener('change', setFileNameUploaded);
});