<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Paiement échoué</title>
    </head>
    <style>
        body {
            font-family: "Figtree", sans-serif;
            background: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        form {
            background: white;
            padding: 20px 30px;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
        }

    </style>
    <body>
        <form method="get" action="/">
            <h1>Paiement échoué</h1>
            <button type="submit">Retourner à l'accueil</button>
        </form>
    </body>
</html>
