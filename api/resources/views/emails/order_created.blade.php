<!DOCTYPE html>
<html>
<head>
    <title>Order Confirmation</title>
</head>
<body>
    <h1>Order Confirmation</h1>
    <p>Thank you for your order, {{ $order->customer->name }}!</p>
    <p>Order ID: {{ $order->id }}</p>
    <p>Order Total: ${{ number_format($order->total_price / 100, 2) }}</p>
    <p>We are processing your order and will update you soon.</p>
</body>
</html>
