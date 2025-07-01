tinymce.init({
    selector: "#event-description",
    height: 500,
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
    content_style: "body{font-family:Helvetica,Arial,sans-serif; font-size:16px}",
    setup: function (editor) {
        editor.on('change', function (e) {
            const content = editor.getContent();
            const eventDescriptionTextArea = document.getElementById('event-description');
            eventDescriptionTextArea.innerHTML =  content;
            eventDescriptionTextArea.click();
        });
    }
});


