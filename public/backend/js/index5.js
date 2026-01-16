
"use strict";
	
/*-----echart1-----*/
var chartdata = [{
	name: 'Within Time Limit',
	type: 'bar',
	data: [10, 15, 9, 18, 10, 15]
},{
	name: 'Outof Time Limit',
	type: 'bar',
	data: [10, 14, 10, 15, 9, 25]
}];
var chart = document.getElementById('echart1');
var barChart = echarts.init(chart);
var option = {
	grid: {
		top: '6',
		right: '0',
		bottom: '17',
		left: '25',
	},
	xAxis: {
		data: ['2014', '2015', '2016', '2017', '2018'],
		axisLine: {
			lineStyle: {
				color: 'rgba(119, 119, 142, 0.08)'
			}
		},
		axisLabel: {
			fontSize: 10,
			color: '#9493a9'
		}
	},
	tooltip: {
		show: true,
		showContent: true,
		alwaysShowContent: true,
		triggerOn: 'mousemove',
		trigger: 'axis',
		backgroundColor: '#28273a',
		borderColor: '#28273a',
		trigger: 'axis',
		textStyle: {
			color: '#95a8ba'
		},
		axisPointer: {
			label: {
				show: false,
			}
		}
	},
	yAxis: {
		splitLine: {
			lineStyle: {
				color: 'rgba(119, 119, 142, 0.08)'
			}
		},
		axisLine: {
			lineStyle: {
				color: 'rgba(119, 119, 142, 0.08)'
			}
		},
		axisLabel: {
			fontSize: 10,
			color: '#9493a9'
		}
	},
	series: chartdata,
	color: ['#564ec1', '#ff9900']
};
barChart.setOption(option);
window.addEventListener('resize',function(){
	barChart.resize();
})


/* Chartjs (#inventory) */
var myCanvas = document.getElementById("inventory");
myCanvas.height="272";
var myCanvasContext = myCanvas.getContext("2d");
var gradientStroke1 = myCanvasContext.createLinearGradient(0, 0, 0, 380);
gradientStroke1.addColorStop(0, '#564ec1');
gradientStroke1.addColorStop(1, '#564ec1');

var myChart = new Chart(myCanvas, {
	type: 'bar',
	data: {
		labels: ["Risk", "Service", "Storage", "Admin", "Freight"],
		datasets: [{
			label: 'Carrying Costs Of Inventory',
			data: [16, 8, 4, 8, 16],
			backgroundColor: gradientStroke1,
			hoverBackgroundColor: gradientStroke1,
			hoverBorderWidth: 2,
			hoverBorderColor: 'gradientStroke1'
		}
		]
	},
	options: {
		responsive: true,
		barPercentage: 0.3,
		maintainAspectRatio: true,
		plugins: {
			legend: {
				display: false,
				labels: {
					display: false
				}
			},
			tooltip: {
				enabled: true
			}			
		},
		scales: {
			x: {
					barPercentage: 0.3,
				ticks: {
					color: "#9ba6b5",

				},
				display: true,
				grid: {
					display: true,
					color: 'rgba(119, 119, 142, 0.08)',
					drawBorder: false,
				},
				scaleLabel: {
					display: false,
					labelString: 'Month',
					fontColor: '#000'
				}
			},
			y: {
				ticks: {
					color: "#9ba6b5",
					},
				display: true,
				grid: {
					display: true,
					color: 'rgba(119, 119, 142, 0.08)',
					drawBorder: false,
				},
				scaleLabel: {
					display: false,
					labelString: 'sales',
					fontColor: 'transparent'
				}
			}
		},
		title: {
			display: false,
			text: 'Normal Legend'
		}
	}
});
/* Chartjs (#inventory) closed */

/* Apex chart */
var options = {
	series: [{
	  name: "Week",
	  data: [23, 11, 22, 35, 17, 28, 22, 37, 21, 44, 22, 30]
	},
	{
	  name: 'Month',
	  data: [30, 25, 46, 28, 21, 45, 35, 64, 52, 59, 36, 39]
	}
  ],
	chart: {
	height: 290,
	type: 'area',
	zoom: {
	  enabled: false
	},
	toolbar: {
		show: false,
	}
  },
  dataLabels: {
	enabled: false
  },
  stroke: {
	width: [2, 2],
	curve: 'smooth',
	dashArray: [0, 8]
  },
  legend: {
	tooltipHoverFormatter: function(val, opts) {
	  return val + ' - ' + opts.w.globals.series[opts.seriesIndex][opts.dataPointIndex] + ''
	}
  },
  markers: {
	size: 0,
	hover: {
	  sizeOffset: 6
	}
  },
  legend: {
	show: true,
		position: 'top',
		horizontalAlign: 'right',
		fontSize: '12px',
		fontWeight: 600, 
		labels: {
			colors: '#74767c',
		},
		markers: {
			width: 10,
			height: 10,
			strokeWidth: 0,
			radius: 12,
			offsetX: 0,
			offsetY: 0
		},
	},
  colors: ['#564ec1', '#5eba00'],
  xaxis: {
	categories: ['01 Jan', '02 Feb', '03 Mar', '04 Apr', '05 May', '06 Jun', '07 Jul', '08 Aug', '09 Sep',
	  '10 Oct', '11 Nov', '12 Dec'
	],
	axisBorder: {
		show: true,
		color: 'rgba(119, 119, 142, 0.05)',
	},
	axisTicks: {
		show: true,
		color: 'rgba(119, 119, 142, 0.05)',
	}
  },
  grid: {
	borderColor: 'rgba(119, 119, 142, 0.1)'
  }
};
var chart5 = new ApexCharts(document.querySelector("#perfectorder"), options);
chart5.render();

function orderRate() {
chart5.updateOptions({ colors: ["rgb(" + myVarVal + ")", "#04cad0"] });
}