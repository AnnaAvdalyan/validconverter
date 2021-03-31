<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
{{--    <link rel="preconnect" href="https://fonts.gstatic.com">--}}
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap"
          rel="stylesheet">
{{--    <link rel="stylesheet" href="css/jquery.formstyler.css">--}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"
          integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw=="
          crossorigin="anonymous"/>
{{--    <link rel="stylesheet" href="{{ asset('css/app.css') }}">--}}
</head>
<body >

<div id="app">
    <example-component></example-component>
</div>


<!--<div class="div">-->
<!--    <span class="default">Send</span>-->
<!--    <span class="success">-->
<!--        <svg viewBox="0 0 16 16">-->
<!--            <polyline points="3.75 9 7 12 13 5"></polyline>-->
<!--        </svg>Sent-->
<!--    </span>-->
<!--    <svg class="trails" viewBox="0 0 33 64">-->
<!--        <path d="M26,4 C28,13.3333333 29,22.6666667 29,32 C29,41.3333333 28,50.6666667 26,60"></path>-->
<!--        <path d="M6,4 C8,13.3333333 9,22.6666667 9,32 C9,41.3333333 8,50.6666667 6,60"></path>-->
<!--    </svg>-->
<!--    <div class="plane">-->
<!--        <div class="left"></div>-->
<!--        <div class="right"></div>-->
<!--    </div>-->
<!--</div>-->

<!--    <button class="button"></button>-->


{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"--}}
{{--        integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A=="--}}
{{--        crossorigin="anonymous"></script>--}}
<script src="{{ asset('js/main.js') }}"></script>

<script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
