<a 
    <?php foreach ($options["attr"] as $key => $value) :
        echo $key . "='" . $value . "' ";
    endforeach; ?>>
    <?= $options["text"] ?>
</a>