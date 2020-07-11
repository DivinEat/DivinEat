<?php
$elements = $form->getBuilder()->getElements();
?>

<?php foreach ($elements as $element) : ?>
    <?php if ($element->getName() !== "id") : ?>
        <?php if ($element->getName() == "createFormOrder_menu") : ?>
            <div class="form-group row">
                <div id='add_menu_area' class="col-sm-12">
        <?php else : ?>
            <div class="form-group row">
                <div class="col-sm-12">
        <?php endif; ?>
    <?php endif; ?>
            <?php
            $options = $element->getOptions();
            include $element->getLayoutPath();
            ?>
    <?php if ($element->getName() !== "id") : ?>
            </div>
        </div>
        <?php if ($element->getName() == "createFormOrder_menu") : ?>
            <div id='add_menu_btn' class='btn btn-default'>Ajouter un menu</div>
            <div id='remove_menu_btn' class='btn btn-remove' style='display: none'>Supprimer le dernier menu</div>
        <?php endif; ?>
    <?php endif; ?>

<?php endforeach; ?>




<script type="text/javascript">

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
</script>
