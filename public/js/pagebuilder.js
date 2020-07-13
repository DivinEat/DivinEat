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
            // var tba = {
            //     row1: {
            //         previous: null,
            //         parent: "page",
            //         first: ,
            //         last: ,
            //         next: "row3",
            //     },
            //     row2: {
            //         previous: null,
            //         parent: "row1",
            //         child: ["container1", "container2", "container3"],
            //         next: null,
            //     },
            //     container1: {
            //         previous: null,
            //         value: "valeur",
            //         type: "type",
            //         next: container2,
            //     },
            //     container2: {
            //         previous: "container1",
            //         value: "valeur",
            //         type: "type",
            //         next: container3,
            //     },
            //     container3: {
            //         previous: "container2",
            //         value: "valeur",
            //         type: "type",
            //         next: null,
            //     },
            //     row3: {
            //         previous: "row1",
            //         parent: "page",
            //         child: ["container4"],
            //         next: null,
            //     },
            //     container4: {
            //         previous: null,
            //         value: "valeur",
            //         type: "type",
            //         next: null,
            //     },
            // };

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
            var pageData = pageBuilderHandler.pageData;
            var containerParent = btnContainer.parentNode;

            structureBtnBar.childNodes.forEach((strucureBtn) => {
                strucureBtn.addEventListener("click", function () {
                    containerParent.removeChild(btnContainer);

                    var className = this.className.substring(36);
                    var colsSize = className.split("_");

                    var parentRow = document.createElement("div");
                    parentRow.className = "row padding-0";
                    containerParent.appendChild(parentRow);
                    pageBuilderHandler.setRowId(parentRow);

                    pageData.page.first = parentRow.id;
                    pageData.page.last = parentRow.id;
                    pageData[parentRow.id].parent = "page";
                    pageData[parentRow.id].node = parentRow;

                    var rowContainerList = [];

                    colsSize.forEach((colSize) => {
                        container = pageBuilderHandler.createNewContainer(parentRow, colSize);

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
                    newRowBtnBottom.className = "pageBuilder-btn-add";
                    newRowBtnBottom.innerHTML = "b";
                    newRowContainerBottom = pageBuilderHandler.createContainer(newRowBtnBottom);
                    pageBuilderHandler.newBottomRowBtn = newRowContainerBottom;
                    page.append(newRowContainerBottom);
                    pageBuilderHandler.addEventToAddRowBtn(newRowBtnBottom, newRowBtnBottom.parentNode, "before");

                    newRowBtnTop = document.createElement("div");
                    newRowBtnTop.className = "pageBuilder-btn-add";
                    newRowBtnTop.innerHTML = "t";
                    newRowContainerTop = pageBuilderHandler.createContainer(newRowBtnTop);
                    pageBuilderHandler.newTopRowBtn = newRowContainerTop;
                    page.prepend(newRowContainerTop);
                    pageBuilderHandler.addEventToAddRowBtn(newRowBtnTop, newRowBtnTop.parentNode, "after");
                    console.log(pageBuilderHandler.pageData);
                });
            });
        },

        // @div : la div après/avant laquelle sera placée la new Row
        addEventToAddRowBtn: function (btn, div, param) {
            var pageBuilderHandler = this;
            var pageData = pageBuilderHandler.pageData;

            btn.addEventListener("click", function () {
                var btnContainer = this.parentNode;
                var containerContent = [];

                btnContainer.childNodes.forEach((node) => {
                    containerContent.push(node);
                });

                var structureBtnBar = pageBuilderHandler.createStructureBtnBar(btnContainer);

                structureBtnBar.childNodes.forEach((strucureBtn) => {
                    strucureBtn.addEventListener("click", function () {
                        var className = this.className.substring(36);
                        var colsSize = className.split("_");
                        var parentRow = document.createElement("div");
                        parentRow.className = "row padding-0";

                        pageBuilderHandler.setRowId(parentRow);

                        var mainRow =
                            div.parentNode.id == "page"
                                ? (mainRow = div.parentNode)
                                : div.parentNode.parentNode.parentNode;

                        pageData[parentRow.id].parent = mainRow.id;
                        pageData[parentRow.id].node = parentRow;
                        if (div == pageBuilderHandler.newTopRowBtn || div == pageBuilderHandler.newBottomRowBtn) {
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
                            container = pageBuilderHandler.createNewContainer(parentRow, colSize);

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
            var pageBuilderHandler = this;
            var containerParent = oldContainer.parentNode;
            var mainRow = containerParent.parentNode.parentNode;
            var pageData = pageBuilderHandler.pageData;
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
                    pageBuilderHandler.setRowId(parentRow);

                    pageData[parentRow.id].parent = mainRow.id;
                    pageData[parentRow.id].node = parentRow;

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

                    console.log(pageBuilderHandler.pageData);

                    var rowContainerList = [];

                    colsSize.forEach((colSize) => {
                        container = pageBuilderHandler.createNewContainer(parentRow, colSize);
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
            let pageData = pageBuilderHandler.pageData;
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
            newTopContainerBtn.className = "pageBuilder-btn-new-top";
            newTopContainerBtn.innerHTML = "^";
            newBottomContainerBtn.className = "pageBuilder-btn-new-bottom";
            newBottomContainerBtn.innerHTML = "v";

            pageBuilderHandler.addEventToAddRowBtn(newBottomContainerBtn, parentRow, "after");
            pageBuilderHandler.addEventToAddRowBtn(newTopContainerBtn, parentRow, "before");

            pageBuilderHandler.setContainerId(container);

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
                addItemBtn.innerHTML = "+";
                newStructureBtn.className = "pageBuilder-container-structure-btn-small";

                cancelBtn.className = "pageBuilder-btn-cancel";

                container.appendChild(addItemBtn);
                container.appendChild(newStructureBtn);
                container.appendChild(cancelBtn);

                newStructureBtn.addEventListener("click", function (e) {
                    var structureBtnBar = pageBuilderHandler.createStructureBtnBar(container);
                    pageBuilderHandler.addEventsToNewStructureBtn(structureBtnBar, container);
                });

                cancelBtn.addEventListener("click", function (e) {
                    btnContainer.textContent = "";
                    containerContent.forEach((node) => {
                        btnContainer.appendChild(node);
                    });
                });

                pageBuilderHandler.addEventToItemBtn(addItemBtn);
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

            return container;
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

                var form = pageBuilderHandler.createForm(container);

                var textArea = document.createElement("textarea");
                textArea.id = "textearea-test";

                container.appendChild(textArea);

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
            });
        },

        setContainerId: function (container) {
            var pageData = pageBuilderHandler.pageData;

            container.id = "container-" + this.containerId;
            this.containerId++;
            pageData[container.id] = {};
            pageData[container.id].previous = null;
            pageData[container.id].next = null;
            pageData[container.id].first = null;
            pageData[container.id].last = null;
            pageData[container.id].parent = null;
            pageData[container.id].node = null;
        },

        setRowId: function (row) {
            var pageData = pageBuilderHandler.pageData;

            row.id = "row-" + this.rowId;
            this.rowId++;
            pageData[row.id] = {};
            pageData[row.id].previous = null;
            pageData[row.id].next = null;
            pageData[row.id].first = null;
            pageData[row.id].last = null;
            pageData[row.id].parent = null;
            pageData[row.id].node = null;
        },

        createForm: function (container) {
            var form = document.createElement("form");

            // var token = ;

            return form;
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

                        var newContainer = pageBuilderHandler.createNewContainer(mainRow, 12);

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

                var previous = pageData[containerRowParent.id].previous;
                var next = pageData[containerRowParent.id].next;

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

    pageBuilderHandler.init();
});
