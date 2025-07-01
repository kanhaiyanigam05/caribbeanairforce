tinymce.init({
    selector: "#template-editor",
    plugins: [
        "advlist",
        "autolink",
        "link",
        "image",
        "lists",
        "charmap",
        "preview",
        "anchor",
        "pagebreak",
        "searchreplace",
        "wordcount",
        "visualblocks",
        "code",
        "fullscreen",
        "insertdatetime",
        "media",
        "table",
        "emoticons",
        "codesample",
        "importcss",
        "template",
    ],
    toolbar:
        "undo redo | styles | bold italic underline | alignleft aligncenter alignright alignjustify |" +
        "bullist numlist outdent indent | link image | print preview media fullscreen | " +
        "forecolor backcolor emoticons",
    menu: {
        favs: {
            title: "Menu",
            items: "code visualaid | searchreplace | emoticons",
        },
    },
    menubar: "favs file edit view insert format tools table",
    content_style:
        "body{font-family:Helvetica,Arial,sans-serif; font-size:16px}",
    setup: function (editor) {
        editor.on("change", function (e) {
            const content = editor.getContent();
            const eventDescriptionTextArea =
                document.getElementById("template-editor");
            eventDescriptionTextArea.innerHTML = content;
        });
    },
});

document.addEventListener("DOMContentLoaded", function () {
    const buttons = document.querySelectorAll("button[data-value]");

    buttons.forEach((button) => {
        button.addEventListener("click", function () {
            const buttonValue = button.getAttribute("data-value"); // Get the value from the button
            const editor = tinymce.get("template-editor"); // Get the TinyMCE editor instance
            editor.insertContent(buttonValue); // Insert the button value into the editor content
        });
    });
});
