<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login Form</title>
    <style>
        body {
            background-color: #f5f5f5;
            font-family: sans-serif;
        }
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .card {
            background-color: #ffffff;
            box-shadow: 0px 3px 15px rgba(0, 0, 0, 0.2);
            border-radius: 8px;
            overflow: hidden;
            width: 360px;
        }
        .card-header {
            background-color: #4285F4;
            color: #ffffff;
            padding: 24px;
            text-align: center;
        }
        .card-body {
            padding: 24px;
        }
        .form-group {
            margin-bottom: 16px;
        }
        .form-label {
            display: block;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 8px;
        }
        .form-control {
            border: none;
            border-radius: 4px;
            box-shadow: 0px 3px 15px rgba(0, 0, 0, 0.2);
            padding: 16px;
            width: 80%;
        }
        .form-control:focus {
            outline: none;
            box-shadow: 0px 0px 0px 3px rgba(66, 133, 244, 0.5);
        }
        .btn {
            background-color: #4285F4;
            border: none;
            border-radius: 4px;
            color: #ffffff;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
            padding: 16px;
            transition: all 0.2s ease-in-out;
            width: 100%;
        }
        .btn:hover {
            background-color: #3367D6;
        }
        .btn:active {
            background-color: #2A56C6;
            transform: translateY(2px);
        }
        .alert {
            background-color: #F44336;
            border-radius: 4px;
            color: #ffffff;
            margin-bottom: 16px;
            padding: 16px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h1>Login</h1>
            </div>
            <div class="card-body">
                <form action="login.php" method="post">
                    <div class="form-group">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" id="username" name="username" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn">Login</button>
                    
                    <label >Error al iniciar seccion</label>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

               
