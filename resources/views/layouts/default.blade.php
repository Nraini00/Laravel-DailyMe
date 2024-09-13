<!--  defaults blade for login and register -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield("title", "Daily Me")</title>
    <!-- CSS FILES -->        
       
    <link href="css/templatemo-topic-listing.css" rel="stylesheet"> 

    <!-- Load your custom CSS file -->
    @vite(['resources/sass/app.scss'])

</head>
<body id="top">

<main>

   @include('layouts.navbar')

   @yield("content")



    </main>

    <!-- JAVASCRIPT FILES -->
    <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.bundle.min.js"></script>
        <script src="js/custom.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>