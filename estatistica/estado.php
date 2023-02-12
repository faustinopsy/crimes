<?php
header("Content-Type: application/json; charset=UTF-8");
$estados = 'estados.json';
$regioes = 'capital.json';
require '../vendor/autoload.php';

use \App\Entity\MapaSP;

 
$mapasp = new MapaSP;
$ano='2022';

$crime=MapaSP::getMapaApi(intval(filter_var($ano, FILTER_SANITIZE_NUMBER_INT)));

$filteredResult = [];
$tiposPermitidos = [
	'Roubo outros',
	'Roubo de veiculo',
	'Roubo de carga',
	'Furto outros', 
	'Furto de veiculo'];
	$resultado = json_decode(json_encode($crime), true);
foreach($resultado as $key => $value) {
  if (in_array($value["tipo_crime"], $tiposPermitidos)) {
    $filteredResult[] = $value;
  }
}

echo '{"crime": [';
foreach($filteredResult as $key => $value) {
	echo '

	{

	"name":"'.$value["bairro"].'",
	"tipo":"'.$value["tipo_crime"].'",
	"Jan":"'.$value["mes1"].'",
	"Fev":"'.$value["mes2"].'",
	"Mar":"'.$value["mes3"].'",
	"Abr":"'.$value["mes4"].'",
	"Mai":"'.$value["mes5"].'",
	"Jun":"'.$value["mes6"].'",
	"Jul":"'.$value["mes7"].'",
	"Ag":"'.$value["mes8"].'",
	"Set":"'.$value["mes9"].'",
	"Out":"'.$value["mes10"].'",
	"Nov":"'.$value["mes11"].'",
	"Dez":"'.$value["mes12"].'",
	"value":"'.$value["total"].'"

	},'; 


	$jan[] = array('name'=> $value["bairro"], 'tipo'=> $value["tipo_crime"],'value'=>$value["mes1"]);
	$fev[] = array('name'=> $value["bairro"], 'tipo'=> $value["tipo_crime"],'value'=>$value["mes2"]);
	$mar[] = array('name'=> $value["bairro"], 'tipo'=> $value["tipo_crime"],'value'=>$value["mes3"]);
	$abr[] = array('name'=> $value["bairro"], 'tipo'=> $value["tipo_crime"],'value'=>$value["mes4"]);
	$mai[] = array('name'=> $value["bairro"], 'tipo'=> $value["tipo_crime"],'value'=>$value["mes5"]);
	$jun[] = array('name'=> $value["bairro"], 'tipo'=> $value["tipo_crime"],'value'=>$value["mes6"]);
	$jul[] = array('name'=> $value["bairro"], 'tipo'=> $value["tipo_crime"],'value'=>$value["mes7"]);
	$ago[] = array('name'=> $value["bairro"], 'tipo'=> $value["tipo_crime"],'value'=>$value["mes8"]);
	$set[] = array('name'=> $value["bairro"], 'tipo'=> $value["tipo_crime"],'value'=>$value["mes9"]);
	$out[] = array('name'=> $value["bairro"], 'tipo'=> $value["tipo_crime"],'value'=>$value["mes10"]);
	$nov[] = array('name'=> $value["bairro"], 'tipo'=> $value["tipo_crime"],'value'=>$value["mes11"]);
	$dez[] = array('name'=> $value["bairro"], 'tipo'=> $value["tipo_crime"],'value'=>$value["mes12"]);
	//$regi[]= array('name'=> $name,'ganhadores'=>$ganhadores);
}



echo ']}';

$response['jan'] = $jan;
$response['fev'] = $fev;
$response['mar'] = $mar;
$response['abr'] = $abr;
$response['mai'] = $mai;
$response['jun'] = $jun;
$response['jul'] = $jul;
$response['ago'] = $ago;
$response['set'] = $set;
$response['out'] = $out;
$response['nov'] = $nov;
$response['dez'] = $dez;

$fp = fopen('capital.json', 'w');
fwrite($fp, json_encode($response, JSON_UNESCAPED_UNICODE));
fclose($fp);


?>