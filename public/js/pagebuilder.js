$(document).ready(function () {
    var pageBuilder = {
        page: null,
        container: null,
        pageData: {
            page: { previous: null, parent: null, first: null, last: null, next: null },
        },
        containerId: 0,
        rowId: 0,
        editorId: 0,
        newTopRowBtn: null,
        newBottomRowBtn: null,

        init: function () {
            pageBuilder.page = document.querySelector(".page");
            var newContainerBtn = document.querySelector(".pageBuilder-btn-add");
            var submit = document.querySelector("#createPageForm_submit");
            var inputData = document.querySelector("#createPageForm_data");

            submit.addEventListener("click", function () {
                inputData.value = pageBuilder.getDataPage();
            });

            newContainerBtn.addEventListener("click", function (e) {
                var container = newContainerBtn.parentNode;
                var structureBar = pageBuilder.createStructureBtnBar(container);
                pageBuilder.addEventsToFirstRowStructureBtn(structureBar, container);
            });
        },

        getDataPage: function () {
            pageData = pageBuilder.pageData;

            Object.keys(pageData).forEach(function (key) {
                if (pageData[key].node !== undefined) delete pageData[key].node;
            });

            return JSON.stringify(this.pageData);
        },

        createStructureBtnBar: function (container) {
            var structureBtnBar = document.createElement("div");
            var cancelBtn = document.createElement("div");
            var containerContent = [];

            container.childNodes.forEach((node) => {
                containerContent.push(node);
            });

            container.textContent = "";
            structureBtnBar.className = "pageBuilder-container-list-structure-bar";

            cancelBtn.className = "pageBuilder-btn-cancel";

            for (let i = 0; i < 7; i++) {
                var btn = document.createElement("div");

                switch (i) {
                    case 0:
                        btn.className = "pageBuilder-container-structure-btn-12";
                        break;
                    case 1:
                        btn.className = "pageBuilder-container-structure-btn-6_6";
                        break;
                    case 2:
                        btn.className = "pageBuilder-container-structure-btn-4_4_4";
                        break;
                    case 3:
                        btn.className = "pageBuilder-container-structure-btn-3_3_3_3";
                        break;
                    case 4:
                        btn.className = "pageBuilder-container-structure-btn-3_6_3";
                        break;
                    case 5:
                        btn.className = "pageBuilder-container-structure-btn-6_3_3";
                        break;
                    case 6:
                        btn.className = "pageBuilder-container-structure-btn-3_3_6";
                        break;
                }

                structureBtnBar.appendChild(btn);
            }

            container.appendChild(structureBtnBar);
            container.appendChild(cancelBtn);

            cancelBtn.addEventListener("click", function (e) {
                container.textContent = "";
                containerContent.forEach((node) => {
                    container.appendChild(node);
                });
            });

            return structureBtnBar;
        },

        addEventsToFirstRowStructureBtn: function (structureBtnBar, btnContainer) {
            var pageBuilder = this;
            var page = pageBuilder.page;
            var pageData = pageBuilder.pageData;
            var containerParent = btnContainer.parentNode;

            structureBtnBar.childNodes.forEach((strucureBtn) => {
                strucureBtn.addEventListener("click", function () {
                    containerParent.removeChild(btnContainer);

                    var className = this.className.substring(36);
                    var colsSize = className.split("_");

                    var parentRow = document.createElement("div");
                    parentRow.className = "row padding-0";
                    containerParent.appendChild(parentRow);
                    pageBuilder.setRowId(parentRow);

                    pageData.page.first = parentRow.id;
                    pageData.page.last = parentRow.id;
                    pageData[parentRow.id].parent = "page";
                    pageData[parentRow.id].node = parentRow;

                    var rowContainerList = [];

                    colsSize.forEach((colSize) => {
                        container = pageBuilder.createNewContainer(parentRow, colSize);

                        rowContainerList.push(container.id);
                        pageData[parentRow.id].parent = "page";
                    });

                    var container;
                    pageData[parentRow.id].first = rowContainerList[0];
                    pageData[parentRow.id].last = rowContainerList[rowContainerList.length - 1];
                    for (let i = 0; i < rowContainerList.length; i++) {
                        container = rowContainerList[i];

                        if (rowContainerList[i + 1] !== undefined) {
                            pageData[container].next = rowContainerList[i + 1];
                            pageData[rowContainerList[i + 1]].previous = container;
                        }
                    }

                    newRowBtnBottom = document.createElement("div");
                    newRowBtnBottom.className = "pageBuilder-btn-new-top";
                    newRowContainerBottom = pageBuilder.createContainer(newRowBtnBottom);
                    pageBuilder.newBottomRowBtn = newRowContainerBottom;
                    page.append(newRowContainerBottom);
                    pageBuilder.addEventToAddRowBtn(newRowBtnBottom, newRowBtnBottom.parentNode, "before");

                    newRowBtnTop = document.createElement("div");
                    newRowBtnTop.className = "pageBuilder-btn-new-bottom";
                    newRowContainerTop = pageBuilder.createContainer(newRowBtnTop);
                    pageBuilder.newTopRowBtn = newRowContainerTop;
                    page.prepend(newRowContainerTop);
                    pageBuilder.addEventToAddRowBtn(newRowBtnTop, newRowBtnTop.parentNode, "after");
                    console.log(pageBuilder.pageData);
                });
            });
        },

        // @div : la div après/avant laquelle sera placée la new Row
        addEventToAddRowBtn: function (btn, div, param) {
            var pageBuilder = this;
            var pageData = pageBuilder.pageData;

            btn.addEventListener("click", function () {
                var btnContainer = this.parentNode;
                var containerContent = [];

                btnContainer.childNodes.forEach((node) => {
                    containerContent.push(node);
                });

                var structureBtnBar = pageBuilder.createStructureBtnBar(btnContainer);

                structureBtnBar.childNodes.forEach((strucureBtn) => {
                    strucureBtn.addEventListener("click", function () {
                        var className = this.className.substring(36);
                        var colsSize = className.split("_");
                        var parentRow = document.createElement("div");
                        parentRow.className = "row padding-0";

                        pageBuilder.setRowId(parentRow);

                        var mainRow =
                            div.parentNode.id == "page"
                                ? (mainRow = div.parentNode)
                                : div.parentNode.parentNode.parentNode;

                        pageData[parentRow.id].parent = mainRow.id;
                        pageData[parentRow.id].node = parentRow;
                        if (div == pageBuilder.newTopRowBtn || div == pageBuilder.newBottomRowBtn) {
                            if (param == "after") {
                                var oldFirstElement = pageData[mainRow.id].first;
                                if (null !== oldFirstElement) {
                                    pageData[parentRow.id].previous = null;
                                    pageData[parentRow.id].next = oldFirstElement;
                                    pageData[oldFirstElement].previous = parentRow.id;
                                } else {
                                    pageData[mainRow.id].last = parentRow.id;
                                }
                                pageData[mainRow.id].first = parentRow.id;
                            }
                            if (param == "before") {
                                var oldLastElement = pageData[mainRow.id].last;

                                if (null !== oldLastElement) {
                                    pageData[parentRow.id].next = null;
                                    pageData[parentRow.id].previous = oldLastElement;
                                    pageData[oldLastElement].next = parentRow.id;
                                } else {
                                    pageData[mainRow.id].first = parentRow.id;
                                }
                                pageData[mainRow.id].last = parentRow.id;
                            }
                            console.log(pageData);
                        } else {
                            if (param == "after") {
                                if (null == pageData[div.id].next) {
                                    pageData[parentRow.id].next = null;
                                    pageData[mainRow.id].last = parentRow.id;
                                } else {
                                    var oldNext = pageData[div.id].next;
                                    pageData[oldNext].previous = parentRow.id;
                                    pageData[parentRow.id].next = oldNext;
                                }
                                pageData[div.id].next = parentRow.id;
                                pageData[parentRow.id].previous = div.id;
                            }
                            if (param == "before") {
                                if (null == pageData[div.id].previous) {
                                    pageData[parentRow.id].previous = null;
                                    pageData[mainRow.id].first = parentRow.id;
                                } else {
                                    var oldPrevious = pageData[div.id].previous;
                                    pageData[oldPrevious].next = parentRow.id;
                                    pageData[parentRow.id].previous = oldPrevious;
                                }
                                pageData[div.id].previous = parentRow.id;
                                pageData[parentRow.id].next = div.id;
                            }
                        }

                        var rowContainerList = [];

                        colsSize.forEach((colSize) => {
                            container = pageBuilder.createNewContainer(parentRow, colSize);

                            rowContainerList.push(container.id);
                            if (param == "after") {
                                div.after(parentRow);
                            }

                            if (param == "before") {
                                div.before(parentRow);
                            }

                            btnContainer.textContent = "";
                            containerContent.forEach((node) => {
                                btnContainer.appendChild(node);
                            });
                        });

                        var container;
                        pageData[parentRow.id].first = rowContainerList[0];
                        pageData[parentRow.id].last = rowContainerList[rowContainerList.length - 1];
                        console.log(rowContainerList);
                        for (let i = 0; i < rowContainerList.length; i++) {
                            container = rowContainerList[i];

                            if (rowContainerList[i + 1] !== undefined) {
                                pageData[container].next = rowContainerList[i + 1];
                                pageData[rowContainerList[i + 1]].previous = container;
                            }
                        }
                    });
                });
            });
        },

        addEventsToNewStructureBtn: function (structureBtnBar, oldContainer) {
            var pageBuilder = this;
            var containerParent = oldContainer.parentNode;
            var mainCol = containerParent.parentNode;
            var mainRow = mainCol.parentNode;
            var pageData = pageBuilder.pageData;
            var firstChild = null;
            var nextChild = null;

            structureBtnBar.childNodes.forEach((btn) => {
                btn.addEventListener("click", function (e) {
                    var className = this.className.substring(36);
                    var colsSize = className.split("_");
                    var parentRow = document.createElement("div");

                    containerParent.removeChild(oldContainer);
                    containerParent.appendChild(parentRow);
                    parentRow.className = "row padding-0";
                    pageBuilder.setRowId(parentRow);

                    pageData[parentRow.id].parent = mainRow.id;
                    pageData[parentRow.id].node = parentRow;
                    pageData[parentRow.id].type = 'childRow';
                    pageData[parentRow.id].class = mainCol.className;

                    firstChild = pageData[mainRow.id].first;
                    pageData[mainRow.id].first = parentRow.id;

                    if (null === pageData[firstChild].next) {
                        pageData[mainRow.id].last = parentRow.id;
                    } else {
                        nextChild = pageData[firstChild].next;
                        pageData[nextChild].previous = parentRow.id;
                        pageData[parentRow.id].next = nextChild;
                    }

                    delete pageData[firstChild];

                    console.log(pageBuilder.pageData);

                    var rowContainerList = [];

                    colsSize.forEach((colSize) => {
                        container = pageBuilder.createNewContainer(parentRow, colSize);
                        rowContainerList.push(container.id);
                    });

                    var container;
                    pageData[parentRow.id].first = rowContainerList[0];
                    pageData[parentRow.id].last = rowContainerList[rowContainerList.length - 1];
                    for (let i = 0; i < rowContainerList.length; i++) {
                        container = rowContainerList[i];

                        if (rowContainerList[i + 1] !== undefined) {
                            pageData[container].next = rowContainerList[i + 1];
                            pageData[rowContainerList[i + 1]].previous = container;
                        }
                    }
                });
            });
        },

        createNewContainer: function (parentRow, colSize) {
            let pageData = pageBuilder.pageData;
            let col = document.createElement("div");
            let colInner = document.createElement("div");
            let container = document.createElement("div");
            let addBtn = document.createElement("div");
            let removeBtn = document.createElement("div");
            let newTopContainerBtn = document.createElement("div");
            let newBottomContainerBtn = document.createElement("div");

            col.className = "col-sm-" + colSize + " padding-0";
            colInner.className = "col-inner padding-top-0";
            container.className = "pageBuilder-container-empty";
            addBtn.className = "pageBuilder-btn-add";
            removeBtn.className = "pageBuilder-btn-remove";
            newTopContainerBtn.className = "pageBuilder-btn-new-top";
            newBottomContainerBtn.className = "pageBuilder-btn-new-bottom";

            pageBuilder.addEventToAddRowBtn(newBottomContainerBtn, parentRow, "after");
            pageBuilder.addEventToAddRowBtn(newTopContainerBtn, parentRow, "before");

            container.appendChild(newTopContainerBtn);
            container.appendChild(newBottomContainerBtn);
            container.appendChild(addBtn);
            container.appendChild(removeBtn);
            colInner.appendChild(container);
            col.appendChild(colInner);
            parentRow.appendChild(col);

            pageBuilder.setContainerId(container);

            pageData[container.id].parent = parentRow.id;
            pageData[container.id].node = container;

            addBtn.addEventListener("click", function () {
                var btnContainer = this.parentNode;
                var containerContent = [];
                var addItemBtn = document.createElement("div");
                var newStructureBtn = document.createElement("div");
                var cancelBtn = document.createElement("div");

                btnContainer.childNodes.forEach((node) => {
                    containerContent.push(node);
                });

                btnContainer.textContent = "";

                addItemBtn.className = "pageBuilder-btn-add";
                newStructureBtn.className = "pageBuilder-container-structure-btn-small";

                cancelBtn.className = "pageBuilder-btn-cancel";

                container.appendChild(addItemBtn);
                container.appendChild(newStructureBtn);
                container.appendChild(cancelBtn);

                newStructureBtn.addEventListener("click", function (e) {
                    var structureBtnBar = pageBuilder.createStructureBtnBar(container);
                    pageBuilder.addEventsToNewStructureBtn(structureBtnBar, container);
                });

                cancelBtn.addEventListener("click", function (e) {
                    btnContainer.textContent = "";
                    containerContent.forEach((node) => {
                        btnContainer.appendChild(node);
                    });
                });

                pageBuilder.addEventToItemBtn(addItemBtn);
            });

            removeBtn.addEventListener("click", function () {
                pageBuilder.deleteContainer(container);
            });

            return container;
        },

        addEventToItemBtn: function (btn) {
            pageBuilder = this;
            container = btn.parentNode;

            btn.addEventListener("click", function (event) {
                var btnContainer = this.parentNode;
                var containerContent = [];
                var structureBtnBar = document.createElement("div");
                var addEditorBtn = document.createElement("div");
                var cancelBtn = document.createElement("div");

                btnContainer.childNodes.forEach((node) => {
                    containerContent.push(node);
                });

                structureBtnBar.className = "pageBuilder-container-list-structure-bar";
                addEditorBtn.className = "pageBuilder-container-new-item-btn";
                cancelBtn.className = "pageBuilder-btn-cancel";

                container.textContent = "";
                structureBtnBar.appendChild(addEditorBtn);
                container.appendChild(structureBtnBar);
                container.appendChild(cancelBtn);
                pageBuilder.addEditor(addEditorBtn);

                cancelBtn.addEventListener("click", function (e) {
                    btnContainer.textContent = "";
                    containerContent.forEach((node) => {
                        btnContainer.appendChild(node);
                    });
                });
            });
        },

        createContainer: function (content = null) {
            var pageBuilder = this;
            var row = document.createElement("div");
            var col = document.createElement("div");
            var colInner = document.createElement("div");
            var container = document.createElement("div");

            row.className = "row padding-0";
            col.className = "col-sm-12 padding-0";
            colInner.className = "col-inner";
            container.className = "pageBuilder-container-hidden";

            row.appendChild(col);
            col.appendChild(colInner);
            colInner.appendChild(container);

            if (content != null) container.append(content);

            container.addEventListener("mouseenter", function (e) {
                pageBuilder.container = this;
            });
            container.addEventListener("mouveleave", function (e) {
                pageBuilder.container = null;
            });

            return container;
        },

        addEditor: function (btn) {
            var pageBuilder = this;
            container = btn.parentNode.parentNode;

            btn.addEventListener("click", function (event) {
                container.textContent = "";

                var editor = pageBuilder.initEditor(container);

                pageBuilder.addEditorBtns(editor, container);
            });
        },

        initEditor: function (container) {
            var editorId = "editor-" + this.editorId;
            this.editorId++;

            var textArea = document.createElement("textarea");
            textArea.id = editorId;

            container.appendChild(textArea);

            tinymce.init({
                selector: "textarea#" + editorId,
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

            return tinymce.get(editorId);
        },

        addEditorBtns: function (editor, container) {
            var pageData = pageBuilder.pageData;
            var getData = document.createElement("div");
            var remove = document.createElement("div");

            remove.className = "pageBuilder-btn-remove";
            getData.className = "pageBuilder-btn-validate";

            container.appendChild(remove);
            container.appendChild(getData);

            getData.addEventListener("click", function () {
                var editorContent = editor.getContent();
                var divContent = document.createElement("div");

                editor.destroy();

                divContent.className = "content-editor";
                divContent.innerHTML = editorContent;

                container.textContent = "";
                container.appendChild(divContent);

                pageData[container.id].content = editorContent;

                var remove = document.createElement("div");
                var edit = document.createElement("div");

                remove.className = "pageBuilder-btn-remove";
                container.appendChild(remove);

                edit.className = "pageBuilder-btn-edit";
                container.appendChild(edit);

                remove.addEventListener("click", function () {
                    pageBuilder.deleteContainer(container);
                });

                edit.addEventListener("click", function () {
                    container.textContent = "";
                    editor = pageBuilder.initEditor(container);
                    editor.setContent(editorContent);
                    pageBuilder.addEditorBtns(editor, container);
                });
            });

            remove.addEventListener("click", function () {
                pageBuilder.deleteContainer(container);
            });
        },

        setContainerId: function (container) {
            var pageData = pageBuilder.pageData;
            container.id = "container-" + this.containerId;
            this.containerId++;
            pageData[container.id] = {};
            pageData[container.id].type = "container";
            pageData[container.id].class = container.parentNode.parentNode.className;
            pageData[container.id].previous = null;
            pageData[container.id].next = null;
            pageData[container.id].first = null;
            pageData[container.id].last = null;
            pageData[container.id].parent = null;
            pageData[container.id].node = null;
            pageData[container.id].content = null;
        },

        setRowId: function (row) {
            var pageData = pageBuilder.pageData;

            row.id = "row-" + this.rowId;
            this.rowId++;
            pageData[row.id] = {};
            pageData[row.id].type = "row";
            pageData[row.id].class = row.className;
            pageData[row.id].previous = null;
            pageData[row.id].next = null;
            pageData[row.id].first = null;
            pageData[row.id].last = null;
            pageData[row.id].parent = null;
            pageData[row.id].node = null;
        },

        createForm: function (container) {
            var form = document.createElement("form");
            var token = "<?= csrfInput() ?>";

            form.setAttribute("action", "<?= route('admin.page.store') ?>");
            form.innerHTML = token;
            container.appendChild(form);

            return form;
        },

        addPositionButtons: function (container) {
            var pageBuilder = this;
            var containerCol = container.parentNode.parentNode.parentNode.parentNode.parentNode;
            var containerRow = containerCol.parentNode;
            var page = containerRow.parentNode;

            var isRightContainer = false;
            var isLeftContainer = false;
            var isTopContainer = false;
            var isBottomContainer = false;

            var rowNodesLength = containerRow.childNodes.length;

            if (containerRow.childNodes[1] == containerCol) {
                isLeftContainer = true;
            }
            if (containerRow.childNodes[rowNodesLength - 2] == containerCol) {
                isRightContainer = true;
            }

            if (page.childNodes[1] == containerRow) {
                isTopContainer = true;
            }

            if (page.childNodes[page.childNodes.length - 2] == containerRow) {
                isBottomContainer = true;
            }

            if (!isLeftContainer) {
                var leftBtn = document.createElement("div");
                leftBtn.className = "pageBuilder-container-btn-position-left";
                container.appendChild(leftBtn);
            }

            if (!isRightContainer) {
                var rightBtn = document.createElement("div");
                rightBtn.className = "pageBuilder-container-btn-position-right";
                container.appendChild(rightBtn);
            }

            if (!isTopContainer) {
                var topBtn = document.createElement("div");
                topBtn.className = "pageBuilder-container-btn-position-top";
                container.appendChild(topBtn);
            }

            if (!isBottomContainer) {
                var bottomBtn = document.createElement("div");
                bottomBtn.className = "pageBuilder-container-btn-position-bottom";
                container.appendChild(bottomBtn);
            }
        },

        deleteContainer: function (container) {
            var pageBuilder = this;
            var pageData = pageBuilder.pageData;
            var containerColInner = container.parentNode;
            var containerCol = containerColInner.parentNode;
            var containerRow = containerCol.parentNode;
            var containerRowParent = containerRow.parentNode;
            var classNameElement = null;
            var oldColSize = 0;

            containerCol.classList.forEach((className) => {
                if (className.includes("col-sm-")) {
                    classNameElement = className;
                    oldColSize = className.substring(7);
                }
            });

            containerRow.removeChild(containerCol);

            if (containerRow.childNodes.length == 0) {
                if (containerRowParent.id !== "page") {
                    console.log("pooo");
                    console.log(containerRowParent.firstChild);

                    var mainRow = containerRow.parentNode.parentNode.parentNode;
                    console.log(mainRow);
                    if (containerRowParent.childNodes.length == 1) {
                        mainRow.removeChild(containerRow.parentNode.parentNode);

                        var newContainer = pageBuilder.createNewContainer(mainRow, 12);

                        pageData[mainRow.id].first = newContainer.id;
                        pageData[mainRow.id].last = newContainer.id;
                    } else {
                        var orphanChild = containerRowParent.firstChild.id;
                        pageData[mainRow.id].first = orphanChild;
                        pageData[mainRow.id].last = orphanChild;
                        pageData[orphanChild].previous = null;
                        pageData[orphanChild].next = null;
                    }

                    delete pageData[containerRow.id];
                    delete pageData[container.id];

                    containerRowParent.removeChild(containerRow);
                    console.log(pageData);

                    return;
                }

                var previous = pageData[containerRow.id].previous;
                var next = pageData[containerRow.id].next;
                if (null !== previous && null !== next) {
                    pageData[previous].next = next;
                    pageData[next].previous = previous;
                } else if (null !== next && null === previous) {
                    pageData[next].previous = null;
                    pageData["page"].first = next;
                } else if (null !== previous && null === next) {
                    pageData[previous].next = null;
                    pageData["page"].last = previous;
                } else {
                    pageData["page"].first = null;
                    pageData["page"].last = null;
                }

                page.removeChild(containerRow);
                delete pageData[container.id];
                delete pageData[containerRow.id];

                console.log(pageData);

                return;
            }

            var previous = pageData[container.id].previous;
            var next = pageData[container.id].next;

            if (null !== previous && null !== next) {
                pageData[previous].next = next;
                pageData[next].previous = previous;
            } else if (null !== next && null === previous) {
                pageData[next].previous = null;
                pageData[containerRow.id].first = next;
            } else if (null !== previous && null === next) {
                pageData[previous].next = null;
                pageData[containerRow.id].last = previous;
            } else {
                pageData[containerRow.id].first = null;
                pageData[containerRow.id].last = null;
            }

            delete pageData[container.id];

            console.log(pageData);

            var lastSize = 0;
            var nbNode = containerRow.childNodes.length;

            containerRow.childNodes.forEach((col) => {
                col.classList.forEach((className) => {
                    if (className.includes("col-sm-")) {
                        classNameElement = className;
                        lastSize = className.substring(7);
                    }
                });

                newColSize =
                    (12 - oldColSize) % nbNode == 0
                        ? parseInt(lastSize) + oldColSize / nbNode
                        : parseInt(lastSize) + lastSize / 3;

                col.className = col.className.replace(classNameElement, "col-sm-" + newColSize);
            });
        },

        addImageItem: function (container) {
            var input = document.createElement("input");
            input.setAttribute("type", "file");

            container.appendChild(input);
        },

        addElementToPageContent: function (element) {},
    };

    pageBuilder.init();
});
