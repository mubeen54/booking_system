<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pusher Test</title>
    <script src="https://cdn.jsdelivr.net/npm/pusher-js@7.0.3/dist/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.10.0/dist/echo.min.js"></script>
</head>

<body>
    <script>
        // Initialize Pusher
        Pusher.logToConsole = true;
        var pusher = new Pusher('{{ env('7ea0df4b2ffb6e754c23') }}', {
            cluster: '{{ env('ap2') }}',
            forceTLS: true
        });

        // Initialize Echo
        window.Echo = new Echo({
            broadcaster: 'pusher',
            key: '{{ env('7ea0df4b2ffb6e754c23') }}',
            cluster: '{{ env('ap2') }}',
            forceTLS: true
        });

        // Listen to the channel and event
        window.Echo.channel('bookings')
            .listen('.booking.confirmed', (e) => {
                console.log('Booking confirmed:', e);
            });
    </script>
</body>

</html>
