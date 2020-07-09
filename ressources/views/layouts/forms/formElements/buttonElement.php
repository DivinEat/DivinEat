<button 
    <?= $element->getAttributeHTML($options["attr"]); ?>
    name="<?= $element->getName() ?>"
    id="<?= $element->getId() ?>"
>
    <?= $options["text"] ?>
</button>