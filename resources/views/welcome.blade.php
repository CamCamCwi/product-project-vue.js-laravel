<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link href="{{asset('css/app.css')}}" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
        {{-- <script src="https://unpkg.com/vue/dist/vue.js"></script> --}}
        <script src="https://unpkg.com/vue-router/dist/vue-router.js"></script>  
    </head>
    <body>
            <div id="app" class="content">
                <nav class="navbar navbar-light bg-light">
                    <div class="container">
                      <a class="navbar-brand" href="#">
                        <img src="https://res.cloudinary.com/camprueba/image/upload/v1630595774/logorec_ztqywp.png" alt="" width="200" height="100">
                      </a>
                      <div class="nav-item">
                        <router-link to="/product" class="nav-link" style="color: orange">Product</router-link>
                    </div>
                    <div class="nav-item">
                        <router-link to="/category" class="nav-link" style="color: orange">Category</router-link>
                    </div>
                    </div>
                    
                  </nav>
                <div style="height: 70px"></div>
                <router-view></router-view>
            </div>
        <script src="{{asset('js/app.js')}}"></script> 
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-eMNCOe7tC1doHpGoWe/6oMVemdAVTMs2xqW4mwXrXsW0L84Iytr2wi5v2QjrP/xp" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js" integrity="sha384-cn7l7gDp0eyniUwwAZgrzD06kc/tftFf19TOAs2zVinnD/C7E91j9yyk5//jjpt/" crossorigin="anonymous"></script>
    </body>
</html>