<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documentation API — Mon Orientation CI</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    <link rel="stylesheet" href="https://unpkg.com/swagger-ui-dist@5/swagger-ui.css">
    <style>
        body { margin: 0; background: #f5f7f6; font-family: system-ui, sans-serif; }
        header { padding: 18px 24px; background: #07352f; color: white; }
        header a { color: white; text-decoration: none; }
        header p { margin: 5px 0 0; color: #c9ded7; }
        #swagger-ui { max-width: 1200px; margin: 20px auto; }
        .swagger-ui .topbar { display: none; }
    </style>
</head>
<body>
    <header>
        <a href="{{ route('welcome') }}"><strong>Mon Orientation CI</strong> · Documentation API</a>
        <p>Explorez les endpoints et utilisez « Try it out » pour envoyer des requêtes de test.</p>
    </header>
    <div id="swagger-ui"></div>
    <script src="https://unpkg.com/swagger-ui-dist@5/swagger-ui-bundle.js"></script>
    <script>
        window.ui = SwaggerUIBundle({
            url: @json(asset('swagger.json')),
            dom_id: '#swagger-ui',
            deepLinking: true,
            displayRequestDuration: true,
            presets: [SwaggerUIBundle.presets.apis],
            layout: 'BaseLayout'
        });
    </script>
</body>
</html>
