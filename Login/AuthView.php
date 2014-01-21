<?php
class AuthView{
	public function show($template){
		$templatePath="views/${template}.inc";
		if(file_exists($templatePath)){
			include $templatePath;
		}
	}
}
?>