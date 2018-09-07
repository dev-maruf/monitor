@extends('layouts.app')

@section('title', 'Graph - ')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>GRAPH</h2>
            </div>

            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>Graph - {{\App\Device::where('key', $key)->first()['name']}}</h2>                            
                        </div>
                        <div class="body">
                            <div id="mychart" style="height: 400px; min-width: 310px"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection

@section('js')
<script src="https://code.highcharts.com/stock/highstock.js"></script>
<script src="https://code.highcharts.com/stock/modules/exporting.js"></script>
<script src="https://code.highcharts.com/stock/modules/export-data.js"></script>

<script>    
    var globaldata;
    var seriesOption = [{        
        tooltip: {
            valueDecimals: 2
        }
    }];
    var myChart;    

    $.getJSON('{{route('get.graph', ['key'=> $key])}}', function (data) {
        console.log("Update");
        console.log(data);
        var r_data = [], s_data = [], t_data = [];
        $.each(data, function(i, val){                                
            // var dt = val.split(',');
            // var x = eval(dt[0]),
            //     r = eval(dt[1]),
            //     s = eval(dt[2]),
            //     y = eval(dt[3]);
            r_data.push([val[0], val[1]]);
            s_data.push([val[0], val[2]]);
            t_data.push([val[0], val[3]]);
        });        
        seriesOption = [{
            name: 'R Current',
            data: r_data
        },{
            name: 'S Current',
            data: s_data
        },{
            name: 'T Current',
            data: t_data
        }];
        globaldata = data;
        initialize();
    });

    setInterval(function () {
        $.getJSON('{{route('get.graph', ['key'=> $key])}}', function (data) {
            var diff = arr_diff(globaldata, data);            
            if(diff.length > 0){
                console.log("update");
                $.each(diff, function(i, val){                    
                    var dt = val.split(',');                                        
                    var x = eval(dt[0]),
                        r = eval(dt[1]),
                        s = eval(dt[2]),
                        t = eval(dt[3]);
                    myChart.series[0].addPoint([x, r], true, true);
                    myChart.series[1].addPoint([x, s], true, true);
                    myChart.series[2].addPoint([x, t], true, true);
                });
            }
            globaldata = data;
        });        
    }, 1000);

    function initialize(){
        myChart = Highcharts.stockChart('mychart', {
            time: {
                timezoneOffset: -7 * 60
            },            
            rangeSelector: {
                selected: 1
            },

            title: {
                text: 'Usage Monitor'
            },

            series: seriesOption
        });
    }

    function arr_diff (a1, a2) {
        var a = [], diff = [];
        for (var i = 0; i < a1.length; i++) {
            a[a1[i]] = true;
        }
        for (var i = 0; i < a2.length; i++) {
            if (a[a2[i]]) {
                delete a[a2[i]];
            } else {
                a[a2[i]] = true;
            }
        }
        for (var k in a) {
            diff.push(k);
        }
        return diff;
    }
</script>
@endsection