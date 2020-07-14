<?= $element->getLabelHTML($options) ?>

<label for="date"><?= $options['label'] ?></label>

<input type="date" id="date" name="<?= $options['name'] ?>"
       value="2018-07-22"
       min="<?= date("Y-m-d", strtotime("+1 month", time())) ?>" max="2018-12-31">