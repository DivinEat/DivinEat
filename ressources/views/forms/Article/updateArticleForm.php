<?php
$elements = $form->getBuilder()->getElements();
?>

<?php foreach ($elements as $element) : ?>
    <?php if ($element->getName() !== "id") : ?>
        <div class="form-group row">
            <div class="col-sm-12">
    <?php endif; 
    $options = $element->getOptions();
    include $element->getLayoutPath();

    if (isset($element->getOptions()["label"]) && $element->getOptions()["label"]["value"] == "Publier"): ?>
        </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-12">
                <input type='hidden' id='editor-content' name='createArticleForm_content' class='form-control'/>

                <label>Contenu</label>
                <div id='articlejs' style='min-height: 15em; border: 1px solid #ccc;'></div>
    <?php endif; 

    if ($element->getName() !== "id") : ?>
        </div>
    </div>
    <?php endif; ?>
<?php endforeach; ?>