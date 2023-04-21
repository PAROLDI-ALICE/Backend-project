<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Password successfully reset</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/resetSuccess.css') }}">
</head>
<body>
    <div class="container">
        <h1>{{$status}}</h1>
        @if(isset($redirectTo))
            <div class="btn-container">
                <a href="{{ $redirectTo }}" class="btn">Aller à Google</a>
            </div>
            <script>
                setTimeout(function() {
                    window.location.href = "{{ $redirectTo }}";
                }, 2000);
            </script>
        @endif
    </div>
</body>
</html>
