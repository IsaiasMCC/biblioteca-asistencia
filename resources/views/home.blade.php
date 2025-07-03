@extends('layouts.app')

@push('title', 'home')

@section('static')
    <div class="mt-3">
        <div class="row">
            <div class="col-lg-3">
                <div class="ibox ">
                    <div class="ibox-title">
                        <span class="label label-success float-right">Hoy</span>
                        <h5>Usuarios</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins">{{ $countUsers }}</h1>
                        <div class="stat-percent font-bold text-success">98% <i class="fa fa-bolt"></i>
                        </div>
                        <small>Total usuarios</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="ibox ">
                    <div class="ibox-title">
                        <span class="label label-info float-right">Mes</span>
                        <h5>Ingresos</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins">{{ $ingresos }} </h1>
                        <div class="stat-percent font-bold text-info">20% <i class="fa fa-level-up"></i>
                        </div>
                        <small>Total ingresos </small>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="ibox ">
                    <div class="ibox-title">
                        <span class="label label-primary float-right">Hoy</span>
                        <h5>Visitas</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins"> {{ $pageVisits }} </h1>
                        <div class="stat-percent font-bold text-navy">44% <i class="fa fa-level-up"></i>
                        </div>
                        <small>Nuevas visitas</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="ibox ">
                    <div class="ibox-title">
                        <span class="label label-danger float-right">Low value</span>
                        <h5>Asistencias</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins"> {{ $asistencias }} </h1>
                        <div class="stat-percent font-bold text-danger">38% <i class="fa fa-level-down"></i>
                        </div>
                        <small>En el 1er Mes.</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
@endpush

@push('scripts')

    <!-- Flot y plugins necesarios -->
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/flot/4.2.6/jquery.flot.min.js" integrity="sha512-BZB0eb1GasYmnJKCpbVNxLztPbST5+cPuNJ8OOYKNlFEegs9KZHVXeDvVBl0E4EKRc87LGCGhmmGy998RqFAVQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/flot/4.2.6/jquery.flot.time.min.js" integrity="sha512-wARN3zVErYletJDgWZddKYlnRbWf8FLc/+CjmKF4TqXHu728ENDyTfpekd5YIK3VvjSZwGGS/pSNwkY4lvsNZA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/flot.tooltip/0.9.0/jquery.flot.tooltip.min.js"></script> --}}
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/flot/0.8.3/jquery.flot.spline.min.js"></script> --}}

    <!-- Easy Pie Chart -->
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/easy-pie-chart/2.1.3/jquery.easypiechart.min.js" integrity="sha512-fhnkAk555ylMoeyEhF7uFyWF4XW/UnTa5BnF3q5jYaFn2q51SxK6xQdd3kwzYiUfEBnA7JtR3BCJKTe9HEuveQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}

    <script>
        // $(document).ready(function() {
        //     const fichas = document.getElementById('fichas');
        //     const fichasList = JSON.parse(fichas.value);

        //     $('.chart').easyPieChart({
        //         barColor: '#f8ac59',
        //         scaleLength: 5,
        //         lineWidth: 4,
        //         size: 80
        //     });

        //     $('.chart2').easyPieChart({
        //         barColor: '#1c84c6',
        //         scaleLength: 5,
        //         lineWidth: 4,
        //         size: 80
        //     });

        //     const data2 = fichasList.map(ficha => {
        //         let date = new Date(ficha.date);
        //         return [gd(date.getFullYear(), date.getMonth() + 1, date.getDate()), Number(ficha.total)];
        //     });

        //     var dataset = [{
        //         label: "Numeros de fichas",
        //         data: data2,
        //         color: "#1ab394",
        //         bars: {
        //             show: true,
        //             align: "center",
        //             barWidth: 24 * 60 * 60 * 600,
        //             lineWidth: 0
        //         }
        //     }, {
        //         label: "Pagos",
        //         data: data2,
        //         yaxis: 2,
        //         color: "#1C84C6",
        //         lines: {
        //             lineWidth: 1,
        //             show: true,
        //             fill: true,
        //             fillColor: {
        //                 colors: [{
        //                     opacity: 0.2
        //                 }, {
        //                     opacity: 0.4
        //                 }]
        //             }
        //         },
        //         splines: {
        //             show: false,
        //             tension: 0.6,
        //             lineWidth: 1,
        //             fill: 0.1
        //         },
        //     }];

        //     var options = {
        //         xaxis: {
        //             mode: "time",
        //             tickSize: [1, "day"],
        //             tickLength: 0,
        //             axisLabel: "Date",
        //             axisLabelUseCanvas: true,
        //             axisLabelFontSizePixels: 12,
        //             axisLabelFontFamily: 'Arial',
        //             axisLabelPadding: 10,
        //             color: "#d5d5d5"
        //         },
        //         yaxes: [{
        //             position: "left",
        //             max: 1070,
        //             color: "#d5d5d5",
        //             axisLabelUseCanvas: true,
        //             axisLabelFontSizePixels: 12,
        //             axisLabelFontFamily: 'Arial',
        //             axisLabelPadding: 3
        //         }, {
        //             position: "right",
        //             color: "#d5d5d5",
        //             axisLabelUseCanvas: true,
        //             axisLabelFontSizePixels: 12,
        //             axisLabelFontFamily: ' Arial',
        //             axisLabelPadding: 67
        //         }],
        //         legend: {
        //             noColumns: 1,
        //             labelBoxBorderColor: "#000000",
        //             position: "nw"
        //         },
        //         grid: {
        //             hoverable: false,
        //             borderWidth: 0
        //         }
        //     };

        //     function gd(year, month, day) {
        //         return new Date(year, month - 1, day).getTime();
        //     }

        //     $.plot($("#flot-dashboard-chart"), dataset, options);
        // });
    </script>
@endpush

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Ingresos</h5>
                    <div class="float-right">
                        <div class="btn-group">
                            <button type="button" class="btn btn-xs btn-white active">Today</button>
                            <button type="button" class="btn btn-xs btn-white">Monthly</button>
                            <button type="button" class="btn btn-xs btn-white">Annual</button>
                        </div>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="flot-chart">
                                <input id="fichas" type="hidden" value='@json($fichasList)'>
                                <div class="flot-chart-content" id="flot-dashboard-chart"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
