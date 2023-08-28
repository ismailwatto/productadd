<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap/dist/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <title>Order Form</title>
    <style>
        .itemItem {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            margin-bottom: 10px;
        }

        .itemItem label {
            position: relative;
            top: 50%;
            transform: translateY(-100%);
            left: 100px;
            /* Center the label horizontally */
            transform: translate(50%, );
            /* Adjust horizontal and vertical positioning */
        }

        .itemItem select,
        .itemItem input[type="number"],
        .itemItem input[type="text"] {
            flex: 1;
            width: 100%;
            margin-right: 10px;
        }

        .additem {
            flex: 0 0 auto;
        }
    </style>
</head>
{{-- <div class="mapouter"><div class="gmap_canvas"><iframe width="100%" height="50%" id="gmap_canvas" src="https://maps.google.com/maps?q=eazisols&t=&z=10&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe><a href="https://2yu.co"></a><br><style>.mapouter{position:relative;text-align:right;height:100%px;width:100%px;}</style><a href="https://embedgooglemap.2yu.co"></a><style>.gmap_canvas {overflow:hidden;background:none!important;height:100%px;width:100%px;}</style></div></div> --}}

<body>
    @if ($errors->any())
        <div class="alert alert-danger mt-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="container mt-5">
        <h1 class="mb-4 text-center">Order Form</h1>
        <form action="{{ route('order.update', ['id' => $order->id]) }}" method="POST" id="orderForm">
            @csrf
            <div class="col-md-6">
                <div id="userShow" class="mb-3">
                    <label for="user" class="form-label">Select User</label>
                    <select class="form-select" name="user" id="user">
                        <option disabled selected>Select User</option>
                        @foreach ($users as $userOption)
                            <option value="{{ $userOption->id }}"
                                {{ $userOption->id == $order->user_id ? 'selected' : '' }}>
                                {{ $userOption->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div id="itemSection" class="mb-3">
                <h2 class="mb-5 mt-2 text-center">Items</h2>
                @foreach ($order->items as $index => $item)
                    <div class="itemItem">
                        <select name="product_name[]" id="item_{{ $index + 1 }}">
                            <option disabled selected> Select item</option>
                            @foreach ($items as $itemOption)
                                <option quantity="{{ $itemOption->quantity }}" price="{{ $itemOption->price }}"
                                    value="{{ $itemOption->id }}" {{ $itemOption->id == $item->id ? 'selected' : '' }}>
                                    {{ $itemOption->product_name }}
                                </option>
                            @endforeach
                        </select>
                        <label for="quantity_{{ $index + 1 }}">Quantity:</label>
                        <input type="number" id="quantity_{{ $index + 1 }}" class="mb-1" name="quantity[]"
                            min="1" value="{{ $item->pivot->quantity }}" required>
                        <label for="quantity_{{ $index + 1 }}">Total_Quantity:</label>
                        <input type="number" id="total_quantity_{{ $index + 1 }}" class="mb-1"
                            name="total_quantity[]" min="1" value="{{ $item->pivot->total_quantity }}" disabled
                            required>
                        <label for="price_{{ $index + 1 }}">Price:</label>
                        <input type="number" id="price_{{ $index + 1 }}" class="mb-1" name="price[]"
                            min="1" step="1" value="{{ $item->price }}" disabled required>
                        <label for="total_price_{{ $index + 1 }}">Total_Price:</label>
                        <input type="text" id="total_price_{{ $index + 1 }}" class="mb-1" name="total_price[]"
                            value="{{ $item->pivot->total_price }}" readonly>
                        <button type="button" class="additem">+</button>
                    </div>
                @endforeach
            </div>

            <div class="mb-3">
                <button type="button" class="btn btn-primary" id="subtotalButton">Calculate Subtotal</button>
                <p class="mt-2">Subtotal: <span id="subtotalValue">$0.00</span></p>
            </div>
            <div class="mb-3 col-md-6">
                <label for="discountSelect" class="form-label">Discount:</label>
                <select class="form-select mb-2" name="discountSelect" id="discountSelect">
                    <option value="percentage">Percentage</option>
                    <option value="fixed">Fixed</option>
                </select>
                <input type="number" class="form-control" name="discountedAmount" id="discountedAmount">
                <button type="button" class="btn btn-secondary mt-2" id="applyDiscount">Apply Discount</button>
                <p class="mt-2" id="finalPrice">Final Price: $0.00</p>
            </div>
            <input type="submit" class="btn btn-success" value="Update Order">
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js" defer></script>
    <script>
        $(document).ready(function() {

            $("#user").select2();
            let itemCount = 1;
            let selectedDiscount = 0;
            const finalPriceElement = $('#finalPrice');
            const discountSelect = $('#discountSelect');
            const applyDiscount = $('#applyDiscount');
            const newUserShow = $("#newUserShow");
            const userShow = $("#userShow");

            const form = $('#orderForm');
            const itemSection = $('#itemSection');

            form.on('input', '.itemItem input', function() {
                const itemItem = $(this).closest('.itemItem');
                calculateTotal(itemItem);
            });

            itemSection.on('click', '.additem', function() {
                additemSection();
            });
            $('#item_1').on('change', function() {
                var selectedOption = $(this).find(':selected');
                var quantity = selectedOption.attr('quantity');
                var price = selectedOption.attr('price');

                $(this).siblings('input[name="quantity[]"]').attr('max', quantity);
                $(this).siblings('input[name="price[]"]').val(price);
                $(this).siblings('input[name="total_quantity[]"]').val(quantity);
                const itemItem = $(this).closest('.itemItem');
                calculateTotal(itemItem);

            });
            applyDiscount.on('click', function() {
                let discountedAmount = $("#discountedAmount").val();
                if (discountSelect.val() == 'fixed') {
                    calculateFinalPrice(true, discountedAmount);
                }
                if (discountSelect.val() == 'percentage') {
                    calculateFinalPrice(false, discountedAmount);
                }
            });

            $('#newUser').on('click', function() {
                newUserShow.toggle();
                userShow.toggle();
            });

            $('#subtotalButton').on('click', calculateSubtotal);

            function calculateFinalPrice(fixed = false, discountedAmount) {
                const subtotalAmount = parseFloat($('#subtotalValue').text());
                if (!fixed) {
                    discountedAmount = (discountedAmount / 100) * subtotalAmount
                }
                let finalPrice = (subtotalAmount - discountedAmount).toFixed(2);
                if (finalPrice < 0) {
                    finalPrice = 0;
                }
                finalPriceElement.text(`Final Price: $${finalPrice}`);
            }

            function additemSection() {
                itemCount++;

                const newitemItem = $(`
                <div class="itemItem mb-4; mt-4">
                    <select class="itemSelect" name="product_name[]"  id="items_${itemCount}">
                        <option disabled selected> Select item</option>
                        @foreach ($items as $item)
                            <option value="{{ $item->id }}" quantity={{ $item->quantity }} price={{ $item->price }}> {{ $item->product_name }} </option>
                        @endforeach
                    </select>
                    <label for="quantity_${itemCount}"></label>
                    <input type="number" id="quantity_${itemCount}" name="quantity[]" min="1" value="1" required>
                    <label for="total_quantity_${itemCount}"></label>
                    <input type="number" id="total_quantity_${itemCount}" name="total_quantity[]" min="1" value="1" disabled required>
                    <label for="price_${itemCount}"></label>
                    <input type="number" id="price_${itemCount}" name="price[]" min="0.01" step="0.01" disabled required>
                    <label for="total_price_${itemCount}"></label>
                    <input type="text" id="total_price_${itemCount}" name="total_price[]" readonly>
                    <button type="button" class="additem">+</button>
                </div>
            `);

                itemSection.append(newitemItem);
                $(`#items_${itemCount}`).on('change', function() {
                    var selectedOption = $(this).find(':selected');
                    var quantity = selectedOption.attr('quantity');
                    var price = selectedOption.attr('price');
                    $(this).siblings('input[name="quantity[]"]').attr('max', quantity);
                    $(this).siblings('input[name="price[]"]').val(price);
                    $(this).siblings('input[name="total_quantity[]"]').val(quantity);
                    const itemItem = $(this).closest('.itemItem');
                    calculateTotal(itemItem);
                });
            }

            function calculateTotal(itemItem) {
                const quantity = parseFloat(itemItem.find('input[name="quantity[]"]').val());
                const price = parseFloat(itemItem.find('input[name="price[]"]').val());
                const totalPriceElement = itemItem.find('input[name="total_price[]"]');
                if (!isNaN(quantity) && !isNaN(price)) {
                    const totalPrice = (quantity * price).toFixed(2);
                    totalPriceElement.val(totalPrice);
                } else {
                    totalPriceElement.val('');
                }

                calculateSubtotal(); // Recalculate subtotal whenever total price changes
            }

            function calculateSubtotal() {
                const itemItems = $('.itemItem');
                let subtotal = 0;

                itemItems.each(function() {
                    const totalPriceElement = $(this).find('input[name="total_price[]"]');
                    const totalPrice = parseFloat(totalPriceElement.val());

                    if (!isNaN(totalPrice)) {
                        subtotal += totalPrice;
                    }
                });

                const formattedSubtotal = subtotal.toFixed(2);
                $('#subtotalValue').text(formattedSubtotal);
            }
        });
    </script>
</body>

</html>
