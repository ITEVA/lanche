<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="adm/images/favicon.png">

    <!-- Url base do sistema -->
    <base href="{{url('/')}}" target="_self" />

    <title>Gerenciamento do site</title>

    <!-- Bootstrap core CSS -->
    <link href="adm/css/bootstrap.min.css" rel="stylesheet">
    <link href="adm/fonts/css/font-awesome.min.css" rel="stylesheet">
    <link href="adm/css/animate.min.css" rel="stylesheet">

    <!-- Custom styling plus plugins -->
    <link href="adm/css/custom.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="adm/css/maps/jquery-jvectormap-2.0.3.css" />
    <link href="adm/css/icheck/flat/green.css" rel="stylesheet" />
    <link href="adm/css/floatexamples.css" rel="stylesheet" type="text/css" />
    <link href="adm/css/principal.css" rel="stylesheet">

    <!-- Links extras css -->
    @yield('css')

    <script src="adm/js/jquery.min.js"></script>
    <script src="adm/js/nprogress.js"></script>

    <script src="adm/js/jquery.mask.min.js"></script>
    <script src="adm/js/jquery.maskMoney.min.js"></script>

    <script src="adm/js/principal.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body class="nav-md">
<div class="container body">
    <div class="main_container">
        <div class="col-md-3 left_col">
            <div class="left_col scroll-view">
                <div class="navbar nav_title" style="border: 0;">
                    <a href="/home" class="site_title"><img src="adm/images/logoAdm2.png"></a>
                </div>
                <div class="clearfix"></div>

                <!-- menu prile quick info -->
                <div class="profile">
                    <div class="profile_pic">
                        <img src="adm/images/perfil/{{Auth::user()->foto}}" alt="..." class="img-circle profile_img">
                    </div>
                    <div class="profile_info">
                        <span>Bem-vindo,</span>
                        <h2>{{Auth::user()->apelido}}</h2>
                    </div>
                </div>
                <!-- /menu prile quick info -->
                <br />

                <!-- sidebar menu -->
                <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                    <div class="menu_section">
                        <h3 style="opacity: 0.0;">-</h3>
                        <ul class="nav side-menu">
                            @if(isset($itensPermitidos['inicio']))
                                <li><a href="/home">
                                        <i class="fa fa-home"></i>
                                        Início </a></li>
                            @endif
                            @if(isset($itensPermitidos['user']))
                                <li><a href="users">
                                        <i class="fa fa-users"></i>
                                        Usuários </a></li>
                            @endif
                            @if(isset($itensPermitidos['permissao']))
                                <li><a href="permissoes">
                                        <i class="fa fa-lock"></i>
                                        Permissões <span class="fa "></span></a></li>
                            @endif
                            @if(isset($itensPermitidos['produto']))
                                <li><a href="produtos">
                                        <i class="fa fa-coffee"></i>
                                        Produtos <span class="fa "></span></a></li>
                            @endif
                            @if(isset($itensPermitidos['cardapio']))
                                <li><a href="cardapios">
                                        <i class="fa fa-map-o"></i>
                                        Cardápio <span class="fa "></span></a></li>
                            @endif
                            @if(isset($itensPermitidos['perfil']))
                                <li><a href="perfil/{{Auth::user()->id}}">
                                        <i class="fa fa-user"></i>
                                        Perfil <span class="fa "></span></a></li>
                            @endif
                            @if(isset($itensPermitidos['pedido']))
                                <li><a href="pedidos">
                                        <i class="fa fa-cutlery"></i>
                                        Pedido <span class="fa "></span></a></li>
                            @endif
                            @if(isset($itensPermitidos['relatorio']))
                                <li><a>
                                        <i class="fa fa-file-text-o"></i>
                                        Relatórios <span class="fa fa-chevron-down"></span></a>

                                    <ul class="nav child_menu" style="display: none">
                                        <li><a href="relatorios/pedidos">Pedidos</a></li>
                                    </ul>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
                <!-- /sidebar menu -->
                <!-- /menu footer buttons -->
            </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
            <div class="nav_menu">
                <nav class="" role="navigation">
                    <div class="nav toggle">
                        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                    </div>

                    <ul class="nav navbar-nav navbar-right">
                        <li class="">
                            <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <img src="adm/images/perfil/{{Auth::user()->foto}}" alt="">{{Auth::user()->apelido}}
                                <span class=" fa fa-angle-down"></span>
                            </a>
                            <ul class="dropdown-menu dropdown-usermenu animated fadeInDown pull-right">
                                <li><a href="users/editarPerfil/{{Auth::user()->id}}">Alterar Dados</a>
                                </li>
                                <li><a href="sair"><i class="fa fa-sign-out pull-right"></i>Sair</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        <!-- /top navigation -->
        <!-- page content -->
        <div class="right_col" role="main">

            <!-- Conteúdo do página -->
            @yield('conteudo')

           <!-- footer content -->
            <footer>
                <div class="copyright-info">
                    <p class="pull-right">Copyright © {{date('Y')}} Iteva - Todos os direitos reservados · Português (Brasil).</a>
                    </p>
                </div>
                <div class="clearfix"></div>
            </footer>
            <!-- /footer content -->
        </div>
        <!-- /page content -->
    </div>
</div>

<script src="adm/js/bootstrap.min.js"></script>

<!-- gauge js -->
<script type="text/javascript" src="adm/js/gauge/gauge.min.js"></script>
<script type="text/javascript" src="adm/js/gauge/gauge_demo.js"></script>

<!-- bootstrap progress js -->
<script src="adm/js/progressbar/bootstrap-progressbar.min.js"></script>
<script src="adm/js/nicescroll/jquery.nicescroll.min.js"></script>

<!-- icheck -->
<script src="adm/js/icheck/icheck.min.js"></script>

<!-- daterangepicker -->
<script type="text/javascript" src="adm/js/moment/moment.min.js"></script>
<script type="text/javascript" src="adm/js/datepicker/daterangepicker.js"></script>

<!-- chart js -->
<script src="adm/js/chartjs/chart.min.js"></script>
<script src="adm/js/custom.js"></script>

<!-- flot js -->
<!--[if lte IE 8]><script type="text/javascript" src="adm/js/excanvas.min.js"></script><![endif]-->
<script type="text/javascript" src="adm/js/flot/jquery.flot.js"></script>
<script type="text/javascript" src="adm/js/flot/jquery.flot.pie.js"></script>
<script type="text/javascript" src="adm/js/flot/jquery.flot.orderBars.js"></script>
<script type="text/javascript" src="adm/js/flot/jquery.flot.time.min.js"></script>
<script type="text/javascript" src="adm/js/flot/date.js"></script>
<script type="text/javascript" src="adm/js/flot/jquery.flot.spline.js"></script>
<script type="text/javascript" src="adm/js/flot/jquery.flot.stack.js"></script>
<script type="text/javascript" src="adm/js/flot/curvedLines.js"></script>
<script type="text/javascript" src="adm/js/flot/jquery.flot.resize.js"></script>
<script>
    $(document).ready(function() {
        // [17, 74, 6, 39, 20, 85, 7]
        //[82, 23, 66, 9, 99, 6, 2]
        var data1 = [
            [gd(2012, 1, 1), 17],
            [gd(2012, 1, 2), 74],
            [gd(2012, 1, 3), 6],
            [gd(2012, 1, 4), 39],
            [gd(2012, 1, 5), 20],
            [gd(2012, 1, 6), 85],
            [gd(2012, 1, 7), 7]
        ];

        var data2 = [
            [gd(2012, 1, 1), 82],
            [gd(2012, 1, 2), 23],
            [gd(2012, 1, 3), 66],
            [gd(2012, 1, 4), 9],
            [gd(2012, 1, 5), 119],
            [gd(2012, 1, 6), 6],
            [gd(2012, 1, 7), 9]
        ];
        $("#canvas_dahs").length && $.plot($("#canvas_dahs"), [
            data1, data2
        ], {
            series: {
                lines: {
                    show: false,
                    fill: true
                },
                splines: {
                    show: true,
                    tension: 0.4,
                    lineWidth: 1,
                    fill: 0.4
                },
                points: {
                    radius: 0,
                    show: true
                },
                shadowSize: 2
            },
            grid: {
                verticalLines: true,
                hoverable: true,
                clickable: true,
                tickColor: "#d5d5d5",
                borderWidth: 1,
                color: '#fff'
            },
            colors: ["rgba(38, 185, 154, 0.38)", "rgba(3, 88, 106, 0.38)"],
            xaxis: {
                tickColor: "rgba(51, 51, 51, 0.06)",
                mode: "time",
                tickSize: [1, "day"],
                //tickLength: 10,
                axisLabel: "Date",
                axisLabelUseCanvas: true,
                axisLabelFontSizePixels: 12,
                axisLabelFontFamily: 'Verdana, Arial',
                axisLabelPadding: 10
                //mode: "time", timeformat: "%m/%d/%y", minTickSize: [1, "day"]
            },
            yaxis: {
                ticks: 8,
                tickColor: "rgba(51, 51, 51, 0.06)",
            },
            tooltip: false
        });

        function gd(year, month, day) {
            return new Date(year, month - 1, day).getTime();
        }
    });
</script>

<!-- worldmap -->
<script type="text/javascript" src="adm/js/maps/jquery-jvectormap-2.0.3.min.js"></script>
<script type="text/javascript" src="adm/js/maps/gdp-data.js"></script>
<script type="text/javascript" src="adm/js/maps/jquery-jvectormap-world-mill-en.js"></script>
<script type="text/javascript" src="adm/js/maps/jquery-jvectormap-us-aea-en.js"></script>

<!-- pace -->
<!-- <script src="adm/js/pace/pace.min.js"></script>
<script>
    $(function() {
        $('#world-map-gdp').vectorMap({
            map: 'world_mill_en',
            backgroundColor: 'transparent',
            zoomOnScroll: false,
            series: {
                regions: [{
                    values: gdpData,
                    scale: ['#E6F2F0', '#149B7E'],
                    normalizeFunction: 'polynomial'
                }]
            },
            onRegionTipShow: function(e, el, code) {
                el.html(el.html() + ' (GDP - ' + gdpData[code] + ')');
            }
        });
    });
</script> -->

<!-- skycons -->
<script src="adm/js/skycons/skycons.min.js"></script>
<script>
    var icons = new Skycons({
                "color": "#73879C"
            }),
            list = [
                "clear-day", "clear-night", "partly-cloudy-day",
                "partly-cloudy-night", "cloudy", "rain", "sleet", "snow", "wind",
                "fog"
            ],
            i;

    for (i = list.length; i--;)
        icons.set(list[i], list[i]);

    icons.play();
</script>

<!-- dashbord linegraph -->
<script>
    Chart.defaults.global.legend = {
        enabled: false
    };

    var data = {
        labels: [
            "Symbian",
            "Blackberry",
            "Other",
            "Android",
            "IOS"
        ],
        datasets: [{
            data: [15, 20, 30, 10, 30],
            backgroundColor: [
                "#BDC3C7",
                "#9B59B6",
                "#455C73",
                "#26B99A",
                "#3498DB"
            ],
            hoverBackgroundColor: [
                "#CFD4D8",
                "#B370CF",
                "#34495E",
                "#36CAAB",
                "#49A9EA"
            ]

        }]
    };

    var canvasDoughnut = new Chart(document.getElementById("canvas1"), {
        type: 'doughnut',
        tooltipFillColor: "rgba(51, 51, 51, 0.55)",
        data: data
    });
</script>

<!-- /dashbord linegraph -->
<!-- datepicker -->
<script type="text/javascript">
    $(document).ready(function() {

        var cb = function(start, end, label) {
            console.log(start.toISOString(), end.toISOString(), label);
            $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            //alert("Callback has fired: [" + start.format('MMMM D, YYYY') + " to " + end.format('MMMM D, YYYY') + ", label = " + label + "]");
        }

        var optionSet1 = {
            startDate: moment().subtract(29, 'days'),
            endDate: moment(),
            minDate: '01/01/2012',
            maxDate: '12/31/2015',
            dateLimit: {
                days: 60
            },
            showDropdowns: true,
            showWeekNumbers: true,
            timePicker: false,
            timePickerIncrement: 1,
            timePicker12Hour: true,
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
            opens: 'left',
            buttonClasses: ['btn btn-default'],
            applyClass: 'btn-small btn-primary',
            cancelClass: 'btn-small',
            format: 'MM/DD/YYYY',
            separator: ' to ',
            locale: {
                applyLabel: 'Submit',
                cancelLabel: 'Clear',
                fromLabel: 'From',
                toLabel: 'To',
                customRangeLabel: 'Custom',
                daysOfWeek: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
                monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                firstDay: 1
            }
        };
        $('#reportrange span').html(moment().subtract(29, 'days').format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));
        $('#reportrange').daterangepicker(optionSet1, cb);
        $('#reportrange').on('show.daterangepicker', function() {
            console.log("show event fired");
        });
        $('#reportrange').on('hide.daterangepicker', function() {
            console.log("hide event fired");
        });
        $('#reportrange').on('apply.daterangepicker', function(ev, picker) {
            console.log("apply event fired, start/end dates are " + picker.startDate.format('MMMM D, YYYY') + " to " + picker.endDate.format('MMMM D, YYYY'));
        });
        $('#reportrange').on('cancel.daterangepicker', function(ev, picker) {
            console.log("cancel event fired");
        });
        $('#options1').click(function() {
            $('#reportrange').data('daterangepicker').setOptions(optionSet1, cb);
        });
        $('#options2').click(function() {
            $('#reportrange').data('daterangepicker').setOptions(optionSet2, cb);
        });
        $('#destroy').click(function() {
            $('#reportrange').data('daterangepicker').remove();
        });
    });
</script>
<script>
    NProgress.done();
</script>
<!-- /datepicker -->
<!-- /footer content -->

<script type="text/javascript">
    $(document).ready(function() {
        $('.date-picker').daterangepicker({
            singleDatePicker: true,
            calender_style: "picker_4"
        }, function(start, end, label) {
            console.log(start.toISOString(), end.toISOString(), label);
        });
    });
</script>

<!-- daterangepicker -->
<script type="text/javascript" src="adm/js/moment/moment.min.js"></script>
<script type="text/javascript" src="adm/js/datepicker/daterangepicker.js"></script>

<!-- Custom styling plus plugins -->
<link href="adm/css/custom.css" rel="stylesheet">
<link href="adm/css/icheck/flat/green.css" rel="stylesheet">
<!-- editor -->
<link href="http://netdna.bootstrapcdn.com/font-awesome/3.0.2/css/font-awesome.css" rel="stylesheet">
<link href="adm/css/editor/external/google-code-prettify/prettify.css" rel="stylesheet">

<!-- switchery -->
<link rel="stylesheet" href="adm/css/switchery/switchery.min.css" />


<!-- Links extras js -->
@yield('js')

</body>
</html>
