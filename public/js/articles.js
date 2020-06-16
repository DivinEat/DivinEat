var editor = new EditorJS({
    /**
     * Id of Element that should contain Editor instance
     */
    holder: editorjs,
    placeholder: 'Ecrivez ici !',
    minHeight: 4,

    /** 
     * Available Tools list. 
     * Pass Tool's class or Settings object for each Tool you want to use 
     */
    tools: {
        header: {
            class: Header,
            shortcut: 'CMD+SHIFT+H',
            config: {
                placeholder: 'Enter a header',
                levels: [1, 2, 3, 4],
                defaultLevel: 1
            }
        },
        list: {
            class: List,
            inlineToolbar: true,
            shortcut: 'CMD+SHIFT+L',
        },
        embed: {
            class: Embed,
        },
        image: {
            class: ImageTool,
            config: {
                endpoints: {
                    byFile: './public/img/uploadedImages' // Your backend file uploader endpoint
                }
            }
        },
        linkTool: {
            class: LinkTool,
            config: {
                endpoint: 'http://localhost:8008/fetchUrl', // Your backend endpoint for url data fetching
            }
        }
    }
});