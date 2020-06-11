<?php
use App\Managers\ElementMenuManager;
$elementMenuManager = new ElementMenuManager();
?>

<table class="<?= $data["config"]["class"]?>">
    <tr>
        <?php foreach ($data["colonnes"] as $name => $colonnes):?>
                <th><?= $colonnes ?></th>
        <?php endforeach;?>
    </tr>

    <?php foreach ($data["fields"] as $categorie => $elements):?>
        <tr>
            <th><?= $categorie ?></th>
            <?php foreach ($elements as $key => $fields): ?>
                <th></th>
            <?php endforeach;?>
            <th></th>
        </tr>
        <?php foreach ($elements as $key => $fields):
            if(strtolower($categorie) == "menu"):    
        ?>
                <tr>
                    <td></td>
                    <td><?= $fields["id"] ?></td>
                    <td><?= $fields["nom"] ?></td>
                    <td><?= $elementMenuManager->find($fields["entree"])->getNom() ?></td>
                    <td><?= $elementMenuManager->find($fields["plat"])->getNom() ?></td>
                    <td><?= $elementMenuManager->find($fields["dessert"])->getNom() ?></td>
                    <td><?= $fields["prix"]." Euro(s)" ?></td>
                    <td>
                        <a href="<?= $data["config"]["edit"]?>" class="btn btn-edit">Modifier</a>
                        <a href="<?= $data["config"]["cancel"]?>" class="btn btn-remove">Supprimer</a>
                    </td>
                </tr>
            <?php else:?>
                <tr>
                    <td></td>
                    <td><?= $fields["id"] ?></td>
                    <td><?= $fields["nom"] ?></td>
                    <td><?= $fields["description"] ?></td>
                    <td><?= $fields["prix"]." Euro(s)" ?></td>
                    <td>
                        <a href="<?= $data["config"]["edit"]?>" class="btn btn-edit">Modifier</a>
                        <a href="<?= $data["config"]["cancel"]?>" class="btn btn-remove">Supprimer</a>
                    </td>
                </tr>
            <?php endif;
        endforeach;?>
    <?php endforeach;?>
</table>