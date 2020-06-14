<div class="row">
    <div class="col-sm-12">
        <div class="col-inner">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Modifier un menu</h3>
                </div>
                <div class="box-body">
                    <?php 
                        $infos = [
                            "entrees" => $entrees,
                            "plats" => $plats,
                            "desserts" => $desserts,
                            "categorie" => $categorie,
                            "object" => $object
                        ];
                        $this->addModal("menu_form", $configFormMenu, $infos);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>