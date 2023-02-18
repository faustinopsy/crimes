
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
         

          var color = ['#EAC435', '#03CEA4', '#FB4D3D'];
          var pontosdecrime = echarts.init(document.getElementById('pontosdecrime'));
    
    
          var max = -Infinity;
          var min = Infinity;
          
          option = {  
              legend: {
                      orient: 'vertical',
                      top: 'top',
                      left: 'left',
                      data:['Furto de veículo','Roubo de veículo'],
                      textStyle: {
                          color: 'blue'
                      },
                      selectedMode: 'single'
                  },
              title: {
                  text: 'Pontos de crime',
                  subtext: '',
                  left: 'center',
                  top: 'top',
                  textStyle: {
                      color: '#fff'
                  }
              },
              tooltip: {
                  trigger: 'item',
                  formatter: function (params) {
                      return params.seriesName + ':<br />' + params.name + '  ' ;
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
              textStyle: {
                  color: '#fff'
              },
              seriesIndex: [0],
              inRange: {
                  color: ['yellow', '#FFE066', 'red']
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


 
