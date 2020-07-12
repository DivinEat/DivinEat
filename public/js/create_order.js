function orders() {

    var addMenuBtn = document.getElementById('add_menu_btn');
    var addMenuArea = document.getElementById('add_menu_area');
    var removeBtn = document.getElementById('remove_menu_btn');
    
    var selectionCounter = 0;
    
    if (addMenuBtn != null) {
        addMenuBtn.addEventListener('click', function(e) {
            
            var select = document.getElementById("createFormOrder_menu");
            var clone = select.cloneNode(true);
            var name = select.getAttribute("name") + selectionCounter++;
            clone.id = name;
            clone.setAttribute("name", name);
            document.getElementById("add_menu_area").appendChild(clone);
    
            removeBtn.style.display = 'inline-block';
        });
    }
    
    if (removeBtn != null) {  
        removeBtn.addEventListener('click', function(e) {
            var pSelect = addMenuArea.lastChild;
            pSelect.parentNode.removeChild(pSelect);
    
            pSelect = addMenuArea.lastChild;
    
            if (pSelect.type != "select-one")
                this.style.display = 'none';
        });
    }
}

window.onload = orders();