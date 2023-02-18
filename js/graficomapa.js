function carregarestado(){
  atualiza('jan')
    var xhttp = new XMLHttpRequest();
 xhttp.onreadystatechange = function() {
   // if (this.readyState == 4 && this.status == 200) {
   //   document.getElementById("demo").innerHTML = '';
   // }
 };
 xhttp.open("GET", "estatistica/estado.php", true);
 xhttp.send();
   }
 




let dados=[];
let messelecionado;
var myChart1 = echarts.init(document.getElementById('cpc'));
myChart1.showLoading();

$.get('estatistica/maps/mapsp.json', function (geoJson) {

 myChart1.hideLoading();
 echarts.registerMap('state', geoJson);
 $.ajax({
   type: "GET",
   contentType: 'application/json; charset=utf-8',
   dataType: 'json',
   url: 'estatistica/capital.json',
   error: function () {
     alert("An error occurred.");
   },
   success: function (data) {
     dados=data;
   }
 });
});

   function atualiza(s) {
       var selectedMonth = s;
       var selectedData = dados[selectedMonth];
       messelecionado=selectedData
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
                     res += myseries[i].data[j].tipo + ': <b style=" text-align:right">'
                         + myseries[i].data[j].value + '<br></b>';
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
             max: 999,
             realtime: false,
             calculable: true,
             color: ['red', '#FFE066', 'white']
           },
           roam: true,
           series: [{
             name: 'Por Bairros',
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
             data: selectedData,
           }]
         });
   
         var barData = [];
         for (var i = 0; i < selectedData.length; i++) {
           barData.push({
           name: selectedData[i].name,
           value: selectedData[i].value,
           tipo: selectedData[i].tipo
           });
         }
         var tiposDeCrimes = [];
           for (var i = 0; i < barData.length; i++) {
           if (tiposDeCrimes.indexOf(barData[i].tipo) === -1) {
           tiposDeCrimes.push(barData[i].tipo);
           }
         }
         var series = [];
         for (var i = 0; i < tiposDeCrimes.length; i++) {
           var data = [];
           for (var j = 0; j < barData.length; j++) {
           if (barData[j].tipo === tiposDeCrimes[i]) {
               data.push({
               name: barData[j].name,
               value: barData[j].value,
               tipo: barData[j].tipo
               });
             }
           }
         series.push({
           name: tiposDeCrimes[i],
           type: 'bar',
           data: data
         });
    
   }
       myChart1.on('click', function (params) {
         var bairroSelecionado = params.name;
         document.getElementById('bar-cpc').style.visibility = 'visible';
         var objetosSelecionados = [];
         for (var i = 0; i < selectedData.length; i++) {
           if (selectedData[i].name === bairroSelecionado) {
             objetosSelecionados.push(selectedData[i]);
           }
         }
         var updatedSeries = [];
         for (var i = 0; i < barChart.getOption().series.length; i++) {
           var serie = barChart.getOption().series[i];
           for (var j = 0; j < objetosSelecionados.length; j++) {
               if (serie.name === objetosSelecionados[j].tipo) {
                   serie.data = [{value: objetosSelecionados[j].value, name: objetosSelecionados[j].tipo}];
                   break;
               }
           }
           updatedSeries.push(serie);
         }
         barChart.setOption({
           xAxis: {
             data: [bairroSelecionado]
           },
           series: updatedSeries
         });
         
         });
      
         myChart1.on('touchstart', function (params) {
           var bairroSelecionado = params.name;//santo amaro
           document.getElementById('bar-cpc').style.visibility = 'visible';
           var objetoSelecionado;
           for (var i = 0; i < selectedData.length; i++) {
             if (selectedData.selectedData[i].name === bairroSelecionado) {
                 objetoSelecionado = selectedData.selectedData[i];
                 break;
             }
           }
         });
         var barChart = echarts.init(document.getElementById('bar-cpc'));

         barChart.setOption({
           title: {
           text: ''
           },
           legend: {
           data: tiposDeCrimes
           },
           xAxis: {
           type: 'category',
           data: barData.map(function(item) {
           return item.tipo ;
           })
           },
           tooltip: {
               trigger: 'item',
               formatter: '{b}: {c}'
           },
           yAxis: {
           type: 'value'
           },
           series: series
         });
         var lineChart = echarts.init(document.getElementById('linha-cpc'));
         var lineData = [];

         myChart1.on('click', function (params) {
           var bairroSelecionado = params.name;
           document.getElementById('linha-cpc').style.visibility = 'visible';

           var mes = ["jan", "fev", "mar", "abr", "mai", "jun", "jul", "ago", "set", "out", "nov", "dez"];
           var lineData = [];
           var tiposDeCrimes = [];

           for (var i = 0; i < dados.jan.length; i++) {
             if (tiposDeCrimes.indexOf(dados.jan[i].tipo) === -1) {
               tiposDeCrimes.push(dados.jan[i].tipo);
             }
           }

           for (var i = 0; i < tiposDeCrimes.length; i++) {
             var data = [];
             for (var j = 0; j < mes.length; j++) {
               var mesAtual = mes[j];
               data.push({
                 name: mesAtual,
                 value: dados[mesAtual].find(function(dado) {
                   return dado.name === bairroSelecionado && dado.tipo === tiposDeCrimes[i]; }).value
               });
             }
             lineData.push({
               name: tiposDeCrimes[i],
               type: 'line',
               data: data
             });
           }

           var lineOption = {
             xAxis: {
               type: 'category',
               data: mes
             },
             tooltip: {
             trigger: 'item',
             formatter: '{b}: {c}'
             },
             yAxis: {
               type: 'value'
             },
             series: lineData,
             legend: {
               data: tiposDeCrimes
             }
           };
           lineChart.setOption(lineOption);
         });

}
var slider = document.getElementById("slider");
noUiSlider.create(slider, {
 start: 0,
 step: 1,
 range: {
   "min": 0,
   "max": 11
 },
 pips: {
   mode: 'steps',
   values: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
   density: 4,
   format: {
     to: function(value) {
       return ["jan", "fev", "mar", "abr", "mai", "jun", "jul", "ago", "set", "out", "nov", "dez"][value];
     }
   }
 }
});
slider.noUiSlider.on("update", function(values, handle) {
 var selectedMonth = ["jan", "fev", "mar", "abr", "mai", "jun", "jul", "ago", "set", "out", "nov", "dez"][Math.round(values[handle])];
 atualiza(selectedMonth);
});

