export var editorHandler = {
    editorContainer: null,
    editor: null,
    header: null,
    editBtns: {},
    validateBtn: null,
    textArea: null,
    textValue: null,

    init: function(editorContainer) {

        editorHandler = this;

        editorHandler.editorContainer = editorContainer;
        editorHandler.editor = editorContainer.childNodes[0];


        // Initialisation des attributs
        editorHandler.editor.childNodes.forEach(editorNode => {
            // Noeud du header
            if (editorNode.className == 'txt-editor-header') {
                var header = editorNode;
                editorHandler.header = header;
                header.childNodes.forEach(headerNode => {
                    if (headerNode.classList!= null) {
                        headerNode.classList.forEach(className => {
                            if (className == 'txt-editor-btn-bold' || className == 'txt-editor-btn-italic' || className == 'txt-editor-btn-underline') {
                                var name = null;
                                var char = null;
                                var active = false;
                                var defaultStr = null;
                                var HTMLstart;
                                var HTMLend;
                                switch (className) {
                                    case 'txt-editor-btn-bold':
                                        name = 'bold';
                                        char = '*';
                                        defaultStr = 'Texte en gras';
                                        HTMLstart = '<b>';
                                        HTMLend= '</b>';
                                        break;
                                    case 'txt-editor-btn-italic':
                                        name = 'italic';
                                        char = '-';
                                        defaultStr = 'Texte en italique';
                                        HTMLstart = '<i>';
                                        HTMLend = '</i>';
                                        break;
                                    case 'txt-editor-btn-underline':
                                        name = 'underline';
                                        char = '°';
                                        defaultStr = 'Texte souligné';
                                        HTMLstart = '<u>';
                                        HTMLend = '</u>';
                                        break;
                                
                                    default:
                                        break;
                                }

                                editorHandler.editBtns[name] =
                                {
                                    char: char,
                                    active: active,
                                    node: headerNode,
                                    defaultStr: defaultStr,
                                    HTMLstart: HTMLstart,
                                    HTMLend: HTMLend
                                };

                            }
                        });
                    }
                });
            } else if (editorNode.className == 'txt-editor-text-area') {
                editorHandler.textArea = editorNode;
                editorHandler.textArea.value = editorHandler.convertHTMLtoText(editorHandler.textValue);
                console.log(editorHandler.convertHTMLtoText(editorHandler.textValue));
            } else if (editorNode.className == 'pageBuilder-container-btn-validate') {
                editorHandler.validateBtn = editorNode;
            }

        });

        editorHandler.textArea.disabled = false;
        editorHandler.textArea.placeholder = 'Écris ton texte ici, chef !';
        
        document.addEventListener('selectionchange', function(e) {
            for (var btn in editorHandler.editBtns) {
                editorHandler.updateTransformationBtn(editorHandler.editBtns[btn]);
            };
        });

       for (var btn in editorHandler.editBtns) {
           editorHandler.initHeaderBtn(editorHandler.editBtns[btn]);
        };

        editorHandler.initValidateBtn();

        editorHandler.initOtherBtns();

    },

    initHeaderBtn: function(btn) {
        editorHandler = this;

        btn.node.addEventListener('click', function(e) {
            
            var editor = editorHandler.textArea;
            var startPos = editor.selectionStart;
            var endPos = editor.selectionEnd;
            var start = editor.value.substring(0, startPos);
            var end = editor.value.substring(endPos, editor.value.length);
            var char = btn.char + btn.char;
            
            
            var strBeforeStart = editor.value.substring(startPos, startPos - 2);
            var strBeforeEnd = editor.value.substring(endPos, endPos + 2);
            var str = editor.value.substring(startPos, endPos);


            if (strBeforeStart == char && strBeforeEnd == char) {
                if (str == btn.defaultStr) str = '';
                editor.value = editor.value.substring(0, startPos - 2) + str + editor.value.substring(endPos + 2, editor.value.length);
                editor.selectionStart = startPos - 2;
                editor.selectionEnd = startPos - 2;
                editor.focus();
            } else {
                if ( (startPos == endPos) || btn.active ) {
                    str = btn.defaultStr;
                }                   
                editor.value = start + char + str + char + end;
                editor.selectionStart = startPos + 2;
                editor.selectionEnd = startPos + 2 + str.length;
                editor.focus();
            }
        });
    
    },

    /*
     * Pour savoir le texte sélectionné est transformé (gras, italique, soulingé)
     * @param char : caractère  de délimitation de la transformation
     * @return boolean : informant si le texte est transformé
     */
    isTextTransormed: function(char) {
        var editorHandler = this;
        var editor = editorHandler.textArea;
        var startPos = editor.selectionStart;
        var endPos = editor.selectionEnd;

        var isTrans1 = false;
        var isTrans2 = false;

        var charBeforeStart = editor.value.substring(startPos, startPos - 1);
        var charAfterStart  = editor.value.substring(startPos, startPos + 1);
        var charBeforeEnd  = editor.value.substring(endPos, endPos - 1);
        var charAfterEnd  = editor.value.substring(endPos, endPos + 1);

        if ((charBeforeStart == char && charAfterStart == char) || (charBeforeEnd == char && charAfterEnd == char) ) {
            return false;
        }

        for (let i = endPos; i < editor.value.length; i++) {
            if (editor.value.substring(i, i + 1) == char) {
                if (editor.value.substring(i + 1, i + 2) == char) {
                    isTrans1 = isTrans1 ? false : true;
                } else {
                    i += 2;
                }
            }
        }

        if (!isTrans1) return false;
        
        for (let i = startPos; i > 0; i--) {
            if (editor.value.substring(i, i - 1) == char) {
                if (editor.value.substring(i - 1, i - 2) == char) {
                    isTrans2 = isTrans2 ? false : true;
                } else {
                    i -= 2;
                }
            }
        }
        
        return isTrans2;
    },

    /*
     * Permet de mettre à jour le statut et la class des boutons de transformation
     * @param btn : le bouton de transformation de texte
     */
    updateTransformationBtn: function(btn) {
        var isTransformed = editorHandler.isTextTransormed(btn.char);

        if (isTransformed && !btn.active) {
            btn.node.className = btn.node.className.replace('inactive', 'active');
            btn.active = true;
        } else if (!isTransformed && btn.active) {
            btn.node.className = btn.node.className.replace('active', 'inactive');
            btn.active = false;
        }
    },

    initValidateBtn() {
        var editorHandler = this;
        var validateBtn = editorHandler.validateBtn;
        var textArea = editorHandler.textArea;
        var editorContainer = editorHandler.editorContainer;
        var editor = editorHandler.editor;
        
        validateBtn.addEventListener('click', function(e) {
            
            editorContainer.removeChild(editor);

            editorHandler.textValue = editorHandler.convertTextToHTML(textArea.value);
            editorContainer.innerHTML += editorHandler.textValue;
            editorHandler.addEditBtn(editorContainer);

        });
        
    },

    addEditBtn: function(container) {
        var editorHandler = this;
        var editBtn = document.createElement('div');
        editBtn.className = 'pageBuilder-container-btn-edit';
        container.appendChild(editBtn);

        editBtn.addEventListener('click', function (e) {
            var xmlhttp = new XMLHttpRequest();
            var textAreaEditorHTML;
            var toolsBar;

            xmlhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                        
                    textAreaEditorHTML = this.responseText;
                    container.removeChild(editBtn);
                    container.childNodes.forEach(node => {
                        if (node.className && node.className.includes('tools-bar')) {
                            toolsBar = node;
                        }
                    });

                    container.innerHTML = textAreaEditorHTML;
                    container.appendChild(toolsBar);

                    editorHandler.init(container);
                }
            };

            xmlhttp.open("GET", "page-builder-get-editor", true);
            xmlhttp.send();
        });
    },

    convertTextToHTML: function(text) {

        
        var editBtns = editorHandler.editBtns;
        
        for (let i = 0 ; i < text.length ; i++) {
            
            for (var btn in editBtns) {
                if (text[i] == editBtns[btn].char && text[i + 1] == editBtns[btn].char) {
                    if (!editBtns[btn].active) {
                        text = text.substring(0, i) + editBtns[btn].HTMLstart + text.substring(i + 2, text.length);
                        editBtns[btn].active = true;
                        i += editBtns[btn].HTMLstart.length;
                    } else {
                        text = text.substring(0, i) + editBtns[btn].HTMLend + text.substring(i + 2, text.length);
                        editBtns[btn].active = false;
                        i += editBtns[btn].HTMLend.length;
                    }
                }
            }
        }
        
        // text = text.replace(/\n/g, '<br>');
        text = '<pre>' + text + '</pre>'
        
        return text;
    },

    convertHTMLtoText: function(text) {

        if (text == null) {
            return null;
        }

        text = text.replace(/<pre>/g, '');
        text = text.replace(/<\/pre>/g, '');

        return text;
    },

    initOtherBtns: function() {

    }
};
