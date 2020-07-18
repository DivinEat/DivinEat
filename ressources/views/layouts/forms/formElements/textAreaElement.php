<?= $element->getLabelHTML($options) ?>
<textarea 
    <?= $element->getAttributeHTML($options["attr"]); ?>
    name="<?= $element->getName() ?>"
    id="<?= $element->getId() ?>"
>
<?= (isset($options["text"])) ? $options["text"] : "" ?>
</textarea>