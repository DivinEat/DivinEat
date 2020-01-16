<?php 
class Validator{

	public static function checkForm($configForm, $data){
		$listOfErrors = [];

		//Vérifications

		//Vérifier le nb de input
		if( count($configForm["fields"]) == count($data) ) {

			foreach ($configForm["fields"] as $name => $config) {
				//Vérifier les required
				if( !array_key_exists($name, $data) || 
					( $config["required"] && empty($data[$name]))
				){
					return ["Tentative de hack !!!"];
				}
				//Vérifier l'email
				if($config["type"]=="email"){
					
					if(self::checkEmail($data[$name])){
						//Vérifier l'unicité de l'email
					}else{
						$listOfErrors[]=$config["errorMsg"];
					}
				}
				//Vérifier le captcha
				if($config["type"]=="captcha") {
					if($_SESSION["captcha"] != strtolower($data[$name])){
						$listOfErrors[]=$config["errorMsg"];
					}
				}
				//Vérifier le password
				if($name=="pwd"){
					if(strlen($data[$name]) < 8)
						$listOfErrors[]="Le mot de passe est trop court !";
					if(!preg_match("#[0-9]+#", $data[$name]))
						$listOfErrors[]="Le mot de passe doit inclure au moins un chiffre !";
					if(!preg_match("#[a-z]+#",$data[$name]))
						$listOfErrors[]="Le mot de passe doit inclure au moins une lettre !";
					if(!preg_match("#[A-Z]+#",$data[$name]))
						$listOfErrors[]="Le mot de passe doit inclure au moins une majuscule !";
					if(!preg_match("#\W+#",$data[$name]))
						$listOfErrors[]="Le mot de passe doit inclure au moins un caractère spécial !";
				}
				//Vérifier les confirm
				if($name=="pwdConfirm"){
					if($data[$name] != $data["pwd"]){
						$listOfErrors[]=$config["errorMsg"];
					}
				}
			}

		}else{
			return ["Tentative de hack !!!"];
		}

		return $listOfErrors;
	}

	public static function checkEmail($email){
		$email = trim($email);
		return filter_var($email, FILTER_VALIDATE_EMAIL);
	}

	public static function checkPwd($email){
	}

}