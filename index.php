    
    <meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="js/jquery-2.1.4.min.js"></script>
    
    <script src="js/chartli.js"></script>
    <link rel="stylesheet" href="css/nouislider.min.css"/>
    <link rel="stylesheet" href="css/style.css"/>
    <link rel="stylesheet" href="css/w3.css"/>
    <link href="css/estilo.css" type="text/css" rel="stylesheet">
    <head>
  <script src="js/axios.min.js"></script>
  <link rel="stylesheet" href="css/leaflet.css" />
<script src="js/leaflet.js"></script>

</head>

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
<body>
<div id="conteudo">
      <div class="w3-row">
      <a >
            <div class="w3-quarter tablink w3-center w3-bottombar w3-hover-light-grey w3-padding"></div>
          </a>
          <a href="javascript:void(0)" onclick="openMenu(event, 'tematico');">
            <div class="w3-quarter tablink w3-center w3-bottombar w3-hover-light-grey w3-padding">Mapa Temático</div>
          </a>
          <a href="javascript:void(0)" onclick="openMenu(event, 'ponto');">
            <div class="w3-quarter tablink w3-center w3-bottombar w3-hover-light-grey active w3-border-red w3-padding">Mapas de Ponto</div>
          </a>
          <a href="javascript:void(0)" onclick="openMenu(event, 'cadastrar');">
            <div class="w3-quarter tablink w3-center w3-bottombar w3-hover-light-grey w3-padding">Cadastrar</div>
          </a>
          <a >
            <div class="w3-quarter tablink w3-center w3-bottombar w3-hover-light-grey w3-padding"></div>
          </a>
      </div>
        
         
  
            
          <div id="tematico" class="w3-container menu" style="display:none; height:600px;">
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
 

            <div id="conteudoEsq"> 
                  <div id="cpc" style="width: 280px;height:400px;"></div>
              </div>
            <div id="sepEsqcolCentral">
                <div id="bar-cpc" style="max-width: 600px; visibility: hidden;"></div>
            </div>
    
            <div id="sepEsqcolCentral">
                <div id="linha-cpc" style="max-width: 600px; visibility: hidden;"></div>
            </div>  
     
          </div>

    
          <div id="ponto" class="w3-container menu" style="display:hidden">
            
          <div id="centro">
              <div id="pontosdecrime" style="height:500px;"></div>
              </div>
          </div>
          
          <div id="cadastrar" class="w3-container menu" style="display:none">
          <div id="mapid" style="width: 100%; height: 400px;"></div>
          <div id="centroform">
            <form method="get" action=".">
            <input type="text"  name="utmx" id="utmx" size="30" maxlength="100" readonly>
              <input type="text"  name="utmy" id="utmy" size="30" maxlength="100" readonly>
              <br /><br />
              <label>Cep:</label>
              <input name="cep" type="text" id="cep" value=""  maxlength="9"
                    onblur="pesquisacep(this.value);" /><br />
              <br />
              <label>Rua:</label>
              <input name="endereco" type="text" id="endereco"  />
              <br /><br />
              <label>Bairro:</label>
              <input name="bairro" type="text" id="bairro"  /><br /><br />
              <label>Cidade:</label>
              <input name="cidade" type="text" id="cidade"  /><br /><br />
              <label>Estado:</label>
              <input name="uf" type="text" id="uf" size="2" /><br /><br />
              <label>Tipo de Crime:</label>
              <input name="tipo" id="roubo" type="radio" value="Roubo de Veículo"> Roubo de Veículo
              <input name="tipo" id="furto" type="radio" value="Furto de Veículo"> Furto de Veículo
            </label><br />
              <button class="w3-button w3-teal w3-round-large" type="button" onclick="cadcrime()">Cadastrar</button>
            </form>
          </div>
          </div>
</div>

<script src="js/nouislider.min.js"></script>
<script src="estatistica/maps/mapaloc.js"></script>
<script src="js/pontosdecrime.js"></script>
<script src="js/graficomapa.js"></script>
<script src="js/mensagem.js"></script>
<script src="js/cadastrar.js"></script>
<script src="js/cep.js"></script>

    <br><br><br>
<div id="overlay"></div>  
<div id="message" class="message-box">
  <div class="message-header">Ponto de Crime</div>
  <div class="message-body" id="message-text"></div>
  <button class="close-button" onclick="hideMessage()">Fechar</button>
</div>

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
      carregatematico();
    }
  }, 50);
});



function openMenu(evt, cityName) {
  var i, x, tablinks;
  x = document.getElementsByClassName("menu");
  for (i = 0; i < x.length; i++) {
    x[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablink");
  for (i = 0; i < x.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" w3-border-red", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.firstElementChild.className += " w3-border-red";
}
function myFunction(id) {
  var x = document.getElementById(id);
  if (x.className.indexOf("w3-show") == -1) {
    x.className += " w3-show";
  } else { 
    x.className = x.className.replace(" w3-show", "");
  }
}
var myVar;



    document.onmousedown=disableclick;
function disableclick(event)
{
  if(event.button==2)
   {
     return false;    
   }
}

//Make the DIV element draggagle:

</script>

</html>
   

