<?php
$elements = $form->getBuilder()->getElements();
?>

<?php foreach ($elements as $element) : 
     if ($element->getName() !== "id") : ?>
        <div class="form-group row">
            <div class="col-sm-12">
            <?php
        endif;
        $options = $element->getOptions();
        include $element->getLayoutPath();
        if ($element->getName() !== "id") : ?>
            </div>
        </div>
    <?php endif; 
 endforeach; ?>