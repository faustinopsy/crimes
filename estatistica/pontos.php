<?php
header("Content-Type: application/json; charset=UTF-8");
$regioes = 'pontosdecrime.json';
require '../vendor/autoload.php';
use \App\Entity\Crimes;

$mapasp = new Crimes;

$crime=Crimes::getPontosApi();
$resultado = json_decode(json_encode($crime), true);

$filteredResult = [];
$tiposPermitidos = ['Roubo de Veículo','Furto de Veículo'];
	
foreach($resultado as $key => $value) {
  if (in_array($value["tipo"], $tiposPermitidos)) {
    $filteredResult[] = $value;
  }
}

$result=[];
foreach($filteredResult as $key => $value) {
	$bairroCount = array();
	$ba= array();
		$rua = $value["rua"];
		if (!isset($bairroCount[$rua])) {
			$bairroCount[$rua] = 1;
		} else {
			$bairroCount[$rua]++;
		}
		$ba["quantidade"] = $bairroCount[$rua];
		

	$result[] = array(
		"bairro"=>$value["bairro"],
		"tipo"=>$value["tipo"],
		"value"=>$bairroCount[$rua],
		"data"=>$value["data"],
		"latitude"=>$value["lat"],
		"longitude"=>$value["lng"],
		"rua"=>$value["rua"]
);

}

$response= $result;

$fp = fopen('pontosdecrime.json', 'w');
fwrite($fp, json_encode($response, JSON_UNESCAPED_UNICODE));
fclose($fp);


?>