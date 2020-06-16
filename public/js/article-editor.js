var editorContent = document.querySelector("#editor-content").value;
editorContent = editorContent.replace(/'/g, "\"");

var editor = new EditorJS({
    holderId: articlejs,
    placeholder: 'Ecrivez ici !',
    minHeight: 4,

    tools: {
        header: {
            class: Header,
            config: {
                placeholder: 'Enter a header',
                levels: [1, 2, 3, 4],
                defaultLevel: 1
            }
        },
        list: {
            class: List,
            inlineToolbar: true
        },
        embed: {
            class: Embed,
            inlineToolbar: false,
            config: {
                youtube: true,
                coub: true
            }
        }
    }
});

$("#article-form").submit(function(event) {
    editor.save().then((outputData) => {
        $("#editor-content").val(JSON.stringify(outputData).replace(/"/g, "'"));
    }).catch((error) => {
        console.log('Saving failed: ', error)
    });
});
