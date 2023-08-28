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
            padding: 0px;
        }

        input[type="text"],
        input[type="phone"],
        input[type="email"],
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

        .text-danger {
            color: rgb(172, 105, 105);
            font-family: Arial, Helvetica, sans-serif
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
</head>

<body>
    <div class="container">
        <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <h2 style="text-align: center">User Form</h2>
            <div class="container">
                <div class="form-group">
                    <label for="name"><b>Name</b></label>
                    <input type="text" placeholder="Enter Name" name="name">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="phone"><b>Phone</b></label>
                    <input type="phone" placeholder="Enter phone" name="phone">
                    @error('phone')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="email"><b>Email</b></label>
                    <input type="email" placeholder="Enter Email" name="email" autocomplete="username">
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="address"><b>Address</b></label>
                    <input type="text" placeholder="Enter Address" name="address">
                    @error('address')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit">Submit</button>
            </div>
        </form>
    </div>
    <script>
        @if (session('success'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.success("{{ session('success') }}");
        @endif
    </script>

</body>

</html>
