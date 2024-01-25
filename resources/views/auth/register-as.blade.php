<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">


    <style>
        .login {
          background-image: url('{{ asset('img/bg2.png')}}');
          background-size: cover;
          background-attachment: fixed;
          height: 100vh; 
        }
      </style>
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>

    <div class="wrapper">

        <section class=" d-flex align-items-center page-section-ptb login" >
            <div class="container">
                <div class="row justify-content-center no-gutters vertical-align">

                    <div style="border-radius: 15px;" class="col-lg-8 col-md-8 bg-white">
                        <div class="login-fancy pb-40 clearfix" style="display: grid;
                        align-items: end;
                        height: 55vh;
                        justify-content: center;
                        justify-items: center;">
                            <h3 class="mb-30" style="font-weight: 790;
                            color: cornflowerblue;
                            font-size: 2.5em;
                            font-family: cursive;"> Register As </h3>
                            <div class="form-inline">
                                <span>User</span>
                                <a class="btn btn-default col-lg-3" title="user" href="{{route('register')}}"style="text-decoration: none">
                                    <img alt="user-img" width="100px;" src="{{URL::asset('img/user2.png')}}" style="padding-right:2em">
                                </a>
                                <a class="btn btn-default col-lg-3" title="vendor" href="/vendor/register" style="text-decoration: none">
                                    <img alt="vendor-img" width="100px;" src="{{URL::asset('img/vendor2.png')}}"style="padding-left:2em">
                                </a>
                                <span>Vendor</span>


                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>


</body>

</html>
