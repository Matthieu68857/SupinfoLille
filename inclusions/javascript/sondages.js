//  *************** Animation pour les sondages ***************
	
function printChart(container, text, name, haut, droite, bas, gauche, left, bottom, right, top, data, legend, exporting, dataLabels){

	var chart;
	chart = new Highcharts.Chart({
		chart: {
			renderTo: container,
			defaultSeriesType: 'pie',
			margin: [haut, droite, bas, gauche]
		},
		title: {
			text: text
		},
		plotArea: {
			shadow: null,
			borderWidth: null,
			backgroundColor: null
		},
		tooltip: {
			formatter: function() {
				return '<b>'+ this.point.name +'</b>: '+ this.y +' %';
			}
		},
		plotOptions: {
			pie: {
				allowPointSelect: true,
				cursor: 'pointer',
				dataLabels: {
					enabled: dataLabels,
					formatter: function() {
						if (this.y > 5) return this.point.name;
					},
					color: 'white',
					style: {
						font: '13px Trebuchet MS, Verdana, sans-serif'
					}
				}
			}
		},
		legend: {
			enabled: legend,
			layout: 'vertical',
			style: {
				left: left, 
				bottom: bottom, 
				right: right, 
				top: top,
			}
		},
		exporting: {
			enabled: exporting,
		},
		series: [{
			name: name,
			data: data
		}]
	});
	
}