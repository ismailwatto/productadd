<!DOCTYPE html>
<html>
<head>
    <title>User Create</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
        }

        form {
            border: 2px solid #00ffff;
            background: linear-gradient(to right, chartreuse, gray);
            margin: 10px auto;
            border-top-right-radius: 60px;
            border-bottom-left-radius: 60px;
            max-width: 500px;
            padding:0px;
        }

        input[type="text"],
        input[type="price"],
        input[type="quantity"],
        input[type="password"] {
            width: 100%;
            padding: 8px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        button {
            background-color: black;
            color: white;
            padding: 8px 20px;
            margin: 8px auto;
            display: block;
            border: none;
            cursor: pointer;
            width: 40%;
        }

        button:hover {
            opacity: 0.8;
        }

        .container {
            padding: 15px;
        }

        @media screen and (max-width: 300px) {
            span.psw {
                display: block;
                float: none;
            }

            .cancelbtn {
                width: 100%;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <form action="{{ route('item.update', ['id' => $item->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf    
    <h2 style="text-align: center">Update Product Form</h2>
        <div class="container">
            <label for="product_name"><b>Product_Name</b></label>
            <input type="text" placeholder="Enter product_name" name="product_name" value="{{ $item->product_name }}" required>

            <label for="quantity"><b>Product_Quantity</b></label>
            <input type="quantity" placeholder="Enter Product_Quantity" name="quantity" autocomplete="quantity" value="{{ $item->quantity }}" required>


            <label for="price"><b>Product_Price</b></label>
            <input type="price" placeholder="Enter Product_Price" name="price" value="{{ $item->price }}" required>
            
            <button type="submit">Update Product</button>
        </div>
    </form>
</div>
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

</body>
</html>
