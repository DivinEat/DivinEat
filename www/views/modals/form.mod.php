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

				<input 
					value="<?= (isset($inputData[$name]) && $configField["type"]!="password")?$inputData[$name]:'' ?>"
					type="<?= $configField["type"]??'' ?>"
					name="<?= $name??'' ?>"
					placeholder="<?= $configField["placeholder"]??'' ?>"
					class="<?= $configField["class"]??'' ?>"
					id="<?= $configField["id"]??'' ?>"
					<?=(!empty($configField["required"]))?"required='required'":""?> 
				>
			</div>
		</div>
	<?php endforeach;?>
	
	<?php foreach ($data["config"]["submit"] as $name => $configBtn):?>
		<button class="<?= "btn ".$name??'' ?>"><?= $configBtn;?></button>
	<?php endforeach;?>
</form>