<form method="<?= $data["config"]["method"]?>" action="<?= $data["config"]["action"]->getUrl() ?>"
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
						<?php foreach ($configField["values"] as $value):?>
							<option value="<?= $value["value"]?>" selected="<?= $value["selected"] ?>"><?= $value["text"] ?></option>	
						<?php endforeach;?>
					</select>	
				<?php else:?>
					<input 
						value="<?= (isset($configField["value"]) && $configField["type"]!="password")?$configField["value"]:'' ?>"
						type="<?= $configField["type"]??'' ?>"
						name="<?= $name??'' ?>"
						placeholder="<?= $configField["placeholder"]??'' ?>"
						class="<?= $configField["class"]??'' ?>"
						id="<?= $configField["id"]??'' ?>"
						<?=(!empty($configField["required"]))?"required='required'":""?>
						<?=(!empty($configField["disabled"]))?"disabled":""?>
					>
				<?php endif;?>
			</div>
		</div>
	<?php endforeach;?>

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