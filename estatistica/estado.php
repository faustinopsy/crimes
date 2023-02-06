<?php
header("Content-Type: application/json; charset=UTF-8");
$estados = 'estados.json';
$regioes = 'regioes.json';
require '../vendor/autoload.php';

use \App\Entity\Lotofacil;

 
$jogo = new Lotofacil;
$jogo=Lotofacil::getSorteioDatamapa();


	 $resultado = json_decode(json_encode($jogo), true);
$regi=[];

 echo '{"regiao": [';
foreach($resultado as $value)
{
	$name=$value['uf'];
	$total=$value['total'];
	$ganhadores=$value['ganhadores'];
	echo '

	{

	"name":"'.$name.'",
	"ganhadores":"'.$ganhadores.'",

	"value":"'.$total.'"

	},'; 


	$posts[] = array('name'=> $name, 'value'=> $total,'ganhadores'=>$ganhadores);
	$regi[]= array('name'=> $name,'ganhadores'=>$ganhadores);
}



echo ']}';


$response['regiao'] = $posts;

$fp = fopen('estados.json', 'w');
fwrite($fp, json_encode($response, JSON_UNESCAPED_UNICODE));
fclose($fp);



$regioes=[];
$totalsul=0;
$totalnorte=0;
$totalnordeste=0;
$totalsudeste=0;
$totaloeste=0;
foreach($regi as $value)
{ 

	if(in_array('RS', $value) || in_array('PR', $value) || in_array('SC', $value))
	{
		
	$totalsul+=$value['ganhadores'];
	}
	elseif(in_array('SP', $value) || in_array('RJ', $value) || in_array('MG', $value) || in_array('ES', $value))
	{
	$totalsudeste+=$value['ganhadores'];
	}
	elseif(in_array('MA', $value) || in_array('CE', $value) || in_array('RN', $value) || in_array('PI', $value)
	|| in_array('BA', $value)|| in_array('PE', $value)|| in_array('PB', $value)|| in_array('AL', $value)|| in_array('SE', $value))
	{
	$totalnordeste+=$value['ganhadores'];
	}
	elseif(in_array('RO', $value) || in_array('RR', $value) || in_array('AM', $value) || in_array('AC', $value) || in_array('PA', $value)
	|| in_array('TO', $value) || in_array('AM', $value))
	{
	$totalnorte+=$value['ganhadores'];
	}
	elseif(in_array('MT', $value) || in_array('MS', $value) || in_array('GO', $value) || in_array('DF', $value))
	{
	$totaloeste+=$value['ganhadores'];
	}
}
$regioes['Sul']=['total'=>$totalsul];
$regioes['Norte']=['total'=>$totalnorte];
$regioes['Sudeste']=['total'=>$totalsudeste];
$regioes['Nordeste']=['total'=>$totalnordeste];
$regioes['Centro-Oeste']=['total'=>$totaloeste];
echo '{"regiao": [';
foreach($regioes as $key=>$value){
	

	$name=$key;
	$total=$value['total'];
	echo '

	{

	"name":"'.$name.'",
	"value":"'.$total.'"

	},'; 


	$posts[] = array('name'=> $name, 'value'=> $total);


}

echo ']}';



$response['regiao'] = $posts;

$fp = fopen('regioes.json', 'w');
fwrite($fp, json_encode($response, JSON_UNESCAPED_UNICODE));
fclose($fp);
?>