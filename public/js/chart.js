$(document).ready(function () {
    setupDashboardChart('chart');
    setupLeftMenu();
    setSidebarHeight();
});
var options = {
    chart: {
        renderTo: 'category-chart',
        type: 'line',
        defaultSeriesType: 'column'
    },
    title: {
        text: 'Doanh Số Bán Hàng Theo Danh Mục',
    },
    xAxis: {
        categories: []
    },
    yAxis: {
        title: {
            text: 'Số Lượng Sản Phẩm (n)'
        },
    },
    series: []
};


$.get('public/csv/data.csv',function(data){
    // Split the lines
    var lines = data.split('\n');

    $.each(lines, function(lineNo, line){
        var items = line.split(';');

        //header line contains categories
        if (lineNo == 0)
        {
            $.each(items, function(itemNo, item){
                if (itemNo > 0) options.xAxis.categories.push(item);
            });
        }

        // the rest of the lines contain data with their name in the first
        //position
        else{
            var series ={
                    data: []
            };
            $.each(items, function(itemNo, item ){
                if (itemNo == 0){
                    series.name = item ;
                }
                else{
                    series.data.push(parseFloat(item));
                }
            });

            options.series.push(series);
        }
    });
    var chart = new Highcharts.Chart(options);
});