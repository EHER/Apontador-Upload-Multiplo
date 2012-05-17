<?php
error_reporting(-1);
require './classes/url_reader.php';
require 'config.php';
$port = 80;

//pega locais pesquisados por address ou apenas informacoes do local (se o lbsid for informado)
$url = '';
if(!isset($_GET['lbsid'])){
	$url = 'http://api.apontador.com.br/v1/search/places/byaddress?type=json&radius_mt=10000';

	$cidade = explode(',', utf8_decode($_REQUEST['city']));
	$uf = tiraAcento(strtoupper($cidade[1]));
	$cidade = tiraAcento($cidade[0]);
	
	$term = tiraAcento(utf8_decode(urldecode($_REQUEST['term'])));
	$cidade = $cidade;
	$uf = urlencode($uf);
	$term = urlencode($term);
	$url .= "&city={$cidade}&state={$uf}&term={$term}";
			
}else{
	$placeid = $_GET['lbsid'];
	$url = sprintf('http://api.apontador.com.br/v1/places/%s?type=json',$placeid);
}

//echo $url;
$options = array(
    CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
    CURLOPT_PORT => $port,
    CURLOPT_USERPWD => "{$key}:{$secret}",
);
    
$reader = new Url_Reader($url, $options);

if ($reader->success()) {
    //retornou legal do servidor
    //echo $reader->get();
    //echo mb_detect_encoding($reader->get());
    $aRetorno = json_decode($reader->get());
    $places = array();
    //var_dump($aRetorno);
    if(!isset($_GET['lbsid'])){
	    if(intval($aRetorno->search->result_count) > 0){
			foreach($aRetorno->search->places as $k=>$place){
			    $place = $place->place;
			    $places[$k]['lbsid'] = $place->id;
			    $places[$k]['nome'] = $place->name;
			    $places[$k]['link'] = $place->main_url;
			    $places[$k]['endereco'] = $place->address->street . ' ' . $place->address->number;
			}
	    }
    }else{//se a busca for por lbsid o formato de retorno é um pouco diferente
    	$place = $aRetorno->place;
	    $places['lbsid'] = $place->id;
	    $places['nome'] = $place->name;
	    $places['link'] = $place->main_url;
	    $places['endereco'] = $place->address->street . ' ' . $place->address->number;
	    $places = array($places);
    }

    echo json_encode($places);
} else {
    //deu merda
//    var_dump($reader->get_return_info());
    echo json_encode(array());
}


/**
	*Modelo novo - Luis Ribeiro
	*arquivo em utf-8 para o vitrine �?mo
	*no carrefour tem uma em iso8859-1(ANSI)
	*/

	function tiraAcento($entrada){
	    
		$saida = "";
	    //$saida = urldecode($entrada);
		
		$acento = array( 
							'Á', 'À', 'Ã', 'Â', 'Ä', 'Ó', 'Ò', 'Õ', 'Ô', 'Ö', 'É', 'È', 'Ê', 'Ë', 'Í', 'Ì', 'Î', 'Ï', 'Ú', 'Ù', 'Û', 'Ü', 'Ç',
							'á', 'à', 'ã', 'â', 'ä', 'ó', 'ò', 'õ', 'ô', 'ö', 'é', 'è', 'ê', 'ë', 'í', 'ì', 'î', 'ï', 'ú', 'ù', 'û', 'ü', 'ç','ñ','Ñ'
						);
						
		$semAcento = array(
							'A', 'A', 'A', 'A', 'A', 'O', 'O', 'O', 'O', 'O', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'U', 'U', 'U', 'U', 'C',
							'a', 'a', 'a', 'a', 'a', 'o', 'o', 'o', 'o', 'o', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'u', 'u', 'u', 'u', 'c','n','N'
						);
		
	    $saida = str_replace( $acento, $semAcento, $entrada );
		
	    return $saida;
	}