<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Confirmer le nouveau mot de passe</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div>
    <form action="{{ route('password.update') }}" method="POST">
    @csrf
    <input type="hidden" name="token" value="{{$token}}">
    <h1>Réinitialisation du mot de passe</h1>
    <h3>Adresse email</h3>
    <input type="text" name="email" placeholder="Saisir votre adresse email">
    <br>
    <h3>Mot de passe</h3>
    <input type="password" name="password" placeholder="Saisir le nouveau mot de passe">
    <br>
    <h3>Confirmation du mot de passe</h3>
    <input type="password" name="password_confirmation" placeholder="Confirmer le nouveau mot de passe">
    <br>
    <button type="submit">Modifier le mot de passe</button>
    @if(isset($errors) && count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
</form>

</div>
    
</body>
</html>