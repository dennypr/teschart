<!-- Styles -->
<style>
#chartdiv {
  width: 100%;
  height: 500px;
}
</style>

<!-- Resources -->
<script src="amcharts4/core.js"></script>
<script src="amcharts4/charts.js"></script>
<script src="amcharts4/themes/animated.js"></script>

<!-- Chart code -->
<script>
am4core.ready(function() {

// Themes begin
am4core.useTheme(am4themes_animated);
// Themes end



var chart = am4core.create('chartdiv', am4charts.XYChart)
chart.colors.step = 2;

chart.legend = new am4charts.Legend()
chart.legend.position = 'top'
chart.legend.paddingBottom = 20
chart.legend.labels.template.maxWidth = 95

var xAxis = chart.xAxes.push(new am4charts.CategoryAxis())
xAxis.dataFields.category = 'category'
xAxis.renderer.cellStartLocation = 0.1
xAxis.renderer.cellEndLocation = 0.9
xAxis.renderer.grid.template.location = 0;

var yAxis = chart.yAxes.push(new am4charts.ValueAxis());
yAxis.min = 0;

function createSeries(value, name) {
    var series = chart.series.push(new am4charts.ColumnSeries())
    series.dataFields.valueY = value
    series.dataFields.categoryX = 'category'
    series.name = name

    series.events.on("hidden", arrangeColumns);
    series.events.on("shown", arrangeColumns);

    var bullet = series.bullets.push(new am4charts.LabelBullet())
    bullet.interactionsEnabled = false
    bullet.dy = 30;
    bullet.label.text = '{valueY}'
    bullet.label.fill = am4core.color('#ffffff')

    return series;
}

chart.data = [
    {
        category: '2020-11',
        first: 51,
        second: 5,
        third: 56
    },
	 {
        category: '2020-12',
        first: 51,
        second: 33,
        third: 84
    },
	{
        category: '2021-1',
        first: 51,
        second: 1,
        third: 52
    },
	{
        category: '2021-2',
        first: 51,
        second: 15,
        third: 66
    }
]


createSeries('first', 'Target');
createSeries('second', 'Delta');
createSeries('third', 'Achievment');

function arrangeColumns() {

    var series = chart.series.getIndex(0);

    var w = 1 - xAxis.renderer.cellStartLocation - (1 - xAxis.renderer.cellEndLocation);
    if (series.dataItems.length > 1) {
        var x0 = xAxis.getX(series.dataItems.getIndex(0), "categoryX");
        var x1 = xAxis.getX(series.dataItems.getIndex(1), "categoryX");
        var delta = ((x1 - x0) / chart.series.length) * w;
        if (am4core.isNumber(delta)) {
            var middle = chart.series.length / 2;

            var newIndex = 0;
            chart.series.each(function(series) {
                if (!series.isHidden && !series.isHiding) {
                    series.dummyData = newIndex;
                    newIndex++;
                }
                else {
                    series.dummyData = chart.series.indexOf(series);
                }
            })
            var visibleCount = newIndex;
            var newMiddle = visibleCount / 2;

            chart.series.each(function(series) {
                var trueIndex = chart.series.indexOf(series);
                var newIndex = series.dummyData;

                var dx = (newIndex - trueIndex + middle - newMiddle) * delta

                series.animate({ property: "dx", to: dx }, series.interpolationDuration, series.interpolationEasing);
                series.bulletsContainer.animate({ property: "dx", to: dx }, series.interpolationDuration, series.interpolationEasing);
            })
        }
    }
}

}); // end am4core.ready()
</script>


<label for="Category">Choose Category :</label>

<select name="Category" id="Category" >
  <option value="Transmission">Transmission Expenses</option>
  <option value="Power">Power Expenses</option>
  <option value="Radio">Radio Frequency Usage</option> 
</select>
<input type="button" name="button" id="button" value="choose"onclick="ob()"/>
<script>
function ob(){
var x = document.getElementById("Category").value;

if (x === "Transmission") {
	 window.location.href ="transmision_expres.php";
}
if (x === "Power") {
	  window.location.href ="power_expanse.php";
}
if (x === "Radio") {
	 window.location.href ="radio_frequency_usage.php";
}
}
</script>

<div align ="center" ><h1> Power Expenses</h1></div>
<!-- HTML -->
<div id="chartdiv"></div>