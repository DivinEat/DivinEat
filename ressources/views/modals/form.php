<?php $inputData = $GLOBALS["_".strtoupper($data["config"]["method"])]; ?>

<form method="<?= $data["config"]["method"]?>" action="<?= $data["config"]["action"]?>"
id="<?= $data["config"]["id"]?>" class="<?= $data["config"]["class"]?>">

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