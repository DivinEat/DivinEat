import { editorHandler } from './component/textEditor.js';
$(document).ready(function() {
    
    var pageBuilderHandler = {

        page: null,
        elements: null,
        draggedElement: null,
        dropperRow: null,
        dropper: null,
        droppers: null,
        pageContent: [],
        container: null,
        containerToolBar: null,

        init: function() {
            this.applyDragEvents();
            // this.applyDropEvents();
            this.addEventsToCreateContainerButton(document.querySelector('.add-container-button'));
        },

        applyDragEvents: function() {
            var pageBuilderHandler = this;
            pageBuilderHandler.page = document.querySelector('.page');
            pageBuilderHandler.elements = document.querySelectorAll('.pageBuilder-item');

            pageBuilderHandler.elements.forEach(element => {
                element.draggable = true;

                element.addEventListener('dragstart', function(e) {
                    pageBuilderHandler.draggedElement = this;
                    this.style.cursor = 'grabbing';

                    e.dataTransfer.setData("text/plain", '');
                    e.dataTransfer.effectAllowed = "copyMove";
                });

                element.addEventListener('mousedown', function(e) {
                    this.style.cursor = 'grabbing';
                });

                element.addEventListener('mouseup', function(e) {
                    this.style.cursor = 'grab';
                });

                element.addEventListener('dragend', function(e) {
                    this.style.cursor = 'grab';
                });
            });
        },

        applyDropEvents: function(container) {

            var pageBuilderHandler = this;

            container.addEventListener('dragover', function (e) {
                e.preventDefault(); // par défaut, supprime comportement par défaut qui n'autorise pas le drop d'un élément
            });

            container.addEventListener('drop', function(e) {
                // pageBuilderHandler.toolsBar = pageBuilderHandler.getToolsBarFromContainer(this);
                var draggedElementId = pageBuilderHandler.draggedElement.id;

                switch (draggedElementId) {
                    case 'text-item':
                        pageBuilderHandler.addTextItem(this);
                        break;

                    case 'image-item':
                        pageBuilderHandler.addImageItem(this);
                        break;
                
                    default:
                        break;
                }
            });
        },

        createContainer: function(parent) {
            var pageBuilderHandler = this;
            var row = document.createElement('div');
            var col = document.createElement('div');
            var colInner = document.createElement('div');
            var container = document.createElement('div');
            
            row.className = 'row padding-0';
            col.className = 'col-sm-12 padding-0';
            colInner.className = 'col-inner';
            container.className = 'pageBuilder-container-displayed';

            parent.appendChild(row);
            row.appendChild(col);
            col.appendChild(colInner);
            colInner.appendChild(container);

            container.addEventListener('mouseenter', function(e) {
                pageBuilderHandler.container = this;
            });
            container.addEventListener('mouveleave', function(e) {
                pageBuilderHandler.container = null;
            });

            return container;
        },

        addToolsBar: function(container) {
            var pageBuilderHandler = this;
            var toolsBarItemsList = [];
            var toolsBar = document.createElement('div');
            toolsBar.className = 'tools-bar';
            
            var toolsBarGear = document.createElement('div');
            var gearIcon = document.createElement('img');
            toolsBarGear.className = 'tools-bar-item';
            gearIcon.src = '/public/img/icones/gear.png';
            gearIcon.style.width = '65%';

            toolsBarGear.appendChild(gearIcon);
            toolsBar.appendChild(toolsBarGear);

            for (let i = 0; i < 2; i++) {
                let sizeBtn = document.createElement('div');
                let nbCol = 2;

                toolsBarItemsList.push(sizeBtn);
                
                if (i > 0) nbCol = 3;
                
                sizeBtn.className = 'tools-bar-item-hidden';
                var colIcon = document.createElement('img');

                if (i == 0) colIcon.src = '/public/img/icones/2columns.png';
                else if (i == 1) colIcon.src = '/public/img/icones/3columns.png';
                
                colIcon.style.width = '50%';
                sizeBtn.appendChild(colIcon);
                
                sizeBtn.addEventListener('click', function (e) {
                    let mainColInner = pageBuilderHandler.container.parentNode;
                    let mainCol = mainColInner.parentNode;
                    let mainRow = mainCol.parentNode;
                    
                    mainColInner.removeChild(container);
                    mainColInner.className = 'col-inner padding-0';
                    mainCol.className = 'col-sm-' + (12 / nbCol) + ' padding-0';

                    for (let i = 0; i < nbCol; i++) {
                        if (i == 0) {
                            let containerRow = document.createElement('div');
                            let containerCol = document.createElement('div');
                            let containerColInner = document.createElement('div');

                            containerRow.className = 'row padding-0';
                            containerCol.className = 'col-sm-12 padding-0';
                            containerColInner.className = 'col-inner';

                            mainColInner.appendChild(containerRow);
                            containerRow.appendChild(containerCol);
                            containerCol.appendChild(containerColInner);
                            containerColInner.appendChild(container);
                        } else {
                            let newCol = document.createElement('div');
                            let newColInner = document.createElement('div');
                            let newContainer = pageBuilderHandler.createContainer(newColInner);

                            pageBuilderHandler.applyDropEvents(newContainer);

                            newCol.className = 'col-sm-' + (12 / nbCol) + ' padding-0';
                            newColInner.className = 'col-inner padding-0';

                            let toolsBar = pageBuilderHandler.addToolsBar(newContainer);
                            newCol.appendChild(newColInner);
                            mainRow.appendChild(newCol);
                        }                      
                    }
                });
                toolsBar.appendChild(sizeBtn);
            }

            var deleteContainerBtn = document.createElement('div');
            toolsBarItemsList.push(deleteContainerBtn);
            deleteContainerBtn.className = 'tools-bar-item-hidden';
            var binIcon = document.createElement('img');
            binIcon.src = '/public/img/icones/trash.png';
            binIcon.style.width = '50%';

            deleteContainerBtn.addEventListener('click', function(e) {
                pageBuilderHandler.deleteContainer(container);
            });
            
            deleteContainerBtn.appendChild(binIcon);
            toolsBar.appendChild(deleteContainerBtn);

            toolsBar.addEventListener('mouseenter', function (e) {

                toolsBarGear.className = 'tools-bar-item-hidden';
                
                toolsBarItemsList.forEach(item => {
                    item.className = 'tools-bar-item';
                });

            });

            toolsBar.addEventListener('mouseleave', function (e) {

                toolsBarGear.className = 'tools-bar-item';
                toolsBarItemsList.forEach(item => {
                    item.className = 'tools-bar-item-hidden';
                });

            });

            container.addEventListener('mouseenter', function (e) {
                toolsBar.style.display = 'flex';
                pageBuilderHandler.toolsBar = toolsBar;
            });

            container.addEventListener('mouseleave', function (e) {
                toolsBar.style.display = 'none';
                pageBuilderHandler.toolsBar = null;
            });

            container.appendChild(toolsBar);
            return toolsBar;
        },

        addEventsToCreateContainerButton: function(button) {
            var pageBuilderHandler = this; 
            var container = button.parentNode;
            var page = pageBuilderHandler.page;
            
            button.addEventListener('click', function(e) {
                var containerRow = container.parentNode.parentNode.parentNode;
                var containerRowParent = containerRow.parentNode;
                
                containerRowParent.removeChild(containerRow);
                container = pageBuilderHandler.createContainer(containerRowParent);
                pageBuilderHandler.container = container;
                var toolsBar = pageBuilderHandler.addToolsBar(container);

                container.className = 'pageBuilder-container-displayed';
                pageBuilderHandler.applyDropEvents(container);

                container.addEventListener('mouseenter', function (e) {
                    toolsBar.style.display = 'flex';
                });

                container.addEventListener('mouseleave', function (e) {
                    toolsBar.style.display = 'none';
                });

                var newAddContainerBtn = document.createElement('div');
                newAddContainerBtn.className = 'add-container-button';                
                newAddContainerBtn.innerHTML = '+';


                var newRow = document.createElement('div');
                var newCol = document.createElement('div');
                var newColInner = document.createElement('div');
                var newContainer = pageBuilderHandler.createContainer(newColInner);

                newRow.className = 'row padding-0';
                newCol.className = 'col-sm-12 padding-0';
                newColInner.className = 'col-inner padding-0';
                newContainer.className = 'pageBuilder-container-hidden';

                page.appendChild(newRow);
                newRow.appendChild(newCol);
                newCol.appendChild(newColInner);
                newContainer.appendChild(newAddContainerBtn);
                pageBuilderHandler.addEventsToCreateContainerButton(newAddContainerBtn);
            });

        },

        deleteContainer: function(container) {
            var containerMainCol = container.parentNode.parentNode.parentNode.parentNode.parentNode;
            var containerMainRow = containerMainCol.parentNode;
            var colSize = null;
            var classNameElement = null;
            var orphanContainerRow = null;

            containerMainCol.classList.forEach(className => {
                if (className.includes('col-sm-')) {
                    classNameElement = className;
                    colSize = className.substring(7);
                }
            });

            var newColSize = colSize == 12 ? 0 : 12 / (12 / colSize - 1);
            
            if (newColSize == 0) {
                
                containerMainRow.parentNode.removeChild(containerMainRow);
                
            } else {
            
                var containerMainColInner = containerMainRow.parentNode;
                containerMainRow.removeChild(containerMainCol);

                if (newColSize == 12) {

                    orphanContainerRow = containerMainRow.childNodes[0].childNodes[0].childNodes[0];
                    containerMainColInner.removeChild(containerMainRow);
                    containerMainColInner.appendChild(orphanContainerRow);

                } else {
                    
                    containerMainRow.childNodes.forEach(col => {
                        col.className = col.className.replace(classNameElement, 'col-sm-' + newColSize);
                    });

                }   
            }
        },

        addTextItem: function(container) {
            
            editorHandler.addEditBtn(container);

        },

        addImageItem: function(container) {
            var input = document.createElement("input");
            input.setAttribute("type", "file");

            container.appendChild(input);
        },

        addElementToPageContent: function(element) {

        }
    };

    pageBuilderHandler.init();
});