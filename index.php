    <script src="js/jquery-2.1.4.min.js"></script>
    <script src="js/chartli.js"></script>
    <link rel="stylesheet" href="css/nouislider.min.css"/>
    <link rel="stylesheet" href="css/style.css"/>
</head>
    <style>

    </style>
</head>
<div id="splashScreen">
  <div id="loading">
    <p>Carregando...</p>
    <div id="loadingBar">
      <div id="loadingPercentage"></div>
    </div>
  </div>
</div>
<div id="conteudo">
  
<?php

$json = file_get_contents('estatistica/capital.json');
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
      $bairros[$bairro["name"]] = ["rouboVeiculo" => 0,"furtoVeiculo" => 0 ];
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


?>
<div id="slider"></div>
<br><br><br>
 
<body onload='carregarestado()'>
  
<div id="conteudoEsq"> 
      <div id="cpc" style="max-width: 600px;"></div>
    </div>
<div id="sepEsqcolCentral">
     <div id="bar-cpc" style="max-width: 600px; visibility: hidden;"></div>
</div>
    
     <div id="sepEsqcolCentral">
     <div id="linha-cpc" style="max-width: 600px; visibility: hidden;"></div>
     </div>  
     <div  id="conteudomapa">

        <div id="pontosdecrime" style="height:500px;"></div>
    </div>
     
  <script src="js/nouislider.min.js"></script>
  <script src="js/graficomapa.js"></script>
  <script src="estatistica/maps/mapaloc.js"></script>
  <script src="js/pontosdecrime.js"></script>
<br><br><br>
<script>
window.addEventListener("load", function () {
  const loadingPercentage = document.getElementById("loadingPercentage");
  const splashScreen = document.getElementById("splashScreen");
  const conteudo = document.getElementById("conteudo");
  
  let percentage = 0;
  const interval = setInterval(() => {
    percentage += 5;
    loadingPercentage.style.width = `${percentage}%`;
    
    if (percentage >= 100) {
      clearInterval(interval);
      splashScreen.style.display = "none";
      conteudo.style.display = "block";
    }
  }, 50);
});

  </script>
  </div>
</html>
   

