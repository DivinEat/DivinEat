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

    <?php foreach ($data["fields"] as $categorie => $elements): ?>
        <tr>
            <th><?= $categorie ?></th>
            <?php for($i = 0; $i < sizeof($data["colonnes"]) - 1;$i++):?>
                <th></th>
            <?php endfor;?>
        </tr>
        <?php foreach ($elements as $key => $fields): ?>
            <form method="POST" action="<?= $fields["destroy"]->getUrl() ?>">
                <?php csrfInput(); ?>
                <?php if(strtolower($categorie) == "menu"): ?>
                        <tr>
                            <td><input type="hidden" name="categorie" value="<?= $categorie ?>"/></td>
                            <td><input type="text" name="id" readonly="true" value="<?= $fields["id"] ?>"/></td>
                            <td><?= $fields["nom"] ?></td>
                            <td><?= $fields["entree"] ?></td>
                            <td><?= $fields["plat"] ?></td>
                            <td><?= $fields["dessert"] ?></td>
                            <td><?= $fields["prix"]." Euro(s)" ?></td>
                            <td>
                                <a href="<?= $fields["edit"]->getUrl() ?>" class="btn btn-edit">Modifier</a>
                                <input type="submit" name="destroy" class="btn btn-remove" value="Supprimer"/>
                            </td>
                        </tr>
                <?php else:?>
                    <tr>
                        <td><input type="hidden" name="categorie" value="<?= $categorie ?>"/></td>
                        <td><input type="text" name="id" readonly="true" value="<?= $fields["id"] ?>"/></td>
                        <td><?= $fields["nom"] ?></td>
                        <td><?= $fields["description"] ?></td>
                        <td><?= $fields["prix"]." Euro(s)" ?></td>
                        <td>
                            <a href="<?= $fields["edit"]->getUrl() ?>" class="btn btn-edit">Modifier</a>
                            <input type="submit" name="destroy" class="btn btn-remove" value="Supprimer"/>
                        </td>
                    </tr>
                <?php endif; ?>
            </form>
        <?php endforeach;?>
    <?php endforeach;?>
</table>