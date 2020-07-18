$(document).ready(function () {
    var submit = document.querySelector("#createArticleForm_submit");
    var inputData = document.querySelector("#createArticleForm_content");

    submit.addEventListener("click", function () {
        inputData.value = tinymce.get("articleContent").getContent();
    });

    tinymce.init({
        selector: "textarea#articleContent",
        height: 500,
        menubar: true,
        plugins: [
            "advlist autolink lists link image charmap print preview anchor",
            "searchreplace visualblocks code fullscreen",
            "insertdatetime media table paste code help wordcount",
        ],
        toolbar:
            "undo redo | formatselect | " +
            "bold italic backcolor | alignleft aligncenter " +
            "alignright alignjustify | bullist numlist outdent indent | " +
            "removeformat | help",
        content_css: "//www.tiny.cloud/css/codepen.min.css",
    });
});