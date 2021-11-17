/*
 * charts/chart_simple.js
 *
 * Demo JavaScript used on charts-page for "Simple Chart".
 */

"use strict";

$(document).ready(function(){

	// Sample Data
	var sin = [], cos = [];

for (var k in sins){
    if (sins.hasOwnProperty(k)) {
		 sin.push([k, sins[k]]);
    }
}


for (var c in coss){
    if (coss.hasOwnProperty(c)) {
		 cos.push([c, coss[c]]);
    }
}

		//sin.push(sins);
		//cos.push(coss);
		
	// Initialize flot
	var plot = $.plot("#chart_simple",
		[{
			data: sin,
			label: "Response "
		},{
			data: cos,
			label: "Question "
		}],

		$.extend(true, {}, Plugins.getFlotDefaults(), {
			series: {
				lines: { show: true},
				points: { show: true},
				grow: { active: true }
			},
			grid: {
				hoverable: true,
				clickable: true
			},
			yaxis: {
				min: 1,
				max: vBig
			},
			xaxis: {
				min: 0,
				max: 31
			},
			tooltip: true,
			tooltipOpts: {
				content: '%s: %y'
			}
		})
	);

});