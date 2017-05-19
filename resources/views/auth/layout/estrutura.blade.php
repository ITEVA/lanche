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

    <title>Sistema do lanche</title>

    <!-- Bootstrap core CSS -->

    <link href="adm/css/bootstrap.min.css" rel="stylesheet">

    <link href="adm/fonts/css/font-awesome.min.css" rel="stylesheet">
    <link href="adm/css/animate.min.css" rel="stylesheet">

    <!-- Custom styling plus plugins -->
    <link href="adm/css/custom.css" rel="stylesheet">
    <link href="adm/css/icheck/flat/green.css" rel="stylesheet">


    <script src="adm/js/jquery.min.js"></script>

    <!--[if lt IE 9]>
    <script src="../assets/js/ie8-responsive-file-warning.js"></script>
    <![endif]-->

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Bootstrap core CSS -->

    <link href="adm/css/bootstrap.min.css" rel="stylesheet">

    <link href="adm/fonts/css/font-awesome.min.css" rel="stylesheet">
    <link href="adm/css/animate.min.css" rel="stylesheet">

    <!-- Custom styling plus plugins -->
    <link href="adm/css/custom.css" rel="stylesheet">
    <link href="adm/css/icheck/flat/green.css" rel="stylesheet">
    <!-- editor -->
    <link href="http://netdna.bootstrapcdn.com/font-awesome/3.0.2/css/font-awesome.css" rel="stylesheet">
    <link href="adm/css/editor/external/google-code-prettify/prettify.css" rel="stylesheet">
    <link href="adm/css/editor/index.css" rel="stylesheet">
    <!-- select2 -->
    <link href="adm/css/select/select2.min.css" rel="stylesheet">
    <!-- switchery -->
    <link rel="stylesheet" href="adm/css/switchery/switchery.min.css" />

    <link rel="stylesheet" href="adm/css/pglogin.css" />

    <script src="adm/js/jquery.min.js"></script>

    <!--[if lt IE 9]>
    <script src="../assets/js/ie8-responsive-file-warning.js"></script>
    <![endif]-->

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body style="background:#F7F7F7;">
<div class="">
    <a class="hiddenanchor" id="toregister"></a>
    <a class="hiddenanchor" id="tologin"></a>

    <div id="wrapper">

        <!-- Conteúdo do página -->
        @yield('conteudo')

    </div>
</div>
</body>

</html>

