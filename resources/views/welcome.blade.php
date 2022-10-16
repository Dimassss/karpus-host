<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="Головна сторінка сайту ферми Карпусь"/>
        <link href="https://karpus.com.ua/favicon.ico" rel='icon' type="image/x-icon"/>

        <title>Ферма Карпусь</title>

        <link defer rel="stylesheet" href="{{ mix('css/app.css') }}" type="text/css"/>
        <link defer rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    </head>
    <body>
        <div id="app">
            <app></app>
        </div>

        <script defer src="{{ mix('/js/app.js') }}"></script>
        <!--script
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAzvlVP-ThHh5Xjx-6g1GqEZiGxF65fW2Q&callback=initMap&libraries=&v=weekly"
            defer
        ></script-->
    </body>
</html>
