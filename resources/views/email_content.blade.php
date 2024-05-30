<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Payment successful</title>
</head>
<body>
    <h1>Congratulations! You successfully sent this example campaign via the Brevo API.</h1>

    <p>Here is a summary of the payment:</p>
    @foreach($data as $key => $value)
        <p><span class="bold-element">{{ $key }}</span> : {{ $value }}</p>
    @endforeach
</body>
</html>
