<button <?php foreach ($element->getOptions()["attr"] as $key => $value) :
            echo $key . "='" . $value . "' ";
        endforeach; ?> type="text" name="<?= $element->getName() ?>" id="<?= $element->getId() ?>"><?= $options["text"] ?></button>