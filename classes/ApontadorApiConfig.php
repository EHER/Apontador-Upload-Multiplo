<?php
/**
 * ApontadorApiConfig.php
 *
 * Configurações do aplicativo que vai acessar a Apontador API via ApontadorApiLib.php
 * (podem ser obtidas no perfil do usuário "dono" do aplicativo em http://www.apontador.com.br)
 *
 * Copyright 2010 Carlos Duarte do Nascimento (Chester)
 * 
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 * 
 *    http: *www.apache.org/licenses/LICENSE-2.0
 * 
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 */

//
// PREENCHA SEUS DADOS AQUI!
function apontadorGetConfig() {	
	if($_SERVER['HTTP_HOST'] != 'localhost'){
		return array(
			"email" => "ricardo.martins@lbslocal.com",
	//		"key" => "36gcCCI_nv1kQrWTGjnXCBfgVjlCT8KITrkOp_HcopA~",
	//		"secret" => "q5_prXzkYCfpr9EB8k4br5ec8uE~",
			"key" => "36gcCCI_nv1kQrWTGjnXCBfgVjlCT8KITrkOp_HcopA~",
			"secret" => "q5_prXzkYCfpr9EB8k4br5ec8uE~",
			"callbackurl" =>  "http://apontador.ricardomartins.info/upload_multiplo/callback.php"
		);
	}else{
		return array(
			"email" => "ricardo.martins@lbslocal.com",
	//		"key" => "36gcCCI_nv1kQrWTGjnXCBfgVjlCT8KITrkOp_HcopA~",
	//		"secret" => "q5_prXzkYCfpr9EB8k4br5ec8uE~",
			"key" => "36gcCCI_nv2NKa5aEz4RA_9tJYkrnnPS__o_fgRn4uE~",
			"secret" => "WDqV7pv0VZLum53kTuCJN6Ji5vc~",
			"callbackurl" =>  "http://localhost/apontador/upload_multiplo/callback.php"
		);
	}
}

$apontadorConfigTeste = apontadorGetConfig();
if (!$apontadorConfigTeste["email"]) {
	die("Por favor, cadastre sua aplicação no apontador e coloque seus dados no arquivo ApontadorApiConfig.php");
}