<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>JTGSCM | Attendance</title>
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" type="image/x-icon" href="logo.jpg">
    <style>
      @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700&display=swap");

      * {
        font-family: "Poppins", sans-serif;
        box-sizing: border-box;
        margin: 0;
        padding: 0;
      }

      body {
        width: 100%;
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #0466c9;
      }

      .main-container {
        min-width: 30%;
        height: 60%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        padding: 50px;
        background-color: white;
        border-radius: 10px;
      }

      .img-container {
        height: 30%;
        display: flex;
        justify-content: center;
        align-items: center;
      }

      .img-container img {
        width: 100px;
      }

      .main-container h1 {
        height: 20%;
        text-align: center;
      }

      .main-container form {
        height: 50%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
      }

      .main-container form input,
      button {
        padding: 10px;
        border-radius: 30px;
        border: 1px solid black;
      }

      .main-container form button {
        background-color: #0466c9;
        color: white;
        border: none;
        cursor: pointer;
      }

      @media only screen and (max-width: 767px) {
        .main-container {
          height: 50%;
          width: 80%;
          padding: 30px;
        }
      }
    </style>
  </head>
  <body>
    <div class="main-container">
      <div class="img-container"> 
        <img src="logo.jpg" alt="" />
      </div>

      <h1>Sign In</h1>
      <form action="" method="post">
        <input type="text" name="Username" placeholder="Username" />
        <input type="password" name="Password" placeholder="Password" />
        <button name="submit">Login</button>
      </form>
    </div>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
        $conn = mysqli_connect("localhost", "root", "", "barcode_attendance_system") or die("Connection Failed:" . mysqli_connect_error());

        if (isset($_POST["Username"]) && isset($_POST["Password"])) {
            $username = $_POST["Username"];
            $password = $_POST["Password"];

            $loginQuery = "SELECT * FROM `admin_account` WHERE `username` = '$username' AND `password` = '$password'";
            $result = mysqli_query($conn, $loginQuery);

            if (mysqli_num_rows($result) > 0) {
                // Login successful, redirect to dashboard.html
                header("Location: dashboard.php");
                exit();
            } else {
                // Login failed, display a JavaScript alert
                echo '<script>alert("Invalid username or password");</script>';
            }
        }

        mysqli_close($conn);
    }
    ?>

    <script src="" async defer></script>
  </body>
</html>
