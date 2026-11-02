<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accès administrateur — Mon Orientation CI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { min-height: 100vh; display: grid; place-items: center; padding: 24px; background: #0c1726; font-family: system-ui, sans-serif; }
        .card { width: min(100%, 460px); padding: 36px; border: 1px solid #26384a; border-radius: 24px; background: #142235; color: white; box-shadow: 0 24px 80px #02081288; }
        .logo { width: 58px; height: 58px; display: grid; place-items: center; border-radius: 18px; color: white; font-size: 28px; background: linear-gradient(145deg,#ffa329,#ff8200 60%,#db6700); box-shadow: 0 12px 30px #ff820044; }
        .form-control { padding: 12px 14px; color: white; background: #0c1726; border-color: #31455b; }
        .form-control:focus { color: white; background: #0c1726; border-color: #ff8200; box-shadow: 0 0 0 .2rem #ff820033; }
        .btn-orange { color: white; background: #ff8200; font-weight: 700; }
        .btn-orange:hover { color: white; background: #e06c00; }
    </style>
</head>
<body>
<main class="card">
    <div class="logo mb-4" aria-hidden="true">⌂</div>
    <p class="text-uppercase small fw-bold mb-2" style="color:#ffad52;letter-spacing:1.4px">Espace sécurisé</p>
    <h1 class="h3 fw-bold">Connexion administrateur</h1>
    <p class="text-white-50 mb-4">Connectez-vous avec votre matricule MESRS et votre mot de passe.</p>

    @if ($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('admin.login.store') }}">
        @csrf
        <div class="mb-3">
            <label for="matricule" class="form-label">Matricule</label>
            <input id="matricule" name="matricule" value="{{ old('matricule') }}" class="form-control" autocomplete="username" required autofocus>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <input id="password" name="password" type="password" class="form-control" autocomplete="current-password" required>
        </div>
        <div class="form-check mb-4">
            <input id="remember" name="remember" type="checkbox" class="form-check-input">
            <label for="remember" class="form-check-label text-white-50">Se souvenir de moi</label>
        </div>
        <button class="btn btn-orange w-100 py-3" type="submit">Accéder au panel admin</button>
    </form>

    <a class="link-light text-center mt-4" href="{{ route('welcome') }}">Retour à l’accueil</a>
</main>
</body>
</html>
