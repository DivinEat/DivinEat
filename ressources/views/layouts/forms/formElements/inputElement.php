<?php if (isset($options["label"])) : ?>
<label class="<?= $options["label"]["class"] ?? "" ?>">
     <?= $options["label"]["value"] ?? "" ?>
</label>
<?php endif; ?>
<input <?php foreach ($options["attr"] as $key => $value) :
               echo $key . "='" . $value . "' ";
          endforeach; ?> type="text" name="<?= $element->getName() ?>" id="<?= $element->getId() ?>"
     <?= isset($options["readonly"]) && $options["readonly"] ? "readonly" : "" ?>>