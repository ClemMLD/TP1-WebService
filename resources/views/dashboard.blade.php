<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Récapitulatif</title>
        <style>
            body {
                font-family: "Figtree", sans-serif;
                background: #f0f2f5;
                display: flex;
                flex-direction: column;
                gap: 10px;
                align-items: center;
                padding: 20px;
                margin: 0;
            }

            h1 {
                margin-bottom: 30px;
                font-size: 24px;
                color: #333;
            }

            .cards-container {
                display: flex;
                flex-wrap: wrap;
                gap: 20px;
                justify-content: center;
                width: 100%;
            }

            .card {
                background: white;
                padding: 20px 30px;
                border-radius: 12px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                width: 100%;
                max-width: 500px;
            }

            .card.succeeded {
                border: 1px solid green;
            }

            .card.canceled {
                border:1px solid red;
            }

            .card.requires_capture {
                border: 1px solid orange;
            }

            .bold-element {
                font-weight: bold;
            }

            .divider {
                border-top: 1px solid lightgray;
                width: 100%;
                margin: 10px 0;
            }

            .solds {
                display: flex;
                gap: 20px;
                width: 100%;
                font-size: 20px;
            }

            .btn-group {
                display: flex;
                gap: 5px;
                padding: 5px;
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
        </style>
    </head>
    <body>
        <h1>Dashboard des paiements</h1>
        <div class="solds">
            <p>Solde en attente : {{$soldPending}} </p>
            <p>Solde total : {{$soldAvailable}} </p>
        </div>
        <div class="cards-container">
            @foreach($payments as $payment)
                <div class="card {{ $payment['status'] }}">
                    <p>Récapitulatif</p>
                    <p><span class="bold-element">Conducteur</span> : {{ $payment['lastname'] }} {{ $payment['firstname'] }} {{ $payment['age'] }} ans</p>
                    <p><span class="bold-element">Véhicule</span> : {{ $payment['car'] }}</p>
                    <p><span class="bold-element">Ville</span> : {{ $payment['city'] }}</p>
                    <div class="divider"></div>
                    <p><span class="bold-element">Email</span> : {{ $payment['email'] }}</p>
                    <p><span class="bold-element">Montant du dépôt de garantie</span> : {{ $payment['amount'] }}</p>
                    <p><span class="bold-element">Versement avec une carte bancaire se terminant par</span> : - {{ $payment['lastCardNumbers'] }}</p>
                    <p><span class="bold-element">Numéro de transaction</span> : {{ $payment['transactionId'] }}</p>
                    <div class="btn-group">
                        <form method="post" action="/dashboard/{{ $payment["id"]}}/refund">
                            @csrf
                            <button name="refund" type="submit" class="btn">Restituer la caution</button>
                        </form>
                        <form method="post" action="/dashboard/{{ $payment["id"]}}/capture_partials">
                            @csrf
                            <button name="capturePartial" value="{{ $payment['amount'] }}" type="submit" class="btn">Capture une partie du paiement</button>
                        </form>
                        <form method="post" action="/dashboard/{{ $payment["id"] }}/capture_full">
                            @csrf
                            <button name="captureFull" type="submit" class="btn">Capturer l'intégralité du paiement</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </body>
</html>
