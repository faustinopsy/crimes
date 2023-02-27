
carrega();
function carrega(){
    $.ajax({
        type: "GET",
        contentType: 'application/json; charset=utf-8',
        dataType: 'json',
        url: 'estatistica/pontosdecrime.json',
        error: function () {
          alert("An error occurred.");
        },
        success: function (data) {
            var max = Math.max.apply(null, data.map(function(item) { return item.value; }));

          var pontosdecrime = echarts.init(document.getElementById('pontosdecrime'));

          option = {  
              legend: {
                orient: 'vertical',
                left: 'left',
                data: ['Furto de veículo', 'Roubo de veículo']
            },
              title: {
                  text: 'Pontos de crime',
                  subtext: 'DADOS FICTICIOS',
                  left: 'center',
                  top: 'top',
                  textStyle: {
                      color: '#0000'
                  }
              },
              tooltip: {
                  trigger: 'item',
                  formatter: function (params) {
                      return params.data.bairro + '<br>' + params.name + '  ' ;
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
              max: max,
              realtime: false,
              calculable: true,
              textStyle: {
                  color: '#fff'
              },
              seriesIndex: [0],
              inRange: {
                  color: ['green', '#FFE066', 'red']
              }
              },
             roam: true,
              geo: {
                  name: 'Pontos de crime',
                  type: 'map',
                  map: 'splocal',
                  roam: true,
                  label: {
                      emphasis: {
                          show: true
                      }
                  },  
              },
              series: [{
                  type: 'scatter',
                  coordinateSystem: 'geo',
                  data: data.map(function (itemOpt) {
                  return {
                  name: [itemOpt.tipo, itemOpt.value],
                  bairro: itemOpt.bairro,
                  value: [
                      itemOpt.longitude,
                      itemOpt.latitude,
                      itemOpt.value
                  ],
                  label: {
                      emphasis: {
                      position: 'right',
                      show: true
                      }
                  },
                  itemStyle: {
                          normal: {
                              areaColor: '#323c48',
                              borderColor: '#404a59'
                          },
                          emphasis: {
                              areaColor: 'red'
                          }
                      }
                  };
                  }),
                      legendHoverLink: true,
                      selectedMode: 'single',
                      geoIndex: 0
                  }]
          };
          pontosdecrime.setOption(option);
        }
      });
}


 
