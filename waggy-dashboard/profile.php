<?php
session_start();
include "includes/header.php";
require_once 'model/User.php';


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); 
    exit();
}


$user = new User();
$userDetails = $user->getUserById($_SESSION['user_id']); 

if (!$userDetails) {
    echo "Error: User details not found.";
    exit();
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
    <style>
   
   @import url(https://fonts.googleapis.com/css?family=Dancing+Script);

   * {
       margin: 0;
   }

   body {
       background-color: #e8f5ff;
       font-family: Arial;
       overflow: hidden;
   }
   .navbar-top {
       background-color: #fff;
       color: #333;
       box-shadow: 0px 4px 8px 0px grey;
       height: 70px;
   }

   .title {
       font-family: 'Dancing Script', cursive;
       padding-top: 15px;
       position: absolute;
       left: 45%;
   }

   .navbar-top ul {
       float: right;
       list-style-type: none;
       margin: 0;
       overflow: hidden;
       padding: 18px 50px 0 40px;
   }

   .navbar-top ul li {
       float: left;
   }

   .navbar-top ul li a {
       color: #333;
       padding: 14px 16px;
       text-align: center;
       text-decoration: none;
   }

   .icon-count {
       background-color: #ff0000;
       color: #fff;
       float: right;
       font-size: 11px;
       left: -25px;
       padding: 2px;
       position: relative;
   }
   .sidenav {
       background-color: #fff;
       color: #333;
       border-bottom-right-radius: 25px;
       height: 86%;
       left: 0;
       overflow-x: hidden;
       padding-top: 20px;
       position: absolute;
       top: 70px;
       width: 250px;
   }

   .profile {
       margin-bottom: 20px;
       margin-top: -12px;
       text-align: center;
   }

   .profile img {
       border-radius: 50%;
       box-shadow: 0px 0px 5px 1px grey;
   }

   .name {
       font-size: 20px;
       font-weight: bold;
       padding-top: 20px;
   }

   .job {
       font-size: 16px;
       font-weight: bold;
       padding-top: 10px;
   }

   .url,
   hr {
       text-align: center;
   }

   .url hr {
       margin-left: 20%;
       width: 60%;
   }

   .url a {
       color: #818181;
       display: block;
       font-size: 20px;
       margin: 10px 0;
       padding: 6px 8px;
       text-decoration: none;
   }

   .url a:hover,
   .url .active {
       background-color: #e8f5ff;
       border-radius: 28px;
       color: #000;
       margin-left: 14%;
       width: 65%;
   }
   .main {
       margin-top: 2%;
       margin-left: 29%;
       font-size: 28px;
       padding: 0 10px;
       width: 58%;
   }

   .main h2 {
       color: #333;
       font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
       font-size: 24px;
       margin-bottom: 10px;
   }

   .main .card {
       background-color: #fff;
       border-radius: 18px;
       box-shadow: 1px 1px 8px 0 grey;
       height: auto;
       margin-bottom: 20px;
       padding: 20px 0 20px 50px;
   }

   .main .card table {
       border: none;
       font-size: 16px;
       height: 270px;
       width: 80%;
   }

   .edit {
       position: absolute;
       color: #e7e7e8;
       right: 14%;
   }

   .social-media {
       text-align: center;
       width: 90%;
   }

   .social-media span {
       margin: 0 10px;
   }

   .fa-facebook:hover {
       color: #4267b3 !important;
   }

   .fa-twitter:hover {
       color: #1da1f2 !important;
   }

   .fa-instagram:hover {
       color: #ce2b94 !important;
   }

   .fa-invision:hover {
       color: #f83263 !important;
   }

   .fa-github:hover {
       color: #161414 !important;
   }

   .fa-whatsapp:hover {
       color: #25d366 !important;
   }

   .fa-snapchat:hover {
       color: #fffb01 !important;
   }

   /* End */
   </style>
</head>

<body>

    <div class="navbar-top">
        <div class="title">
            <h1>Profile</h1>
        </div>
    </div>
    <div class="main">
        <h2>IDENTITY</h2>
        <div class="card">
            <div class="card-body">
                <i class="fa fa-pen fa-xs edit"></i>
                <table>
                    <tbody>
                        <tr>
                            <td>Name</td>
                            <td>:</td>
                            <td><?= htmlspecialchars($userDetails['user_first_name']) . ' ' . htmlspecialchars($userDetails['user_last_name']) ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>:</td>
                            <td><?= htmlspecialchars($userDetails['user_email']) ?></td>
                        </tr>
                        <tr>
                            <td>Address</td>
                            <td>:</td>
                            <td><?= htmlspecialchars($userDetails['user_address_line_one']) ?></td>
                        </tr>
                        <tr>
                            <td>Phone</td>
                            <td>:</td>
                            <td><?= htmlspecialchars($userDetails['user_phone_number']) ?></td>
                        </tr>
                        <tr>
                            <td>Role</td>
                            <td>:</td>
                            <td><?= htmlspecialchars($userDetails['user_role']) ?></td>
                        </tr>
                        <tr>
                            <td>Birth Date</td>
                            <td>:</td>
                            <td><?= htmlspecialchars($userDetails['user_birth_of_date']) ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.php">Logout</a>
                </div>
            </div>
        </div>
    </div>
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
    <script src="js/modal.js"></script>
</body>

</html>