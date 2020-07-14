<script type="module" src="<?= url('js/update_order.js') ?>"></script>

<?php
use App\Managers\OrderManager;
use App\Managers\MenuOrderManager;

$orderManager = new OrderManager;
$menuOrderManager = new MenuOrderManager;

$elements = $form->getBuilder()->getElements();

$order = $orderManager->find(explode('/', getenv('REQUEST_URI'))[3]);
$menuOrders = $menuOrderManager->findBy(["order" => $order->getId()]);
$menus = [];

foreach ($menuOrders as $menuOrder) {
    $menus[] = $menuOrderManager->find($menuOrder->getMenu()->getId());
}
?>

<?php foreach ($elements as $element) : ?>
    <?php if ($element->getName() !== "id") : ?>
        <?php if ($element->getName() == "updateFormOrder_menu0") : ?>
            <div id="add_menu_area">
                <div class="form-group row">
                    <div class="col-sm-12">
        <?php else : ?>
            <div class="form-group row">
                <div class="col-sm-12">
        <?php endif; ?>
    <?php endif; ?>
            <?php
            $options = $element->getOptions();
            include $element->getLayoutPath();
            ?>
    <?php if ($element->getName() !== "id") : ?>
            </div>
        </div>
        
        <?php if (substr_replace($element->getName() ,"",-1) == "updateFormOrder_menu") : ?>
            <?php $menu_index = $element->getName()[strlen($element->getName()) - 1] ?>
            <?php if (is_numeric($menu_index) && (intval($menu_index)+1) == count($menus) ) : ?>
                </div>
                <div id='add_menu_btn' class='btn btn-default'>Ajouter un menu</div>
                <div id='remove_menu_btn' class='btn btn-remove' style='display: none'>Supprimer le dernier menu</div>
            <?php endif; ?>
        <?php endif; ?>
    <?php endif; ?>

<?php endforeach; ?>
