<form 
method="<?= $form->getConfig()['method'] ?>" 
action="<?= $form->getConfig()['action'] ?>"
name="<?= $form->getName() ?>"
<?php foreach($form->getConfig()['attr'] as $attr => $value)
{
  echo "$attr = '$value' ";
}
?>>
<?php
      if(!$form->isValid())
      {
        foreach($form->getErrors() as $key => $errorsPerField)
        {
          foreach($errorsPerField as $error)
          {
             echo "Erreur : $error <br>";

          }
         
        }
      }

      echo "<br><br>";
?>


      <?php foreach ($form->getElements() as $key => $field):?>
        <div class="form-group row">
          <div class="col-sm-12">

          <!---------------SUBMIT --->
            <?php if($field->getType() == "submit"):?>
              <button
              <?php 
                if(isset($field->getOptions()['attr'])) {
                  foreach($field->getOptions()['attr'] as $attr => $value)
                    {
                      echo "$attr = '$value' ";
                    }
                  }
                  ?>
              >
                
              <?= $field->getOptions()["label"]??'' ?>
            </button>
            <?php endif;?>
            
            <!---------------TEXT --->
            <?php if($field->getType() == "text"):?>

              <label
                  <?php 
                  if(isset($field->getOptions()['attr_label'])) {
                    foreach($field->getOptions()['attr_label'] as $attr => $value)
                      {
                        echo "$attr = '$value' ";
                      }
                  }
                  
                    ?>
              ><?= $field->getOptions()["label"] ?><br><br></label>
              
              
              <input 
                value="<?= (isset($field->getOptions()['value'])) ? $field->getOptions()['value']:'' ?>"
                type="text"
                name="<?= $form->getName().'_'.$field->getName() ?>"
               
                <?php 
                if(isset($field->getOptions()['attr'])) {
                  foreach($field->getOptions()['attr'] as $attr => $value)
                    {
                      echo "$attr = '$value' ";
                    }
                  }
                  ?>
                <?=(!empty($field->getOptions()["required"]))?"required='required'":""?> >
              <?php endif;?>
             
          </div>
      </div>
      <?php endforeach;?>
</form>
