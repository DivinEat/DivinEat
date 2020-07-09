<?php
$elements = $form->getBuilder()->getElements();
?>

<?php foreach ($elements as $element) : ?>
    <?php if ($element->getName() != "updateConfigurationForm_id" && $element->getName() != "updateConfigurationForm_libelle") : ?>
        <div class="form-group row">
            <div class="col-sm-12">
    <?php endif; ?>
        <?php
        $options = $element->getOptions();
        include $element->getLayoutPath();
        ?>
    <?php if ($element->getName() != "updateConfigurationForm_id" && $element->getName() != "updateConfigurationForm_libelle") : ?>
            </div>
        </div>
    <?php endif; ?>

<?php endforeach; ?>