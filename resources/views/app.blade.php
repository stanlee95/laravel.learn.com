<!DOCTYPE html>
<html>
<head>
    <title>Laravel</title>

    <!-- Bootstrap Core CSS -->
    <link href="/../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="/../css/sb-admin.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="/../css/plugins/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="/../font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

    <style>
        html, body {
            height: 100%;
        }
        body {
            margin: 0;
            padding: 0;
            width: 100%;
            display: table;
            font-weight: 100;
            font-family: 'Lato';
        }
        .content {
            text-align: center;
            display: inline-block;
        }
        .title {
            font-size: 96px;
        }
        .container{
            margin-top: 50px;
            width: 300px;

        }
    </style>

    <div>
        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="/">Home</a>
                </div>
                <div id="navbar" class ="navbar-collapse collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="/auth/register">Register</a></li>
                        <li><a href="/auth/login">Login</a></li>
                        <li><a href="/auth/logout">Logout</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>

</head>




<body>
<div class="container" align="center">
        @yield('content')
</div>
<script src="/../js/jquery.js"></script>
<script src="/../js/bootstrap.min.js"></script>

</body>
</html>
