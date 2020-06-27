<?php if (isset($options["label"])) : ?>
    <label class="<?= $options["label"]["class"] ?? "" ?>">
        <?= $options["label"]["value"] ?? "" ?>
    </label>
<?php endif; ?>

<select <?php foreach ($options["attr"] as $key => $value) :
            echo $key . "='" . $value . "' ";
        endforeach; ?> type="text" name="<?= $element->getName() ?>" id="<?= $element->getId() ?>">
    <?php foreach ($options["data"] as $data) : ?>
        <option value="<?= method_exists($data, "getId") ? $data->getId() : $data->getValue() ?>" 
        <?= isset($options["selected"]) && $data == $options["selected"] ?? "selected"; ?>>
            <?php 
            if (isset($options["getter"])) :
                $getter = $options["getter"];
                echo $data->$getter();
            endif;
            ?>
        </option>
    <?php endforeach; ?>
</select>