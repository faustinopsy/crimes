<?php

setlocale(LC_ALL, 'pt_BR.utf8');

?>


    <script src="estatistica/js/jquery-2.1.4.min.js"></script>
    <script src="estatistica/js/chartli.js"></script>
    <style>
        body {
   	margin:0 0 5px 0;
	padding:0;
	
	font:italic 14px/1.5em  Verdana, Arial, Serif;
}

#conteudoEsq {
    position: absolute;
    width: 490px;
    top: 60px;
    left: 5px;
    color: #99f;
    padding-bottom: 20px;
    border-bottom: 3px double #666;
}
element.style {
    position: absolute;
    left: 0px;
    top: 24px;
    width: 475px;
    height: 400px;
    user-select: none;
    -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
    padding: 0px;
    margin: 0px;
    border-width: 0px;
}
#sepEsqcolCentral {
    margin-left: 500px;
    padding-bottom: 80px;
    border-bottom: 3px double #666;
}
#colCentral {    
	color:#991;
	padding:2px 10px;
	padding-bottom:20px;
	border-bottom:3px double #666;
}
    </style>
</head>
 <script type="text/javascript">
    function carregarestado(){
     var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("demo").innerHTML = '';
    }
  };
  //xhttp.open("GET", "estatistica/estado.php", true);
  //xhttp.send();
    }
</script>
<body onload="carregarestado()">
  


<div id="conteudoEsq"> 
<div id="cpc" style="max-width: 600px;height:400px;"></div>
       </div>
     
     <div id="sepEsqcolCentral">
   
     <div id="bar-cpc" style="max-width: 600px;height:400px;"></div>
     </div>  
   </div>  
  </div>
  <div id="conteudoEsq2"> 
<div id="cpm" style="max-width: 600px;height:400px;"></div>
       </div>
     
     <div id="sepEsqcolCentral2">
   
     <div id="bar-cpm" style="max-width: 600px;height:400px;"></div>
     </div>  
   </div>  
  </div>

    <script>
var myChart1 = echarts.init(document.getElementById('cpc'));
myChart1.showLoading();

$.get('estatistica/maps/sp.json', function (geoJson) {

  myChart1.hideLoading();
  echarts.registerMap('state', geoJson);
  $.ajax({
    type: "GET",
    contentType: 'application/json; charset=utf-8',
    dataType: 'json',
    url: 'estatistica/cpc.json',
    error: function () {
      alert("An error occurred.");
    },
    success: function (data) {
      myChart1.setOption(option1 = {
        title: {
          text: 'Bairro',
          subtext: '',
        },
        tooltip: {
          trigger: 'item',
          formatter: function (params) {
            var res = '<b >' + params.name + '</b><hr />';
            var myseries = option1.series;
            for (var i = 0; i < myseries.length; i++) {
              for (var j = 0; j < myseries[i].data.length; j++) {
                if (myseries[i].data[j].name === params.name) {
                  res += myseries[i].data[j].value + '<br> Roubo de veículos <br><b style=" text-align:right">e ' + myseries[i].data[j].furto + '<br> Furto de veículos </b>';
                }
              }
            }
            return res;
          }
        },
        toolbox: {
          show: true,
          orient: 'horizontal',
          right: 'left',
          top: 'top',
          feature: {
            dataView: {
              show: false
            },
            restore: {
              title: 'Yenile'
            },
            saveAsImage: {
              title: 'İndir'
            }
          }
        },
        visualMap: {
          min: 10,
          max: 5000,
          realtime: false,
          calculable: true,
          color: ['red', '#FFE066', 'white']
        },
        series: [{
          name: 'Por Estados',
          type: 'map',
          mapType: 'state',
          itemStyle: {
            normal: {
              label: {
                show: false
              }
            },
            emphasis: {
              label: {
                show: true
              }
            }
          },
          data: data.regiao,
        }]
      });
      var barData = [];
for (var i = 0; i < data.regiao.length; i++) {
barData.push({
name: data.regiao[i].name,
value: data.regiao[i].value,
furto: data.regiao[i].furto
});
}

var barChart = echarts.init(document.getElementById('bar-cpc'));

barChart.setOption({
  title: {
    text: 'Nome dos Bairros e Valores dos Indicadores'
  },
  xAxis: {
    type: 'category',
    data: barData.map(function(item) {
      return item.name;
    })
  },
  yAxis: {
    type: 'value'
  },
  series: [{
    data: 0,
    type: 'bar',
    barWidth: '30%',
    itemStyle: {
      color: '#f44336'
    },
    label: {
      show: true,
      position: 'top',
      formatter: function(params) {
        return params.value + ' Roubo de veículos';
      }
    }
  }, {
    data: 0,
    type: 'bar',
    barWidth: '30%',
    itemStyle: {
      color: '#2196f3'
    },
    label: {
      show: true,
      position: 'top',
      formatter: function(params) {
        return params.value + ' Furto de veículos';
      }
    }
  }]
});

myChart1.on('mouseover', function (params) {
var bairroSelecionado = params.name;//santo amaro


//0: {name: 'Pq São Rafael', value: '163', furto: '905'}
var objetoSelecionado;
for (var i = 0; i < data.regiao.length; i++) {
   if (data.regiao[i].name === bairroSelecionado) {
      objetoSelecionado = data.regiao[i];
      break;
   }
}

barChart.setOption({
xAxis: {
data: [bairroSelecionado]//santo amaro
},
series: [{
   
data: [{value: objetoSelecionado.value, name: "Roubo de veículos"}]

},
{
   
   data: [{value: objetoSelecionado.furto, name: "Furto de veículos"}]
   
   }
]
});
});
myChart1.on('touchstart', function (params) {
  var bairroSelecionado = params.name;//santo amaro


//0: {name: 'Pq São Rafael', value: '163', furto: '905'}
var objetoSelecionado;
for (var i = 0; i < data.regiao.length; i++) {
   if (data.regiao[i].name === bairroSelecionado) {
      objetoSelecionado = data.regiao[i];
      break;
   }
}

barChart.setOption({
xAxis: {
data: [bairroSelecionado]//santo amaro
},
series: [{
   
data: [{value: objetoSelecionado.value, name: "Roubo de veículos"}]

},
{
   
   data: [{value: objetoSelecionado.furto, name: "Furto de veículos"}]
   
   }
]
});
});
    }
    
});

});

    </script>
     <script>
        var myChart2 = echarts.init(document.getElementById('cpm'));

myChart2.showLoading();

$.get('estatistica/maps/cpm.json', function (geoJson) {

  myChart2.hideLoading();
  echarts.registerMap('state', geoJson);
  $.ajax({
    type: "GET",
    contentType: 'application/json; charset=utf-8',
    dataType: 'json',
    url: 'estatistica/cpm.json',
    error: function () {
      alert("An error occurred.");
    },
    success: function (data) {
      myChart2.setOption(option1 = {
        title: {
          text: 'Bairro',
          subtext: '',
        },
        tooltip: {
          trigger: 'item',
          formatter: function (params) {
            var res = '<b >' + params.name + '</b><hr />';
            var myseries = option1.series;
            for (var i = 0; i < myseries.length; i++) {
              for (var j = 0; j < myseries[i].data.length; j++) {
                if (myseries[i].data[j].name === params.name) {
                  res += myseries[i].data[j].value + '<br> Roubo de veículos <br><b style=" text-align:right">e ' + myseries[i].data[j].furto + '<br> Furto de veículos </b>';
                }
              }
            }
            return res;
          }
        },
        toolbox: {
          show: true,
          orient: 'horizontal',
          right: 'left',
          top: 'top',
          feature: {
            dataView: {
              show: false
            },
            restore: {
              title: 'Yenile'
            },
            saveAsImage: {
              title: 'İndir'
            }
          }
        },
        visualMap: {
          min: 10,
          max: 5000,
          realtime: false,
          calculable: true,
          color: ['red', '#FFE066', 'white']
        },
        series: [{
          name: 'Por Estados',
          type: 'map',
          mapType: 'state',
          itemStyle: {
            normal: {
              label: {
                show: false
              }
            },
            emphasis: {
              label: {
                show: true
              }
            }
          },
          data: data.regiao,
        }]
      });
      var barData = [];
for (var i = 0; i < data.regiao.length; i++) {
barData.push({
name: data.regiao[i].name,
value: data.regiao[i].value,
furto: data.regiao[i].furto
});
}

var barChart2 = echarts.init(document.getElementById('bar-cpm'));

barChart2.setOption({
  title: {
    text: 'Nome dos Bairros e Valores dos Indicadores'
  },
  xAxis: {
    type: 'category',
    data: barData.map(function(item) {
      return item.name;
    })
  },
  yAxis: {
    type: 'value'
  },
  series: [{
    data: barData.map(function(item) {
      return  parseInt(item.value);
    }),
    type: 'bar',
    barWidth: '30%',
    itemStyle: {
      color: '#f44336'
    },
    label: {
      show: true,
      position: 'top',
      formatter: function(params) {
        return params.value + ' Roubo de veículos';
      }
    }
  }, {
    data: barData.map(function(item) {
      return  parseInt(item.furto);
    }),
    type: 'bar',
    barWidth: '30%',
    itemStyle: {
      color: '#2196f3'
    },
    label: {
      show: true,
      position: 'top',
      formatter: function(params) {
        return params.value + ' Furto de veículos';
      }
    }
  }]
});

myChart2.on('click', function (params) {
var bairroSelecionado = params.name;//santo amaro


//0: {name: 'Pq São Rafael', value: '163', furto: '905'}
var objetoSelecionado;
for (var i = 0; i < data.regiao.length; i++) {
   if (data.regiao[i].name === bairroSelecionado) {
      objetoSelecionado = data.regiao[i];
      break;
   }
}

barChart2.setOption({
xAxis: {
data: [bairroSelecionado]//santo amaro
},
series: [{
   
data: [{value: objetoSelecionado.value, name: "Roubo de veículos"}]

},
{
   
   data: [{value: objetoSelecionado.furto, name: "Furto de veículos"}]
   
   }
]
});
});
    }
    
});

});

    </script>

<br><br><br>

</html>
   

