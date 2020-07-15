<?= $element->getLabelHTML($options) ?>

<label for="date"><?= $options['label'] ?></label>

<input
    name="<?= $element->getName() ?>"
    id="<?= $element->getId() ?>"
    <?= $element->getAttributeHTML($options["attr"]); ?>
    type="date" id="date" name="<?= $options['name'] ?>"
    value="<?= $options['value'] ?>"
    min="<?= date("Y-m-d", strtotime("+1 day", time())) ?>" max="<?= date("Y-m-d", strtotime("+3 month", time())) ?>">