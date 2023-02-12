<?php
require_once __DIR__ . '/vendor/autoload.php';
use Phpml\Classification\KNearestNeighbors;

$classifier = new KNearestNeighbors();

$samples = [];
$labels = [];

$json = file_get_contents('../estatistica/capital.json');
$dados = json_decode($json, true);

$filtered = [];

foreach ($dados as $mes => $bairros) {
  foreach ($bairros as $bairro) {
    if ($bairro['tipo'] === 'Roubo de veiculo' || $bairro['tipo'] === 'Furto de veiculo') {
      $filtered[$mes][] = $bairro;
    }
  }
}

$dados = $filtered;

  foreach ($dados as $mes => $bairros) {
    foreach ($bairros as  $bairro) {
       
      $samples[] = [$bairro["value"]];
      $labels[] = $bairro["tipo"];
    }
  
}
$classifier = new KNearestNeighbors();
$classifier->train($samples, $labels);

$rouboVeiculo = [];
$furtoVeiculo = [];

foreach ($dados as $mes) {
    foreach ($mes as $bairros) {
        
            $prediction = $classifier->predict([$bairros["value"]]);
            if ($prediction === 'Roubo de veiculo') {
                $rouboVeiculo[$bairros["name"]] = isset($rouboVeiculo[$bairros["name"]]) ? $rouboVeiculo[$bairros["name"]] + $bairros["value"] : $bairros["value"];
            } elseif ($prediction === 'Furto de veiculo') {
                $furtoVeiculo[$bairros["name"]] = isset($furtoVeiculo[$bairros["name"]]) ? $furtoVeiculo[$bairros["name"]] + $bairros["value"] : $bairros["value"];
            }
        
    }
}

$bairroComMaisRoubo = array_keys($rouboVeiculo, max($rouboVeiculo))[0];
$bairroComMaisFurto = array_keys($furtoVeiculo, max($furtoVeiculo))[0];

echo "Bairro com mais Roubo de Veículo: {$bairroComMaisRoubo} ({$rouboVeiculo[$bairroComMaisRoubo]})<br>";
echo "Bairro com mais Furto de Veículo: {$bairroComMaisFurto} ({$furtoVeiculo[$bairroComMaisFurto]})\n";

