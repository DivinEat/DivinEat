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
        if ($element->getName() !== "id") : ?>
            </div>
        </div>
    <?php endif;
        if (isset($element->getOptions()["label"]) && $element->getOptions()["label"]["value"] == "Publier") : ?>
        <div class="form-group row">
            <div class="col-sm-12">
                <label>Contenu</label>
                <textarea class=" form-control" id="articleContent"></textarea>
            </div>
        </div>
    <?php endif; ?>

<?php endforeach; ?>