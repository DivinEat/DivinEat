function orders() {

    var addMenuBtn = document.getElementById('add_menu_btn');
    var addMenuArea = document.getElementById('add_menu_area');
    var removeBtn = document.getElementById('remove_menu_btn');

    var addedMenus = [];
    
    if (addMenuBtn != null) {
        addMenuBtn.addEventListener('click', function(e) {
            var indexMenus = addMenuArea.lastElementChild.lastElementChild.lastElementChild.getAttribute("name").slice(-1);

            var select = addMenuArea.lastElementChild;
            var truc = select.lastElementChild.lastElementChild.getAttribute("name");
            var clone = select.cloneNode(true);

            var name = truc.slice(0, -1) + ++indexMenus;

            clone.lastElementChild.lastElementChild.id = name;
            clone.lastElementChild.lastElementChild.setAttribute("name", name);
            document.getElementById("add_menu_area").appendChild(clone);
    
            removeBtn.style.display = 'inline-block';

            addedMenus.push(clone.lastElementChild.lastElementChild);
        });
    }
    
    if (removeBtn != null) {  
        removeBtn.addEventListener('click', function(e) {
            var pSelect = addMenuArea.lastChild;
            pSelect.parentNode.removeChild(pSelect);
    
            pSelect = addMenuArea.lastElementChild.lastElementChild.lastElementChild;
    
            if (!addedMenus.includes(pSelect) )
                this.style.display = 'none';
        });
    }
}

window.onload = orders();