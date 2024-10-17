<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Your Wardrobe</title>

        @vite('resources/js/app.js')
        @vite('resources/css/app.css')
        
        <!-- CSS FILES -->      
      <!-- CSS FILES -->      
      <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Unbounded:wght@300;400;700&display=swap" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-icons.css" rel="stylesheet">
    <link href="css/tooplate-mini-finance.css" rel="stylesheet">

    <!-- jQuery UI -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
    
       
    </head>
    
    <body>

        @include('navbar.header')

        <div class="container-fluid">
            <div class="row">
            
            @extends('navbar.sidenav')

            </div>
        </div>
    
    </body>

</html>
