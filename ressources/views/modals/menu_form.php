<?php $inputData = $GLOBALS["_".strtoupper($data["config"]["method"])]; ?>

<form method="<?= $data["config"]["method"]?>" action="<?= $data["config"]["action"]?>"
id="<?= $data["config"]["id"]?>" class="<?= $data["config"]["class"]?>">

	<div class="form-group row">
		<div class="col-sm-12">
			<label>Catégories</label>
			<select name="entrees" class="form-control" onchange="showCategories(this.value)">
				<option value="1">Menu</option>
				<option value="2">Entrée</option>
				<option value="3">Plat</option>
				<option value="4">Dessert</option>
				<option value="5">Boisson</option>
			</select>
		</div>
	</div>	

	<?php var_dump($desserts); ?>
	<div id="select" style="display: none;">
		<div class="form-group row">
			<div class="col-sm-12">
				<label>Entrées</label>
				<select name="entrees" class="form-control">
					<?php foreach ($entrees as $entree):?>
						<option value="<?= $entree->id??'' ?>"><?= $entree->nom??'' ?></option>	
					<?php endforeach;?>
				</select>
			</div>
		</div>	
		<div class="form-group row">
			<div class="col-sm-12">
				<label>Plats</label>
				<select name="plats" class="form-control">
					<?php foreach ($plats as $plat):?>
						<option value="<?= $plat->id??'' ?>"><?= $plat->nom??'' ?></option>	
					<?php endforeach;?>
				</select>
			</div>
		</div>	
		<div class="form-group row">
			<div class="col-sm-12">
				<label>Desserts</label>
				<select name="desserts" class="form-control">
					<?php foreach ($desserts as $dessert):?>
						<option value="<?= $dessert->id??'' ?>"><?= $dessert->nom??'' ?></option>	
					<?php endforeach;?>
				</select>
			</div>
		</div>	
	</div>

	<div id="input">
		<?php foreach ($data["fields"] as $name => $configField):?>
			<div class="form-group row">
				<div class="col-sm-12">
					<?php if($configField["type"] == "captcha"):?>
						<img src="script/captcha.php" width="300px">
					<?php endif;?>

					<?php if(!empty($configField["label"])):?>
						<label><?=$configField["label"]?></label>
					<?php endif;?>

					<!-- En fonction du type (input, textarea, select) -->
					<?php if(!empty($configField["type"]) && $configField["type"] == "textarea"):?>
						<textarea 
							id="<?= $configField["id"]??'' ?>"
							name="<?= $name??'' ?>"
							class="<?= $configField["class"]??'' ?>"
							rows="5"
						></textarea>
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
					<?php else:?>
						<input 
							value="<?= (isset($inputData[$name]) && $configField["type"]!="password")?$inputData[$name]:'' ?>"
							type="<?= $configField["type"]??'' ?>"
							name="<?= $name??'' ?>"
							placeholder="<?= $configField["placeholder"]??'' ?>"
							class="<?= $configField["class"]??'' ?>"
							id="<?= $configField["id"]??'' ?>"
							<?=(!empty($configField["required"]))?"required='required'":""?> 
						>
					<?php endif;?>
				</div>
			</div>
		<?php endforeach;?>	
	</div>
	
	<?php if(!empty($data["config"]["annuler"])):?>
		<a 
			href="<?= $data["config"]["annuler"]["action"] ?>" 
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