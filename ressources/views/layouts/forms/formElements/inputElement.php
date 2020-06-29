<?= $element->getLabelHTML($options) ?>
<input 
     <?= $element->getAttributeHTML($options["attr"]); ?>
     name="<?= $element->getName() ?>" 
     id="<?= $element->getId() ?>"
     <?= isset($options["readonly"]) && $options["readonly"] ? "readonly" : "" ?>
>