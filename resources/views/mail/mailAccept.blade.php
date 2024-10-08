<!DOCTYPE html>
<html>

<head>
    <title>Подтверждение бронирования</title>
</head>

<body>
    <h1>Спасибо за бронирование, {{ $name }}!</h1>
    <p>Мы рады подтвердить ваше бронирование в нашем отеле.</p>
    <h2>Детали бронирования:</h2>
    <p>Номер бронирования: {{ $booking->id }}</p>
    <p>Дата заезда: {{ $booking->started_at }}</p>
    <p>Дата выезда: {{ $booking->finished_at }}</p>

    <p>Количество дней: {{ $booking->days }}</p>
    <p>Цена: {{ $booking->price }}</p>

    <p><a href="{{ route('book.accept.email', ['token' => $token]) }}">Подтвердить бронирование</a></p>

    <p>С уважением, hotel boking project<br>
</body>

</html>
