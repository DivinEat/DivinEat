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
        },
        image: {
            class: ImageTool,
            config: {
                endpoints: {
                    byFile: './public/img/uploadedImages' // Your backend file uploader endpoint
                }
            }
        }
    }
});

$("#article-form").submit(function(event) {
    editor.save().then((outputData) => {
        $("input:hidden").val(JSON.stringify(outputData));
    }).catch((error) => {
        console.log('Saving failed: ', error)
    });
});
