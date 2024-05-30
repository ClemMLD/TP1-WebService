<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Paiement réussi</title>

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
    </style>
    <body>
        <div class="card">
            <h1>Merci pour votre paiement</h1>
            <p>Récpitulatif</p>
            <p><span class="bold-element"> Conducteur </span> : {{data_get($customerDetails, 'lastname')}} {{data_get($customerDetails, 'firstname')}} {{data_get($customerDetails, 'age')}}  ans</p>
            <p><span class="bold-element"> Véhicule </span> : {{data_get($customerDetails, 'car')}}</p>
            <p><span class="bold-element"> Ville </span> : {{data_get($customerDetails, 'city')}}</p>
            <div class="divider"></div>
            <p><span class="bold-element"> Email </span> : {{data_get($customerDetails, 'email')}}</p>
            <p><span class="bold-element"> Montant du dépot de garantie </span> : {{data_get($customerDetails, 'amount')}}€</p>
            <p><span class="bold-element"> Versement avec une carte bancaire se terminant par  </span> : {{data_get($customerDetails, 'lastCardNumbers')}} </p>
            <p><span class="bold-element"> Numéro de transaction </span> :  {{data_get($customerDetails, 'transactionId')}}</p>
            <form action='{{route("send-success-mail",$session)}}' method="post">
                <button class="btn" type="submit">
                    Recevoir une confirmation par mail
                </button>
            </form>
        </div>
    </body>
</html>
