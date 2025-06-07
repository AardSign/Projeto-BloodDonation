
<!DOCTYPE html>
<html lang="en">
  <head>
    @include('admin.css')
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#0d6efd">
    <link rel="icon" href="/icons/icon-192.png" type="image/png">
  </head>
  <body>

      @include('admin.sidebar')
    
      @include('admin.navbar')

      

    @include('admin.script')
    

  </body>
</html>