<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="shortcut icon" href="{{asset('favicon.png')}}" />

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>

        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style>
    </head>
    <body class="antialiased">
        <nav class="navbar navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand d-flex" href="#" style="align-items:center;">
                    <img src="{{asset('favicon.png')}}" alt="" width="30" height="24">
                    <span class="ms-2">Majoo Teknologi Indonesia</span>
                </a>
            </div>
        </nav>
        <div class="container" style="padding-top:34px">
            <h2>Produk</h2>
            <div class="row">
                @foreach($products as $product)
                <div class="col-12 col-md-3">
                    <div class="card">
                        <img src="{{$product->images[0]->file_url}}" class="card-img-top" alt="{{$product->name}}">
                        <div class="card-body">
                            <div class="text-center">
                                <h5 class="card-title">{{$product->name}}</h5>
                                <h3 class="card-title">Rp. {{$product->price_format}}</h3>
                            </div>
                            <p class="card-text">{!!$product->description!!}</p>
                            <center>
                                <a href="#" class="btn btn-success">Beli</a>
                            </center>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </body>
</html>
