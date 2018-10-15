<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Test Map Tracker</title>

        <!-- Styles -->
        <link href="/css/app.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <main role="main">
            <div class="container" id="app">
                <track-comp
                        resource-url="/api/country"
                        @country_list_loaded="updateCountryList"
                        @city_list_loaded="updateCityList"
                        @client_list_loaded="updateClientList"
                        @tracking_list_loaded="updateTrackingList"
                        @map_initialized="initHandler"
                ></track-comp>
            </div>
        </main>

        <script type="text/javascript" src="/js/app.js"></script>
    </body>
</html>
