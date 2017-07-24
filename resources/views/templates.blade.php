<!doctype html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">

    <title>Templates List</title>

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

        /* custom styles */
        .page-content {
            width: 70%;
            padding:20px 0;
            display:inline-block;
        }

        .template-row {
            display: flex;
            /*justify-content: space-between;*/
            align-items: flex-start;
        }

        .template-wrapper {
            /*flex:1;*/
            padding:1%;
            width:24%;
        }

        .template-frame {
            height:200px;
            border:1px solid #636b6f;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size:26px;
            margin-bottom: 10px;
        }

        .form-btn-wrapper {
            display: inline-block;
        }
    </style>
</head>
<body>
<div class="flex-center position-ref">
    <div class="content" style="flex:1">
        <img src="/images/mystore-header.png" style="width:100%" alt="Mystore Header" />
        <div class="page-content">
            @foreach ($contents->chunk(4) as $chunks)
                <div class="template-row">
                    @foreach ($chunks as $content)
                        <div class="template-wrapper">
                            <div class="template-frame">Template {{ $content->id }}</div>
                            <a href="/editor/{{ $content->id }}" class="btn btn-default">Edit</a>
                            {!! Form::open(['url' => '/templates/activate/' . $content->id, 'method' => 'post', 'class' => 'form-btn-wrapper']) !!}
                                @if ($content->active === 1)
                                    <button class="btn disabled" disabled="disabled">Activate</button>
                                @else
                                    <button class="btn btn-default">Activate</button>
                                @endif
                            {!! Form::close() !!}
                            <a href="/?preview_template_id={{ $content->id }}" class="btn btn-default">Preview</a>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
</div>
{{--<script src="{{ mix('/js/app.js') }}"></script>--}}
</body>
</html>
