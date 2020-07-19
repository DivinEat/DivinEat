<div class="row mt-4 total-height">
    <div class="col-sm-12 frame-menus">
        <div>
            <div class="row"><span>Menus</span></div>
            <div class="ligne"></div>
            <div class="row">
                <?php if(isset($menus)):
                    $count = count($menus) / 2; ?>
                    <div class="col-sm-12 col-md-6">
                        <div class="col-inner">
                            <?php for($i = 0; $i < $count; $i++): 
                                if(isset($menus[$i])): ?>
                                    <div class="menu">
                                        <div><b><?= $menus[$i]->getNom() ?></b> <?= " - <i>".$menus[$i]->getEntree()->getNom()
                                            .", ".$menus[$i]->getPlat()->getNom().", ".$menus[$i]->getDessert()->getNom() ?></i></div>
                                        <div><?= $menus[$i]->getPrix() ?></div>
                                    </div>
                                <?php endif;
                            endfor; ?>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="col-inner">
                            <?php if (count($menus)%2 != 0){ $count++; }
                            for($i = $count; $i < count($menus); $i++): 
                                if(isset($menus[$i])): ?>
                                    <div class="menu">
                                        <div><b><?= $menus[$i]->getNom() ?></b> <?= " - <i>".$menus[$i]->getEntree()->getNom()
                                            .", ".$menus[$i]->getPlat()->getNom().", ".$menus[$i]->getDessert()->getNom() ?></i></div>
                                        <div><?= $menus[$i]->getPrix() ?></div>
                                    </div>
                                <?php endif;
                            endfor; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-sm-12 col-md-6 frame-menus">
        <div>
            <div class="row"><span>Boissons</span></div>
            <div class="ligne"></div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="col-inner">
                        <?php foreach($elementMenus as $elementMenu): ?>
                            <?php if($elementMenu->getCategorie() == "boisson"): ?>
                                <div class="menu">
                                    <div><b><?= $elementMenu->getNom() ?></b><?= " - <i>".$elementMenu->getDescription() ?></i></div>
                                    <div><?= $elementMenu->getPrix() ?></div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-12 col-md-6 frame-menus">
        <div>
            <div class="row"><span>Entrées</span></div>
            <div class="ligne"></div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="col-inner">
                        <?php foreach($elementMenus as $elementMenu): ?>
                            <?php if($elementMenu->getCategorie() == "entree"): ?>
                                <div class="menu">
                                    <div><b><?= $elementMenu->getNom() ?></b><?= " - <i>".$elementMenu->getDescription() ?></i></div>
                                    <div><?= $elementMenu->getPrix() ?></div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-12 frame-menus">
        <div>
            <div class="row"><span>Plats</span></div>
            <div class="ligne"></div>
            <div class="row">
            <?php if(isset($plats)):
                    $count = count($plats) / 2; ?>
                    <div class="col-sm-12 col-md-6">
                        <div class="col-inner">
                            <?php for($i = 0; $i < $count; $i++): 
                                if(isset($plats[$i])): ?>
                                    <div class="menu">
                                        <div><b><?= $plats[$i]->getNom() ?></b><?= " - <i>".$plats[$i]->getDescription() ?></i></div>
                                        <div><?= $plats[$i]->getPrix() ?></div>
                                    </div>
                                <?php endif;
                            endfor; ?>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="col-inner">
                            <?php if (count($plats)%2 != 0){ $count++; }
                            for($i = $count; $i < count($plats); $i++): 
                                if(isset($plats[$i])): ?>
                                    <div class="menu">
                                        <div><b><?= $plats[$i]->getNom() ?></b><?= " - <i>".$plats[$i]->getDescription() ?></i></div>
                                        <div><?= $plats[$i]->getPrix() ?></div>
                                    </div>
                                <?php endif;
                            endfor; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-sm-12 frame-menus">
        <div>
            <div class="row"><span>Desserts</span></div>
            <div class="ligne"></div>
            <div class="row">
            <?php if(isset($desserts)):
                    $count = count($desserts) / 2; ?>
                    <div class="col-sm-12 col-md-6">
                        <div class="col-inner">
                            <?php for($i = 0; $i < $count; $i++): 
                                if(isset($desserts[$i])): ?>
                                    <div class="menu">
                                        <div><b><?= $desserts[$i]->getNom() ?></b><?= " - <i>".$desserts[$i]->getDescription() ?></i></div>
                                        <div><?= $desserts[$i]->getPrix() ?></div>
                                    </div>
                                <?php endif;
                            endfor; ?>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="col-inner">
                            <?php if (count($desserts)%2 != 0){ $count++; }
                            for($i = $count; $i < count($desserts); $i++): 
                                if(isset($desserts[$i])): ?>
                                    <div class="menu">
                                        <div><b><?= $desserts[$i]->getNom() ?></b><?= " - <i>".$desserts[$i]->getDescription() ?></i></div>
                                        <div><?= $desserts[$i]->getPrix() ?></div>
                                    </div>
                                <?php endif;
                            endfor; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>