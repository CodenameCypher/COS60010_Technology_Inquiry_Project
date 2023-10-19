<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'DefaultTitle')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" >
          <!-- Include Chart.js from CDN -->
          <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>



  </head>
  <body>
  
 
    @include('include.header')
    
    @yield('body','DefaultBody')
  
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" ></script>


    
    @include('include.footer')
  </body>
</html>