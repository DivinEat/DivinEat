<form 
    method="<?= $form->getConfig()['method'] ?>" 
    action="<?= $form->getConfig()['action'] ?>" 

    <?php foreach ($form->getConfig()['attr'] as $attr => $value):
        echo "$attr = '$value' ";
    endforeach; ?>>
    <?php
    if(!$form->isValid()):
        foreach($form->getErrors() as $key => $errorsPerField):
            foreach($errorsPerField as $error): ?>
                <div class="alert alert-warning">
                <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                <?= $error ?>
            </div>
            <?php endforeach;
        endforeach;
    endif; 
    ?>

    <input type="hidden" name="csrf_token" value="<?= csrf(); ?>">

    <?php include $formPath; ?>
</form>