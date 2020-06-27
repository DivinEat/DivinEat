<?php

$elements = $form->getBuilder()->getElements();
?>

<?php foreach ($elements as $element) : ?>
    <div class="form-group row">
        <div class="col-sm-12">
            <?php
            $options = $element->getOptions();
            include $element->getLayoutPath();
            ?>
        </div>
    </div>

<?php endforeach; ?>