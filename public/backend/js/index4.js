$(function(e) {
	'use strict';
	
	
	/*--echart-1---*/
	var myChart2 = echarts.init(document.getElementById('echart-1'));
	var option2 = {
		title: {
			text: '',
			subtext: '',
			x: 'center'
		},
		tooltip: {
			trigger: 'item',
			formatter: "{a} {b} : {c} ({d}%)"
		},
		legend: {
			x: 'center',
			y: 'bottom',
			data: ['USA', 'India',  'Russia', 'Canada',  'Germany'],
			textStyle: {
				color: '#9493a9'
			}
		},
		toolbox: {
			show: true,
			feature: {
				mark: {
					show: true
				},
				dataView: {
					show: true,
					readOnly: false
				},
				magicType: {
					show: true,
					type: ['pie']
				},
				restore: {
					show: true
				},
				saveAsImage: {
					show: true
				}
			}
		},
		calculable: true,
		series: [{
			name: '',
			type: 'pie',
			radius: [20, 110],
			center: ['50%', '50%'],
			roseType: 'radius',
			label: {
				normal: {
					show: false
				},
				emphasis: {
					show: true
				}
			},
			lableLine: {
				normal: {
					show: false
				},
				emphasis: {
					show: true
				}
			},
			data: [{
				value: 56,
				name: 'USA'
			}, {
				value: 53,
				name: 'India'
			}, {
				value: 46,
				name: 'Russia'
			}, {
				value: 30,
				name: 'Canada'
			},{
				value: 15,
				name: 'Germany'
			}]
		}, ],
		color: ['#564ec1', '#04cad0', '#f5334f', '#f7b731 ', '#26c2f7']
	};
	myChart2.setOption(option2);
	window.addEventListener('resize',function(){
		myChart2.resize();
	})
	/*--echart-1---*/

});

// customer visitors
function totalVisitors() {
	var options = {
		chart: {
			height: 320,
			type: 'area',
			stacked: true,
			events: {
			  selection: function(chart, e) {
				console.log(new Date(e.xaxis.min) )
			  }
			},
			toolbar: {
				show: false
			}
		},
		colors: ["rgb(" + myVarVal + ")", '#04cad0'],
		dataLabels: {
		  enabled: false
		},
		stroke: {
			curve: 'smooth',
			width: [2, 2]
		},
		grid: {
			borderColor: 'rgba(119, 119, 142, 0.08)',
		},
		legend: {
			show: true,
			position: 'top',
			horizontalAlign: 'right',
			fontSize: '11px',
			fontWeight: 600, 
			labels: {
				colors: '#74767c',
			},
			markers: {
				width: 8,
				height: 8,
				strokeWidth: 0,
				radius: 12,
				offsetX: 0,
				offsetY: 0
			},
		},
		series: [{
				name: 'Total Customers',
				data: [34, 24, 44, 36, 56, 48, 67, 46, 78, 56, 45, 68]
			},{
				name: 'Total Visitors',
				data: [40, 31, 52, 43, 64, 55, 76, 57, 88, 69, 42, 75]
		}],
		fill: {
			gradient: {
			  enabled: true,
			  opacityFrom: 0.6,
			  opacityTo: 0.8,
			}
		},
		xaxis: {
			labels: {
				formatter: function(val) {
					return val + ""
				}
			},
			categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
			axisBorder: {
				show: true,
				color: 'rgba(119, 119, 142, 0.05)',
			  },
			  axisTicks: {
				show: true,
				color: 'rgba(119, 119, 142, 0.05)',
			  },
		},
	  yaxis: {
		title: {
		  text: undefined
		},
	  },
	}
	document.querySelector("#totalvisitors").innerHTML = "";
	var chart = new ApexCharts(document.querySelector("#totalvisitors"), options);
	chart.render();
	
}


/*-----total-orders-----*/
function totalOders() {
	var options = {
		series: [{
			name: 'Orders',
			type: 'column',
			data: [1.8, 2.0, 2.5, 3.2, 2.5, 4.5, 1.5, 2.5, 2.8, 3.8, 3.2, 4.6]
		}, {
			name: 'Sales',
			type: 'column',
			data: [1.1, 1.5, 2.2, 5.2, 3.1, 3.1, 4, 4.1, 4.9, 6.5, 4.5, 7.5]
		}
		],
		chart: {
			height: 300,
			type: 'bar',
			stacked: false,
			dropShadow: {
				enabled: true,
				enabledOnSeries: undefined,
				top: 5,
				left: 0,
				blur: 3,
				color: 'var(--primary-05)',
				opacity: 0.5
			},
		},
		grid: {
			borderColor: 'rgba(119, 119, 142, 0.08)',
		},
		dataLabels: {
			enabled: false
		},
		title: {
			text: undefined,
			align: 'left',
			offsetX: 110
		},
		xaxis: {
			categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
			axisBorder: {
				color: 'rgba(119, 119, 142, 0.05)',
				offsetX: 0,
				offsetY: 0,
			},
			axisTicks: {
				color: 'rgba(119, 119, 142, 0.05)',
				width: 6,
				offsetX: 0,
				offsetY: 0
			},
		},
		yaxis: {
			show: true,
			axisTicks: {
				show: true,
			},
			axisBorder: {
				show: false,
				color: '#4eb6d0'
			},
			labels: {
				style: {
					colors: '#4eb6d0',
				}
			},
			title: {
				text: undefined,
				style: {
					color: '#4eb6d0',
				}
			},
			tooltip: {
				enabled: true
			}
		},
		tooltip: {
			enabled: true,
		},
		colors: ["rgb(" + myVarVal + ")", '#04cad0'],
		legend: {
			position: 'bottom',
			offsetX: 40,
			fontSize: '10px',
			fontWeight: 600, 
			labels: {
				colors: '#74767c',
			},
			markers: {
				width: 9,
				height: 9,
				strokeWidth: 0,
				radius: 12,
				offsetX: 0,
				offsetY: 0
			},
		}, 
		stroke: {
			width: [0, 0, 1.5],
			curve: 'smooth',
			dashArray: [0, 0, 2],
		},
		plotOptions: {
			bar: {
				columnWidth: "35%",
				borderRadius: 3
			}
		},
	};
	document.querySelector("#total-orders").innerHTML = "";
	var chart = new ApexCharts(document.querySelector("#total-orders"), options);
	chart.render();
}