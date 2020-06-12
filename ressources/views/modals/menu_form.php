
<?php
$inputData = $GLOBALS["_".strtoupper($data["config"]["method"])];

$displaySelect = "block";
$displayInput = "none";

if(isset($infos["object"]) && isset($infos["categorie"])){
	$object = $infos["object"];
	$categorie = $infos["categorie"];
	if($categorie != "menu"){
		$displaySelect = "none";
	}
	$displayInput = "block";
}
?>

<form method="<?= $data["config"]["method"]?>" action="<?= $data["config"]["action"]->getUrl() ?>"
id="<?= $data["config"]["id"]?>" class="<?= $data["config"]["class"]?>">
	
	<div class="form-group row">
		<div class="col-sm-12">
			<label >Catégories</label>
			<?php if(!isset($categorie)): ?>
				<select name="categories" class="form-control" onchange="showCategories(this.value)">
					<option value="1">Menu</option>
					<option value="2">Entrée</option>
					<option value="3">Plat</option>
					<option value="4">Dessert</option>
					<option value="5">Boisson</option>
				</select>
			<?php else: ?>
				<input type="text" name="categorie" class="form-control" readonly="true" value="<?= ucfirst($categorie) ?>">
			<?php endif; ?>
		</div>
	</div>

	<?php if(isset($categorie)): ?>
		<input type="hidden" name="id" class="form-control" readonly="true" value="<?= $object->getId() ?>">
	<?php endif; ?>

	<div id="select" style="display: <?= $displaySelect ?>;">
		<div class="form-group row">
				<div class="col-sm-12">
					<label>Nom</label>
					<input type="text" name="nomMenu" class="form-control" <?= (isset($object))?'value="'.$object->getNom().'"':'' ?>>
			</div>
		</div>	
		<div class="form-group row">
			<div class="col-sm-12">
				<label>Entrées</label>
				<select name="entrees" class="form-control">
					<option value="0"></option>
					<?php foreach ($infos["entrees"] as $entree):?>
						<option 
							value="<?= $entree->getId()??'' ?>" 
							<?= (isset($object) && $object instanceof App\Models\Menu && (!empty($object->getEntree()) && $object->getEntree() == $entree->getId()))?'selected="selected"':'' ?>>
							<?= $entree->getNom()??'' ?>
						</option>	
					<?php endforeach;?>
				</select>
			</div>
		</div>	
		<div class="form-group row">
			<div class="col-sm-12">
				<label>Plats</label>
				<select name="plats" class="form-control">
					<option value="0"></option>
					<?php foreach ($infos["plats"] as $plat):?>
						<option 
							value="<?= $plat->getId()??'' ?>" 
							<?= (isset($object) && $object instanceof App\Models\Menu && (!empty($object->getPlat()) && $object->getPlat() == $plat->getId()))?'selected="selected"':'' ?>>
							<?= $plat->getNom()??'' ?>
						</option>
					<?php endforeach;?>
				</select>
			</div>
		</div>	
		<div class="form-group row">
			<div class="col-sm-12">
				<label>Desserts</label>
				<select name="desserts" class="form-control">
					<option value="0"></option>
					<?php foreach ($infos["desserts"] as $dessert): ?>
						<option 
							value="<?= $dessert->getId()??'' ?>" 
							<?= (isset($object) && $object instanceof App\Models\Menu && (!empty($object->getDessert()) && $object->getDessert() == $dessert->getId()))?'selected="selected"':'' ?>>
							<?= $dessert->getNom()??'' ?>
						</option>
					<?php endforeach;?>
				</select>
			</div>
		</div>	
	</div>

	<div id="input" style="display: <?= $displayInput ?>;">
		<?php if(isset($data["fields"])):
			foreach ($data["fields"] as $name => $configField): 
			$method = "get".$configField["label"]; ?>
			<div class="form-group row">
				<div class="col-sm-12">
					<?php if(!empty($configField["label"])):?>
						<label><?=$configField["label"]?></label>
					<?php endif;?>

					<!-- En fonction du type (input, textarea, select) -->
					<?php if(!empty($configField["type"]) && $configField["type"] == "textarea"): ?>
						<textarea 
							id="<?= $configField["id"]??'' ?>"
							name="<?= $name??'' ?>"
							class="<?= $configField["class"]??'' ?>"
							rows="5"
						><?= (isset($object))?$object->$method():'' ?></textarea>
					<?php elseif(!empty($configField["type"]) && $configField["type"] == "select"):?>
						<select 
							name="<?= $name??'' ?>"	
							class="<?= $configField["class"]??'' ?>"
							id="<?= $configField["id"]??'' ?>"
						>
							<?php foreach ($configField["values"] as $value => $text):?>
								<option value="<?= $value??'' ?>"><?= $text??'' ?></option>	
							<?php endforeach;?>
						</select>	
					<?php else: ?>
						<input 
							value="<?= (isset($object))?$object->$method():'' ?>"
							type="<?= $configField["type"]??'' ?>"
							name="<?= $name??'' ?>"
							placeholder="<?= $configField["placeholder"]??'' ?>"
							class="<?= $configField["class"]??'' ?>"
							id="<?= $configField["id"]??'' ?>"
						>
					<?php endif;?>
				</div>
			</div>
		<?php endforeach;
		endif;?>	
	</div>
	
	<?php if(!empty($data["config"]["annuler"])):?>
		<a 
			href="<?= $data["config"]["annuler"]["action"]->getUrl() ?>" 
			class="<?= $data["config"]["annuler"]["class"] ?>"
		>
			<?= $data["config"]["annuler"]["text"] ?>
		</a>
	<?php endif;?>

	<?php foreach ($data["config"]["submit"] as $name => $configBtn):?>
		<button class="<?= "btn ".$name??'' ?>"><?= $configBtn;?></button>
	<?php endforeach;?>
</form>

<script>
	function showCategories(param){
		if(param == 1) {
			document.getElementById('select').style.display='block';
			document.getElementById('input').style.display='none';
		} else {
			document.getElementById('select').style.display='none';
			document.getElementById('input').style.display='block';
		}
	}
</script>