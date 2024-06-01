<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>

    <title>Formulaire de Location de Véhicule</title>

    <link rel="preconnect" href="https://fonts.bunny.net"/>
    <link
        href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap"
        rel="stylesheet"
    />

    <style>
        body {
            font-family: "Figtree", sans-serif;
            background: #f0f2f5;
            display: flex;
            flex-direction: column;
            gap: 15px;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .form {
            display: flex;
            flex-direction: column;
            background: white;
            padding: 20px 30px;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
        }

        .form h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        .input-group {
            margin-bottom: 15px;
        }

        .input-group label {
            font-size: 14px;
            margin-bottom: 5px;
            color: #555;
        }

        .input-group input,
        .input-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 6px;
            transition: border-color 0.3s;
        }

        .input-group input:focus,
        .input-group select:focus {
            border-color: #007bff;
            outline: none;
        }

        .btn {
            background: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-top: 10px;
        }

        .btn:hover {
            background: #0056b3;
        }

        .btn-dashboard {
            align-self: center;
        }
    </style>
</head>
<body>
<h1>Location de Véhicule</h1>
<form action="/form" class="form" method="POST">
    @CSRF
    <h2>Formulaire de Location</h2>
    <div class="input-group">
        <label for="lastname">Nom</label>
        <input id="lastname" type="text" name="lastname"/>
    </div>

    <div class="input-group">
        <label for="firstname">Prénom</label>
        <input id="firstname" type="text" name="firstname"/>
    </div>

    <div class="input-group">
        <label for="age">Âge</label>
        <input id="age" type="number" name="age"/>
    </div>

    <div class="input-group">
        <label for="city">Ville</label>
        <select id="city" name="city">
            <option value="paris">Paris</option>
            <option value="lille">Lille</option>
            <option value="toulouse">Toulouse</option>
            <option value="lyon">Lyon</option>
            <option value="bordeaux">Bordeaux</option>
        </select>
    </div>

    <div class="input-group">
        <label for="vehicle">Véhicule à louer</label>
        <select id="vehicle" name="vehicle">
            <option value="bmw">BMW</option>
            <option value="audi">Audi</option>
            <option value="mercedes">Mercedes</option>
            <option value="renault">Renault</option>
            <option value="peugeot">Peugeot</option>
        </select>
    </div>
    <button class="btn" type="submit">Envoyer</button>
</form>
<form class="form" action="/dashboard" method="get">
    <button class="btn btn-dashboard" type="submit"> Voir le dashboard</button>
</form>
</body>
</html>
