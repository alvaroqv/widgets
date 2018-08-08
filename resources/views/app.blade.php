<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <title>@yield('title')</title>
    </head>
    <body>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
            <a class="navbar-brand" href="#">Widgets</a>
            </div>
            <ul class="nav navbar-nav">
            <li><a href="/index">Home</a></li>
            <li><a href="/upload">Upload Files</a></li>
            <li><a href="/json">Process File</a></li>
            <li><a href="/json/processing">Processing File</a></li>
            <li><a href="/json/processed">Processed File</a></li>
            </ul>
        </div>
        </nav>

        <div class="container">
                @yield('content')
        </div>
        <!-- jQuery library -->
        <script ype="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script ype="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        @yield('script')
    </body>
</html>