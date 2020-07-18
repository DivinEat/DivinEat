<?php
$elements = $form->getBuilder()->getElements();
?>

<?php foreach ($elements as $element) : ?>
    <?php if ($element->getName() !== "id") : ?>
        <div class="form-group row">
            <div class="col-sm-12">
            <?php
            endif;
            $options = $element->getOptions();
            include $element->getLayoutPath();
            ?>
            <?php if ($element->getName() !== "id") : ?>
            </div>
        </div>
    <?php endif; ?>

<?php endforeach; ?>