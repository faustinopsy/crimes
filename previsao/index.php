<?php
require_once __DIR__ . '/vendor/autoload.php';

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

$bairros = [];

foreach ($dados as $mes => $bairrosMes) {
  foreach ($bairrosMes as $bairro) {
    if (!isset($bairros[$bairro["name"]])) {
      $bairros[$bairro["name"]] = [
        "rouboVeiculo" => 0,
        "furtoVeiculo" => 0
      ];
    }

    if ($bairro["tipo"] === "Roubo de veiculo") {
      $bairros[$bairro["name"]]["rouboVeiculo"] += intval(filter_var($bairro["value"], FILTER_SANITIZE_NUMBER_INT));
    } elseif ($bairro["tipo"] === "Furto de veiculo") {
      $bairros[$bairro["name"]]["furtoVeiculo"] += intval(filter_var($bairro["value"], FILTER_SANITIZE_NUMBER_INT));
    }
  }
}

$rouboVeiculoMax = max(array_column($bairros, "rouboVeiculo"));
$furtoVeiculoMax = max(array_column($bairros, "furtoVeiculo"));

$bairroComMaisRouboVeiculo = array_search($rouboVeiculoMax, array_column($bairros, "rouboVeiculo"));
$bairroComMaisFurtoVeiculo = array_search($furtoVeiculoMax, array_column($bairros, "furtoVeiculo"));
$nomeBairroComMaisRouboVeiculo = array_keys($bairros)[$bairroComMaisRouboVeiculo];
$nomeBairroComMaisFurtoVeiculo = array_keys($bairros)[$bairroComMaisFurtoVeiculo];

echo "Bairro com mais Roubo de Veículo: {$nomeBairroComMaisRouboVeiculo} ({$rouboVeiculoMax})\n";
echo "Bairro com mais Furto de Veículo: {$nomeBairroComMaisFurtoVeiculo} ({$furtoVeiculoMax})\n";
