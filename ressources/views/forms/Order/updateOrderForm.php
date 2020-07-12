<script type="module" src="<?= url('js/update_order.js') ?>"></script>

<?php
$elements = $form->getBuilder()->getElements();
?>

<?php foreach ($elements as $element) : ?>
    <?php if ($element->getName() !== "id") : ?>
        <?php if ($element->getName() == "updateFormOrder_menu") : ?>
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
        <?php if ($element->getName() == "updateFormOrder_menu") : ?>
            <div id='add_menu_btn' class='btn btn-default'>Ajouter un menu</div>
            <div id='remove_menu_btn' class='btn btn-remove' style='display: none'>Supprimer le dernier menu</div>
        <?php endif; ?>
    <?php endif; ?>

<?php endforeach; ?>