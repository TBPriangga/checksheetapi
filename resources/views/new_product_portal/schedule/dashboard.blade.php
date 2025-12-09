@extends('layouts.app-master')
 
@section('title', 'AJI MIS | DELIVERY')
 
 
@section('content')
<head>
  <style>
      /* #container {
          max-width: 1000px;
          margin: 1em auto;
          font-size: 8px;
      } */

      .highcharts-label-icon {
          opacity: 0.5;
      }

  </style>
</head>
<div id="container"></div>
@endsection

@push('scripts')
<script src="https://code.highcharts.com/gantt/highcharts-gantt.js"></script>
<script src="https://code.highcharts.com/gantt/modules/exporting.js"></script>
<script src="https://code.highcharts.com/gantt/modules/pattern-fill.js"></script>
<script src="https://code.highcharts.com/gantt/modules/accessibility.js"></script>
<script>
    $(document).ready(function(){
      $(".ibox-content").css({fontSize:5, textTransform:'Uppercase'});
    });

    var data= {!! $data !!}; 
    
    const outputArray = [];
    const eventArray = [];
    const milestoneArray = [];
    const ProductArray = [];
    const projectArray = [];

    const day = 24 * 36e5,
    today = Math.floor(Date.now() / day) * day;
   
    // Loop through the data and populate each object
    data.forEach((item, index) => {
        // convert date php ke time js
        start = Math.floor(new Date(item.plan_start) / day) * day;
        end = Math.floor(new Date(item.plan_end) / day) * day;
        start_actual = Math.ceil(new Date(item.actual_start) / day) * day;
        end_actual = Math.floor(new Date(item.actual_end) / day) * day;
        // Check if item.actual_end is null
            if (item.actual_end === null) {
                // Set item.actual_end to the current date and time
                end_actual = today;
            }
        
        // masukin event tanpa duplicate
        if (!eventArray.includes((item.event+"|"+item.milestone+"|"+item.product+"|"+item.project_title))) {
            eventArray.push((item.event+"|"+item.milestone+"|"+item.product+"|"+item.project_title));
        }
        // masukin milestone tanpa duplicate
        if (!milestoneArray.includes((item.milestone+"|"+item.product+"|"+item.project_title))) { 
            milestoneArray.push((item.milestone+"|"+item.product+"|"+item.project_title));
        }
        // masukin product array tanpa duplicate
        if (!ProductArray.includes((item.product+"|"+item.project_title))) { 
            ProductArray.push((item.product+"|"+item.project_title));
        }
        // masukin project title tanpa duplicate
        if (!projectArray.includes((item.project_title))) { 
            projectArray.push((item.project_title));
        }

      const detail_description = {
        name: item.detail_description,
        id: (item.project_title+item.product+item.milestone+item.event+item.detail_description).toLowerCase().replace(/ /g, '_'),
        // color: (Date.now() < end) ? '#66b2b2' : ((item.judge == 1) ? 'green' : ((item.judge == 0 && Date.now() > end) ? 'red' : 'red' ) ),
        color: ((item.judge == 1) ? '#3fb55f':  (Date.now() > end) ? '#f53141'  : ((item.judge == 0) ? '#f53141' : '#66b2b2' ) ),
        parent: (item.event+"|"+item.milestone+"|"+item.product+"|"+item.project_title).toLowerCase().replace(/ /g, '_'),
        start:start,
        // dependency: (index > 0) ?(  data[index - 1].project_title+data[index - 1].event+data[index - 1].detail_description).toLowerCase().replace(/ /g, '_') : null,
        end:end,
        completed: {
          amount: (item.progress  ?? 0),
        },
        dataLabels: {
            enabled: true,
            format: '{point.name}: {point.completed.amount}%',
            align: 'left',
        
        },
        owner:item.pic,
      };

      outputArray.push(detail_description);


      if ( item.actual_start != null) {
        const detail_description_actual = {
                name: "Actual",
                id: (item.project_title+item.product+item.milestone+item.event+item.detail_description).toLowerCase().replace(/ /g, '_')+"_actual",
                // color: "#a6ada8",
                color: (Date.now() > end) ? 'red' : '#30cf5a',
                parent: (item.event+"|"+item.milestone+"|"+item.product+"|"+item.project_title).toLowerCase().replace(/ /g, '_'),
                start:start_actual,
                // dependency: (index > 0) ?(  data[index - 1].project_title+data[index - 1].event+data[index - 1].detail_description).toLowerCase().replace(/ /g, '_') : null,
                end:end_actual,
                completed: {
                amount: (item.progress  ?? 0),
                },
                // dataLabels: {
                //     enabled: true,
                //     format: '{point.name}: {point.completed.amount}%',
                //     align: 'left',
                
                // },
                owner:item.pic,
            };
      outputArray.push(detail_description_actual);
      }

  
    });

    

    eventArray.forEach(item => {
        const event = {
            name: item.split("|")[0],
            id: (item).toLowerCase().replace(/ /g, '_'),
            color:'#008080',
            parent:(item.split("|")[1]+"|"+item.split("|")[2]+"|"+item.split("|")[3]).toLowerCase().replace(/ /g, '_'),
        };
        
        outputArray.push(event);
    });
    milestoneArray.forEach(item => {
        const milestone = {
            name: (item.split("|")[0]),
            id: item.toLowerCase().replace(/ /g, '_'),
            parent:item.split("|")[1].toLowerCase().replace(/ /g, '_')+"|"+item.split("|")[2].toLowerCase().replace(/ /g, '_'),
            color:"#006666",
        };
        
        outputArray.push(milestone);
    });
    ProductArray.forEach(item => {
        const product = {
            name: item.split("|")[0],
            id: item.toLowerCase().replace(/ /g, '_'),
            parent:item.split("|")[1].toLowerCase().replace(/ /g, '_'),
            color:"#004c4c",
        };
        
        outputArray.push(product);
    });
    projectArray.forEach(item => {
        const project = {
            name: item,
            id: item.toLowerCase().replace(/ /g, '_'),
            color:"#004c4c",
            collapsed: true // <-
        };
        
        outputArray.push(project);
    });
    console.log(outputArray);

</script>


<script>
  
 const options = {
 scrollbar: {
    enabled: true
  },
  navigator: {
    enabled: true
  },
  chart: {
      plotBackgroundColor: 'rgba(128,128,128,0.02)',
      plotBorderColor: 'rgba(128,128,128,0.1)',
      plotBorderWidth: 1,
  },
  credits: {
    enabled: false
  },

  plotOptions: {
      series: {
          borderRadius: '50%',
          connectors: {
              dashStyle: 'ShortDot',
              lineWidth: 2,
              radius: 5,
              startMarker: {
                  enabled: false
              }
          },
          groupPadding: 0,
          dataLabels: [{
              enabled: true,
              align: 'left',
              format: '{point.name}',
              padding: 5,
              style: {
                  fontWeight: 'lightest',
                  fontSize: '8px',
                  textOutline: 'none'
              }
          }],
          label:{
            style: {
                fontSize: '8px'
            }
          }
      }
  },

  series: [{
      name: 'Projects',
      data:outputArray
      
  }],
  tooltip: {
      pointFormat: '<span style="font-weight: bold">{point.name}</span><br>' +
          '{point.start:%e %b}' +
          '{#unless point.milestone} → {point.end:%e %b}{/unless}' +
          '<br>' +
          '{#if point.completed}' +
          'Completed: {point.completed.amount}%<br>' +
          '{/if}' +
          'Owner: {#if point.owner}{point.owner}{else}unassigned{/if}'
  },
  title: {
      text: 'New Model Management'
  },
  xAxis: [{
      currentDateIndicator: {
          color: '#2caffe',
          dashStyle: 'ShortDot',
          width: 2,
          label: {
              format: ''
          }
      },
      dateTimeLabelFormats: {
          day: '%e<br><span style="opacity: 0.5; font-size: 0.7em">%a</span>'
      },
      grid: {
          borderWidth: 0
      },
      gridLineWidth: 1,
      min: Date.UTC(new Date().getFullYear(), 0, 1), 
      max: Date.UTC(new Date().getFullYear(), 11, 31),
      custom: {
          today,
          weekendPlotBands: true
      }
  }],
  yAxis: {
      grid: {
          borderWidth: 0
      },
      gridLineWidth: 0,
      labels: {
          symbol: {
              width: 8,
              height: 6,
              x: -4,
              y: -2
          }
      },
      staticScale: 30
  },
  accessibility: {
      keyboardNavigation: {
          seriesNavigation: {
              mode: 'serialize'
          }
      },
      point: {
          descriptionFormatter: function (point) {
              var completedValue = point.completed ?
                      point.completed.amount || point.completed : null,
                  completed = completedValue ?
                      ' Task ' + Math.round(completedValue * 1000) / 10 + '% completed.' :
                      '',
                  dependency = point.dependency &&
                      point.series.chart.get(point.dependency).name,
                  dependsOn = dependency ? ' Depends on ' + dependency + '.' : '';

              return Highcharts.format(
                  point.milestone ?
                      '{point.yCategory}. Milestone at {point.x:%Y-%m-%d}. Owner: {point.owner}.{dependsOn}' :
                      '{point.yCategory}.{completed} Start {point.x:%Y-%m-%d}, end {point.x2:%Y-%m-%d}. Owner: {point.owner}.{dependsOn}',
                  { point, completed, dependsOn }
              );
          }
      }
  },
  lang: {
      accessibility: {
          axis: {
              xAxisDescriptionPlural: 'The chart has a two-part X axis showing time in both week numbers and days.'
          }
      }
  }
};

// Plug-in to render plot bands for the weekends
// Highcharts.addEvent(Highcharts.Axis, 'foundExtremes', e => {
//     if (e.target.options.custom && e.target.options.custom.weekendPlotBands) {
//         const axis = e.target,
//             chart = axis.chart,
//             day = 24 * 36e5,
//             isWeekend = t => /[06]/.test(chart.time.dateFormat('%w', t)),
//             plotBands = [];

//         let inWeekend = false;

//         for (
//             let x = Math.floor(axis.min / day) * day;
//             x <= Math.ceil(axis.max / day) * day;
//             x += day
//         ) {
//             const last = plotBands.at(-1);
//             if (isWeekend(x) && !inWeekend) {
//                 plotBands.push({
//                     from: x,
//                     color: {
//                         pattern: {
//                             path: 'M 0 10 L 10 0 M -1 1 L 1 -1 M 9 11 L 11 9',
//                             width: 10,
//                             height: 10,
//                             color: 'rgba(128,128,128,0.15)'
//                         }
//                     }
//                 });
//                 inWeekend = true;
//             }

//             if (!isWeekend(x) && inWeekend && last) {
//                 last.to = x;
//                 inWeekend = false;  
//             }
//         }
//         axis.options.plotBands = plotBands;
//     }
// });

Highcharts.ganttChart('container', options);


function calculateDateRange() {
  var today = new Date(); // Current date
  var year = today.getFullYear(); // Current year

  // Minimum date (first day of the year)
  var minDate = new Date(year, 0, 1);

  // Maximum date (last day of the year)
  var maxDate = new Date(year, 11, 31);

  return {
    min: minDate.toLocaleDateString("en-US"),
    max: maxDate.toLocaleDateString("en-US")
  };
}
</script>


@endpush

@push('styles')
<style>
   html {
            font-size:5px; /* Set the desired font size */
        }
</style>
    
@endpush