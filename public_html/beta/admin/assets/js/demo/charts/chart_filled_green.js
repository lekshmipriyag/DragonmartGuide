/*
 * charts/chart_filled_green.js
 *
 * Demo JavaScript used on charts-page for "Filled Chart (Green)".
 */

"use strict";

$(document).ready(function(){

	// Sample Data
	//var d1 = [greenDta];

	//var d1 = [[1262304000000, 17], [1264982400000, 600], [1267401600000, 1200], [1270080000000, 1000], [1272672000000, 2000], [1275350400000, 2300], [1277942400000, 2700], [1435689000000, 2000], [1438367400000, 1300], [1441045800000, 1000], [1443637800000, 2300], [1447426342938, 2000]];

	var data1 = [
		{ label: "Last 1 Year", data: d1, color: App.getLayoutColorCode('green') }
	];
	var now = new Date();
	var lastDay = new Date(now.getFullYear(), now.getMonth() + 1, 0);
	var tst = lastDay.getDate();
	
	var now2 = new Date(now.getFullYear(),now.getMonth() - 10, 0);
	var lastYear = now2.getFullYear();
	
	//var now3 = new Date("2015/06/01 00:00");
	//var millis = now3.getTime();
	//alert(millis);
	$.plot("#chart_filled_green", data1, $.extend(true, {}, Plugins.getFlotDefaults(), {
		xaxis: {
			min: (new Date(lastYear, now.getMonth()+1, 1)).getTime(),
			max: (new Date(now.getFullYear(), now.getMonth(), tst)).getTime(),
			//min: (new Date(2014, 11, 1)).getTime(),
			//max: (new Date(2015, 12, 2)).getTime(),
			mode: "time",
			tickSize: [1, "month"],
			monthNames: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
			tickLength: 0
		},
		series: {
			lines: {
				fill: true,
				lineWidth: 1.5
			},
			points: {
				show: true,
				radius: 2.5,
				lineWidth: 1.1
			}
		},
		grid: {
			hoverable: true,
			clickable: true
		},
		tooltip: true,
		tooltipOpts: {
			content: 'Upto %x: %y'
		}
	}));


});