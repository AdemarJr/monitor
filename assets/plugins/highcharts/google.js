//   "colors": ["#FF8C77", "#FFA08F", "#FFBDB1", "#FFD0C7","#FFFFFF"], tons de rosa
//  "colors": ["#81ACBC", "#90B4BF", "#ABC1C5", "#D1D8D1","#ECE7D8" ], tons de azul
Highcharts.theme = {
  "colors": ["#FF5078", "#638757", "#00AB96", "#B975A7","#3670A4","#DE5B49","#E37B40","#F0CA4D","#324D5C" ],
  "chart": {
    "style": {
      "fontFamily": "Roboto",
      "color": "#444444"
    }
  },
  "xAxis": {
  //  "gridLineWidth": 1,
//    "gridLineColor": "#F3F3F3",
    "lineColor": "#F3F3F3",
    "minorGridLineColor": "#F3F3F3",
    "tickColor": "#F3F3F3",
    "tickWidth": 1
  },
  "yAxis": {
    "gridLineColor": "#F3F3F3",
    "lineColor": "#F3F3F3",
    "minorGridLineColor": "#F3F3F3",
    "tickColor": "#F3F3F3",
    "tickWidth": 1
  },
  "legendBackgroundColor": "rgba(0, 0, 0, 0.5)",
  "background2": "#505053",
  "dataLabelsColor": "#B0B0B3",
  "textColor": "#C0C0C0",
  "contrastTextColor": "#F0F0F3",
  "maskColor": "rgba(255,255,255,0.3)"
};
var highchartsOptions = Highcharts.setOptions(Highcharts.theme);
