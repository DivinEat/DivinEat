<table class="<?= $data["config"]["class"]?>">
    <tr>
        <?php foreach ($data["colonnes"] as $name => $colonnes):?>
                <th><?= $colonnes ?></th>
        <?php endforeach;?>
    </tr>

    <?php foreach ($data["fields"] as $categorie => $elements):?>
        <tr>
            <th><?= $categorie ?></th>
            <?php for($i = 0; $i < sizeof($data["colonnes"]) - 1;$i++):?>
                <th></th>
            <?php endfor;?>
        </tr>

        <?php foreach ($elements as $key => $fields): ?>
            <form method="POST" action="<?= (isset($fields['destroy']))?$fields['destroy']->getUrl():'' ?>">
                <?php csrfInput(); ?>
                <tr>
                    <td></td>
                    <?php foreach ($fields as $key => $field):
                        if($key != "edit" && $key != "destroy"): 
                            if($key == "id") :?>
                                <td><input type="text" name="id" readonly="true" value="<?= $fields[$key] ?>"/></td>
                            <?php else: ?>
                                <td><?= $fields[$key] ?></td>
                        <?php endif; endif; endforeach; ?>
                    <td>
                        <a href="<?= $fields["edit"]->getUrl() ?>" class="btn btn-edit">Modifier</a>
                        <?php if(isset($fields['destroy'])): ?>
                            <input type="submit" name="destroy" class="btn btn-remove" value="Supprimer"/>
                        <?php endif; ?>
                    </td>
                </tr>
            </form>
        <?php endforeach;?>
    <?php endforeach;?>
</table>