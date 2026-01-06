<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>

    <style>
        body {
    font-family: Arial, sans-serif;
    background: linear-gradient(135deg, #E8E3D6, #C5D4C8);
    padding: 20px;
    margin: 0;
}

        h3 {
            text-align: center;
            color: #4a4a4a;
            margin-bottom: 25px;
            font-weight: 600;
        }

        .container {
            background:white;
            width: 400px;
            margin: 80px auto;
            padding: 35px 40px;
            border-radius: 18px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.12);
            border: 2px solid #E8E3D6;
        }

        label {
            display: block;
            margin-top: 15px;
            margin-bottom: 6px;
            font-size: 14px;
            font-weight:bold;
            color: #4a4a4a;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px 12px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 14px;
            box-sizing: border-box;
        }

        .btn.login { 
            background: #f5ead7ff;
            border: 1px solid #f4cfb8ff;
            color: #4a4a4a;
            padding: 10px 25px;
            border-radius: 8px;
            font-size: 14px;
            font-weight:bold;
            cursor: pointer;
            margin-top: 25px;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        .btn.login:hover {
            background: #b8c0c3;
        }
    </style>
</head>

<body>

    <div class="container">
        <h3>Hello, Admin!</h3>

        <form action="" method="POST">
            <label for="username">Username</label>
            <input type="text" name="username" id="username">

            <label for="password">Password</label>
            <input type="password" name="password" id="password">

            <input type="submit" name="LoginSub" value="Login" class="btn login">
        </form>
    </div>

</body>
</html>
