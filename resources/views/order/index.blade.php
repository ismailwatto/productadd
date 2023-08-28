<!DOCTYPE html>
<html>

<head>
    <title>Orders List</title>
    <!-- Add Bootstrap CSS link here -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-4">
        <h1 class="text-center">Orders List</h1>
        <table class="table mt-3">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer Name</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total Price</th>
                    <th>Subtotal</th>
                    <th>Discount Type</th>
                    <th>Discounted Amount</th>
                    <th>Final Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    @foreach ($order->items as $index => $item)
                        <tr>
                            @if ($index === 0)
                                <td rowspan="{{ count($order->items) }}">{{ $order->id }}</td>
                                <td rowspan="{{ count($order->items) }}">{{ $order->user->name }}</td>
                            @endif
                            <td>{{ $item->product_name }}</td>
                            <td>{{ $item->pivot->quantity }}</td>
                            <td>{{ $item->price }}</td>
                            <td>{{ $item->pivot->total_price }}</td>
                            @if ($index === 0)
                                <td rowspan="{{ count($order->items) }}">{{ $order->sub_total }}</td>
                                <td rowspan="{{ count($order->items) }}">{{ $order->discount_type }}</td>
                                <td rowspan="{{ count($order->items) }}">{{ $order->discounted_amount }}</td>
                                <td rowspan="{{ count($order->items) }}">{{ $order->final_price }}</td>
                                <td rowspan="{{ count($order->items) }}">
                                    <a href="#"
                                        onclick="confirmDelete('{{ route('order.destroy', $order->id) }}')"
                                        class="btn btn-danger">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                    <a href="{{ route('order.edit', $order->id) }}" class="btn btn-success">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- Add Bootstrap JS and jQuery scripts here if needed -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
<script>
    function confirmDelete(url) {
        if (confirm('Are you sure you want to delete this order?')) {
            window.location.href = url;
        }
    }
</script>

</html>
