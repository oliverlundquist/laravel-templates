<!doctype html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="{{ mix('/css/app.css') }}">

        <title>Editor</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .content {
                text-align: center;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref">
            <div class="content" style="flex:1">
                <img src="/images/mystore-header.png" style="width:100%" alt="Mystore Header" />
                <div id="app"></div>
            </div>
        </div>
        <script>window.template_id = {{ Route::current()->parameters()['id'] }}</script>
        <script src="{{ mix('/js/app.js') }}"></script>
    </body>
</html>
