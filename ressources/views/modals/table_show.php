<table class="<?= $data["config"]["class"]?>">
    <tr>
        <?php foreach ($data["colonnes"] as $name => $colonnes):?>
                <th><?= $colonnes ?></th>
        <?php endforeach;?>
    </tr>

    <?php foreach ($data["fields"] as $categorie => $elements):?>
        <tr>
            <th><?= $categorie ?></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
        <?php foreach ($elements as $key => $fields):?>
        <tr>
            <td></td>
            <td><?= $fields["name"] ?></td>
            <td><?= $fields["description"] ?></td>
            <td><?= $fields["prix"]." Euro(s)" ?></td>
            <td>
                <a href="<?= helpers::getUrl("Menu", "edit")?>" class="btn btn-edit">Modifier</a>
                <a href="" class="btn btn-remove">Supprimer</a>
            </td>
        </tr>
        <?php endforeach;?>
    <?php endforeach;?>
</table>