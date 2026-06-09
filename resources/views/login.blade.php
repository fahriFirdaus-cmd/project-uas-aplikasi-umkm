<!DOCTYPE html>
<html>
<head>
    <title>Login UMKM</title>

    <style>

        body{
            font-family: Arial;
            background: #f5f5f5;
        }

        .login-box{
            width: 350px;
            background: white;
            padding: 30px;
            margin: 100px auto;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
        }

        h2{
            text-align: center;
        }

        input{
            width: 100%;
            padding: 10px;
            margin-top: 10px;
        }

        button{
            width: 100%;
            padding: 10px;
            margin-top: 20px;
            background: #3498db;
            color: white;
            border: none;
            border-radius: 5px;
        }

    </style>

</head>
<body>

<div class="login-box">

    <h2>Login UMKM</h2>

    <form action="/login" method="POST">

        @csrf

        <input type="text" name="username" placeholder="Username">

        <input type="password" name="password" placeholder="Password">

        <button type="submit">
            Login
        </button>

    </form>

</div>

</body>
</html>