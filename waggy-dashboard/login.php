<?php
session_start();

$error_message = '';
if (isset($_SESSION['error_message'])) {
    $error_message = $_SESSION['error_message'];
    unset($_SESSION['error_message']); // Clear the message after displaying
}
?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> 
    <title>Sign in</title>
    <style>
        body {
            background-image: url("../img/waggy_img.png");
            font-family: 'Ubuntu', sans-serif;
            height: 100vh;
            margin: 0;
        }

        /* Centering wrapper */
        .wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .main {
            background-color: rgba(249, 243, 236, 0.9);
            width: 350px;
            border-radius: 1.5em;
            box-shadow: 0px 11px 35px 2px rgba(0, 0, 0, 0.14);
            padding: 40px;
            text-align: center;
            position: relative;
        }

        .sign {
            color: #000;
            font-weight: bold;
            font-size: 23px;
            margin-bottom: 30px;
        }

        .un, .pass {
            width: 100%;
            color: rgb(38, 50, 56);
            font-weight: 700;
            font-size: 14px;
            letter-spacing: 1px;
            background: rgba(136, 126, 126, 0.1);
            padding: 10px 20px;
            border: none;
            border-radius: 20px;
            outline: none;
            box-sizing: border-box;
            border: 2px solid rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            transition: border-color 0.3s, background-color 0.3s, transform 0.3s;
        }

        .un:focus, .pass:focus {
            border-color: rgba(0, 0, 0, 0.3);
            background-color: rgba(249, 243, 236, 0.2);
            transform: scale(1.02);
        }

        .submit {
            cursor: pointer;
            border-radius: 5em;
            color: #fff;
            background: linear-gradient(#493628, #AB886D, #D6C0B3);
            border: 0;
            padding: 10px 40px;
            font-family: 'Ubuntu', sans-serif;
            font-size: 13px;
            box-shadow: 0 0 20px 1px rgba(0, 0, 0, 0.04);
            transition: background-color 0.3s, transform 0.2s;
        }

        .submit:hover {
            background: #493628;
            transform: scale(1.05);
        }

        .forgot {
            text-shadow: 0px 0px 3px rgba(117, 117, 117, 0.12);
            color: #E1BEE7;
            padding-top: 15px;
        }

        a {
            text-shadow: 0px 0px 3px rgba(117, 117, 117, 0.12);
            color: #E1BEE7;
            text-decoration: none;
        }

        @media (max-width: 600px) {
            .main {
                border-radius: 0px;
                width: 90%;
            }
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="main">
            <p class="sign">Admin</p>
            <form class="form1" method="POST" action="process_login.php">
                <input class="un" type="email" name="email" placeholder="Email" required>
                <input class="pass" type="password" name="password" placeholder="Password" required>
                <button type="submit" class="submit">Login</button>
            </form>
        </div>
    </div>
    <?php
    if ($error_message) {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Login Failed',
                text: '$error_message',
                confirmButtonColor: '#493628'
            });
        </script>";
    }
    ?>
</body>

</html>