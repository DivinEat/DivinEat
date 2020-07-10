$(document).ready(function () {
    tinymce.init({
        selector: "textarea#textearea-test",
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
    var pageBuilderHandler = {
        page: null,
        elements: null,
        draggedElement: null,
        dropperRow: null,
        dropper: null,
        droppers: null,
        container: null,
        containerToolBar: null,
        pageData: {},
        idEditor: 0,

        init: function () {
            pageBuilderHandler.page = document.querySelector(".page");
            var button = document.querySelector(".pageBuilder-btn-add");

            button.addEventListener("click", function (e) {
                var container = button.parentNode;
                var structureBar = pageBuilderHandler.createStructureBtnBar(container);
                pageBuilderHandler.addEventsToFirstRowStructureBtn(structureBar, container);
            });
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
            cancelBtn.innerHTML = "x";

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
            var pageBuilderHandler = this;
            var page = pageBuilderHandler.page;
            var containerParent = btnContainer.parentNode;

            structureBtnBar.childNodes.forEach((strucureBtn) => {
                strucureBtn.addEventListener("click", function () {
                    containerParent.removeChild(btnContainer);

                    var className = this.className.substring(36);
                    var colsSize = className.split("_");

                    var parentRow = document.createElement("div");
                    parentRow.className = "row padding-0";
                    containerParent.appendChild(parentRow);

                    colsSize.forEach((colSize) => {
                        pageBuilderHandler.createNewContainer(parentRow, colSize);
                    });

                    newRowBtnBottom = document.createElement("div");
                    newRowBtnBottom.className = "pageBuilder-btn-add";
                    newRowBtnBottom.innerHTML = "+";
                    newRowContainerBottom = pageBuilderHandler.createContainer(newRowBtnBottom);
                    page.append(newRowContainerBottom);
                    pageBuilderHandler.addEventToAddRowBtn(newRowBtnBottom, newRowBtnBottom.parentNode, "bottom", true);

                    newRowBtnTop = document.createElement("div");
                    newRowBtnTop.className = "pageBuilder-btn-add";
                    newRowBtnTop.innerHTML = "+";
                    newRowContainerTop = pageBuilderHandler.createContainer(newRowBtnTop);
                    page.prepend(newRowContainerTop);
                    pageBuilderHandler.addEventToAddRowBtn(newRowBtnTop, newRowBtnTop.parentNode, "top");
                });
            });
        },

        // @container : la div après/avant laquelle sera placée la new Row
        addEventToAddRowBtn: function (btn, container, param) {
            var pageBuilderHandler = this;

            btn.addEventListener("click", function () {
                var btnContainer = this.parentNode;
                var containerContent = [];
                
                btnContainer.childNodes.forEach((node) => {
                    containerContent.push(node);
                });
                
                var structureBtnBar = pageBuilderHandler.createStructureBtnBar(btnContainer);

                console.log(containerContent)
                
                structureBtnBar.childNodes.forEach((strucureBtn) => {
                    strucureBtn.addEventListener("click", function () {
                        var className = this.className.substring(36);
                        var colsSize = className.split("_");
                        var parentRow = document.createElement("div");
                        parentRow.className = "row padding-0";

                        colsSize.forEach((colSize) => {
                            pageBuilderHandler.createNewContainer(parentRow, colSize);

                            if (param == "top") {
                                container.after(parentRow);
                            }

                            if (param == "bottom") {
                                container.before(parentRow);
                            }

                            btnContainer.textContent = "";
                            containerContent.forEach((node) => {
                                btnContainer.appendChild(node);
                            });
                        });
                    });
                });
            });
        },

        addEventsToNewStructureBtn: function (structureBtnBar, container) {
            var pageBuilderHandler = this;
            var containerParent = container.parentNode;

            structureBtnBar.childNodes.forEach((btn) => {
                btn.addEventListener("click", function (e) {
                    containerParent.removeChild(container);

                    var className = this.className.substring(36);
                    var colsSize = className.split("_");

                    var parentRow = document.createElement("div");
                    parentRow.className = "row padding-0";
                    containerParent.appendChild(parentRow);

                    colsSize.forEach((colSize) => {
                        let col = document.createElement("div");
                        let colInner = document.createElement("div");
                        let container = document.createElement("div");
                        let addBtn = document.createElement("div");
                        let removeBtn = document.createElement("div");

                        col.className = "col-sm-" + colSize + " padding-0";
                        colInner.className = "col-inner padding-top-0";
                        container.className = "pageBuilder-container-empty";
                        addBtn.className = "pageBuilder-btn-add";
                        addBtn.innerHTML = "+";
                        removeBtn.className = "pageBuilder-btn-remove";
                        removeBtn.innerHTML = "x";

                        addBtn.addEventListener("click", function (e) {
                            var addItemBtn = document.createElement("div");
                            var newStructureBtn = document.createElement("div");
                            var cancelBtn = document.createElement("div");

                            addItemBtn.className = "pageBuilder-btn-add";
                            addItemBtn.innerHTML = "+";
                            newStructureBtn.className = "pageBuilder-container-structure-btn-small";

                            cancelBtn.className = "pageBuilder-btn-cancel";
                            cancelBtn.innerHTML = "x";

                            container.appendChild(addItemBtn);
                            container.appendChild(newStructureBtn);
                            container.appendChild(cancelBtn);

                            newStructureBtn.addEventListener("click", function (e) {
                                var structureBtnBar = pageBuilderHandler.createStructureBtnBar(container);
                                pageBuilderHandler.addEventsToNewStructureBtn(structureBtnBar, container);
                            });

                            var oldAddBtn = this;
                            cancelBtn.addEventListener("click", function (e) {
                                container.textContent = "";
                                container.appendChild(oldAddBtn);
                            });

                            pageBuilderHandler.addEventToItemBtn(addItemBtn);

                            container.removeChild(this);
                        });

                        removeBtn.addEventListener("click", function () {
                            pageBuilderHandler.deleteContainer(container);
                        });

                        container.appendChild(addBtn);
                        container.appendChild(removeBtn);
                        colInner.appendChild(container);
                        col.appendChild(colInner);
                        parentRow.appendChild(col);
                    });
                });
            });
        },

        createNewContainer: function (parentRow, colSize) {
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
            addBtn.innerHTML = "+";
            removeBtn.className = "pageBuilder-btn-remove";
            removeBtn.innerHTML = "x";
            newTopContainerBtn.className = "pageBuilder-btn-new-top";
            newTopContainerBtn.innerHTML = "^";
            newBottomContainerBtn.className = "pageBuilder-btn-new-bottom";
            newBottomContainerBtn.innerHTML = "v";

            pageBuilderHandler.addEventToAddRowBtn(newTopContainerBtn, parentRow, "bottom");
            pageBuilderHandler.addEventToAddRowBtn(newBottomContainerBtn, parentRow, "top");

            addBtn.addEventListener("click", function () {
                var addItemBtn = document.createElement("div");
                var newStructureBtn = document.createElement("div");
                var cancelBtn = document.createElement("div");

                addItemBtn.className = "pageBuilder-btn-add";
                addItemBtn.innerHTML = "+";
                newStructureBtn.className = "pageBuilder-container-structure-btn-small";

                cancelBtn.className = "pageBuilder-btn-cancel";
                cancelBtn.innerHTML = "x";

                container.appendChild(addItemBtn);
                container.appendChild(newStructureBtn);
                container.appendChild(cancelBtn);

                newStructureBtn.addEventListener("click", function (e) {
                    var structureBtnBar = pageBuilderHandler.createStructureBtnBar(container);
                    pageBuilderHandler.addEventsToNewStructureBtn(structureBtnBar, container);
                });

                var oldAddBtn = this;
                cancelBtn.addEventListener("click", function (e) {
                    container.textContent = "";
                    container.appendChild(oldAddBtn);
                });

                pageBuilderHandler.addEventToItemBtn(addItemBtn);

                container.removeChild(this);
            });

            removeBtn.addEventListener("click", function () {
                pageBuilderHandler.deleteContainer(container);
            });

            container.appendChild(newTopContainerBtn);
            container.appendChild(newBottomContainerBtn);
            container.appendChild(addBtn);
            container.appendChild(removeBtn);
            colInner.appendChild(container);
            col.appendChild(colInner);
            parentRow.appendChild(col);
        },

        addEventToItemBtn: function (btn) {
            pageBuilderHandler = this;
            container = btn.parentNode;

            btn.addEventListener("click", function (event) {
                container.textContent = "";

                var structureBtnBar = document.createElement("div");
                structureBtnBar.className = "pageBuilder-container-list-structure-bar";

                var addEditorBtn = document.createElement("div");
                addEditorBtn.innerHTML = "BUton";

                structureBtnBar.appendChild(addEditorBtn);
                container.appendChild(structureBtnBar);
                pageBuilderHandler.addEditor(addEditorBtn);
            });
        },

        createContainer: function (content = null) {
            var pageBuilderHandler = this;
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
                pageBuilderHandler.container = this;
            });
            container.addEventListener("mouveleave", function (e) {
                pageBuilderHandler.container = null;
            });

            return container;
        },

        addEditor: function (btn) {
            var pageBuilderHandler = this;
            container = btn.parentNode.parentNode;

            btn.addEventListener("click", function (event) {
                container.textContent = "";

                var textArea = document.createElement("textarea");
                textArea.id = "textearea-test";

                // container.appendChild(textArea);

                // tinymce.init({
                //     selector: "textarea#textearea-test",
                //     height: 500,
                //     menubar: true,
                //     plugins: [
                //         "advlist autolink lists link image charmap print preview anchor",
                //         "searchreplace visualblocks code fullscreen",
                //         "insertdatetime media table paste code help wordcount",
                //     ],
                //     toolbar:
                //         "undo redo | formatselect | " +
                //         "bold italic backcolor | alignleft aligncenter " +
                //         "alignright alignjustify | bullist numlist outdent indent | " +
                //         "removeformat | help",
                //     content_css: "//www.tiny.cloud/css/codepen.min.css",
                // });
            });
        },

        addPositionButtons: function (container) {
            var pageBuilderHandler = this;
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
            var pageBuilderHandler = this;
            var pageData = pageBuilderHandler.pageData;
            var containerColInner = container.parentNode;
            var containerCol = containerColInner.parentNode;
            var containerRow = containerCol.parentNode;
            var classNameElement = null;

            // delete pageData[container.id];
            var oldColSize = 0;
            containerCol.classList.forEach((className) => {
                if (className.includes("col-sm-")) {
                    classNameElement = className;
                    oldColSize = className.substring(7);
                }
            });

            containerRow.removeChild(containerCol);

            // Si il ne reste qu'un node, on supprime toute la row et on ajoute le dernier node à son parent
            if (containerRow.childNodes.length == 1) {
                var parentRow = containerRow.parentNode;

                if (parentRow != pageBuilderHandler.page) {
                    var lastNode = containerRow.firstChild.firstChild.firstChild;
                    parentRow.removeChild(containerRow);
                    parentRow.appendChild(lastNode);
                    return;
                }
            }

            if (containerRow.childNodes.length == 0) {
                containerRow.parentNode.removeChild(containerRow);
                return;
            }

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

            // if (colSize == 12) {
            //     containerRow.parentNode.removeChild(containerRow);
            // } else {
            //     if (newColSize == 12) {
            //         orphanContainerRow = containerRow.childNodes[0].childNodes[0].childNodes[0];
            //         orphanContainer = orphanContainerRow.childNodes[0].childNodes[0].childNodes[0];
            //         containerMainColInner.removeChild(containerRow);
            //         containerMainColInner.appendChild(orphanContainerRow);

            //         // var pageDataOrphanContainer = pageData[orphanContainer.id];
            //         // var newId = orphanContainer.id.substring(0, orphanContainer.id.length - 2);
            //         // pageData[newId] = pageDataOrphanContainer;

            //         // delete pageData[orphanContainer.id];
            //         // orphanContainer.id = newId;
            //     } else {
            //         containerRow.childNodes.forEach((col) => {
            //             var oldColSize = 0;
            //             console.log(col.className);
            //             containerCol.classList.forEach((className) => {
            //                 if (className.includes("col-sm-")) {
            //                     classNameElement = className;
            //                     oldColSize = className.substring(7);
            //                 }
            //             });
            //             // // console.log(oldColSize);
            //             // newColSize = oldColSize + oldColSize / 3;
            //             // console.log(newColSize);
            //             // col.className = col.className.replace(classNameElement, "col-sm-" + newColSize);
            //         });
            //     }
            // }
        },

        addImageItem: function (container) {
            var input = document.createElement("input");
            input.setAttribute("type", "file");

            container.appendChild(input);
        },

        addElementToPageContent: function (element) {},
    };

    pageBuilderHandler.init();
});
