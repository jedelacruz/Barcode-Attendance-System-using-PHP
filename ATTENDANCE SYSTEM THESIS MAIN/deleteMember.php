<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["deleteUser"])) {
    $conn = mysqli_connect("localhost", "root", "", "barcode_attendance_system") or die("Connection Failed:" . mysqli_connect_error());

    $barcodeIdToDelete = $_POST["deleteUser"];
    if ($barcodeIdToDelete != "") {
        // Check if the user with the given barcodeID exists
        $checkUserQuery = mysqli_query($conn, "SELECT * FROM `member_profile` WHERE `barcodeId` = '$barcodeIdToDelete'");
        
        if (mysqli_num_rows($checkUserQuery) > 0) {
            // User exists, proceed with deletion
            $deleteUserQuery = mysqli_query($conn, "DELETE FROM `member_profile` WHERE `barcodeId` = '$barcodeIdToDelete'");
            
            if ($deleteUserQuery) {
                // User deleted successfully
                echo "<script>alert('User deleted successfully!');</script>";
            } else {
                // Error deleting user
                echo "<script>alert('Error deleting user.');</script>";
            }
        } else {
            // User with given barcodeID not found
            echo "<script>alert('User with barcodeID `$barcodeIdToDelete` not found in the database');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <link rel="icon" type="image/x-icon" href="logo.jpg">
        <style>
            @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700&display=swap");

* {
  font-family: "Poppins", sans-serif;
  box-sizing: border-box;
  margin: 0;
  padding: 0;
}

header {
    background-color: #0466c9;
    height: 10vh;
    width: 100%;
    padding: 50px 10px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    text-align: center;
    color: white;
    position: fixed;    
}

nav{
    height: 10vh;
    padding: 50px 10px;
    min-width: 5vw;
    position: fixed;
    top: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 20;
}

body{
    background-color: whitesmoke;
    width: 100vw;
}

nav i{
    font-size: 25px;
    cursor: pointer;
    padding: 15px;
    border-radius: 50%;
    z-index: 2;
    color: white;
}

nav i:hover{
    background-color: rgba(4, 90, 201, 0.7); 
}

#open-sidebar{
    display: none;
}

.sidebar{
    min-width: 15vw;
    height: 100vh;
    position: fixed;
    top: 0;
    left: 0;
    background-color: #0466c9; 
    padding: 0px 25px;
    color: white;
}

.sidebar-logo{
    margin-top: 15vh;
    margin-bottom: 20px;
}

.sidebar-navLinks{
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.sidebar-navLinks a{
    color: white;
    text-decoration: none;
    padding: 5px 10px;
    border-radius: 5px  ;
}

.sidebar-navLinks a:hover{
    text-decoration: underline;
}

.activeLink{
    background-color: #0456c9;
}

.main-container {
    width: 100%;
    display: flex;
    justify-content: center;
    padding-top: 20vh;
    padding-bottom: 10vh;

}

form button{
    width: 7.5%;
    padding: 10px;
    cursor: pointer;
    background: crimson;
    border: none;
    color: white;
    border: 1px solid black;
  }
  form button:hover{
    opacity: 0.9;
  }
  form button:active{
    opacity: 0.7;
  }

#main {
    width: 80%;
    overflow-x:auto;
}

#main form input{
    padding: 10px;
    width: 50%;
    border: 1px solid black;
    margin-bottom: 5vh;
}

#main table {
    width: 100%;
    border-collapse: collapse;
    border: 1px solid black;
}

#main table td,
th,
tr {
    border: 1px solid black;
    padding: 5px;
    text-align: center;
}

@media only screen and (max-width: 767px) {
    header{
        height: 15vh;
        font-size: 13px;
    }
    form button{
        width: 20%;
    }
}
        </style>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>
    <body>
        
        <header>
            <h1>Jesus The Good Sheperd Church Of Muntinlupa</h1>
            <p>Admin | Dashboard</p>
        </header>

        <nav>
            <i id="open-sidebar" class="fa-solid fa-bars"></i>
            <i id="close-sidebar" class="fa-solid fa-xmark"></i>
        </nav>

        <div class="sidebar" id="sidebarMenu">
            <div class="sidebar-logo">
                <h3>JTGSCM | Admin</h3>
            </div>
            <div class="sidebar-navLinks">
                <a href="dashboard.php">Attendance</a>
                <a href="checkProfiles.html">Check Profiles</a>
                <a href="addMember.php">Add Member</a>
                <a href="#" class="activeLink">Delete Member</a>
                <a href="report.php">Reports</a>
                <a href="index.php">Logout</a>
            </div>
        </div>

        <div class="main-container">
            <section id="main">
                <form action="" method="POST">
                    <h3>Enter Barcode ID</h3>
                    <input type="text" placeholder="Scan or Type the Barcode" name="deleteUser">
                    <button>Delete</button>
                </form>
                <table id="userTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Barcode Image</th>
                            <th>Barcode ID</th>
                            <th>User Image</th>
                            <th>Full Name</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </section>
        </div>

        
        <script>
            const sidebar = document.querySelector("#sidebarMenu")
            const openBtn = document.querySelector("#open-sidebar")
            const closeBtn = document.querySelector("#close-sidebar")

            openBtn.addEventListener("click", function(){
                sidebar.style.left = "0vw";
                openBtn.style.color = "white";
                openBtn.style.display = "none"
                closeBtn.style.display = "block"
            })


            closeBtn.addEventListener("click", function(){
                sidebar.style.left = "-100vw";
                openBtn.style.display = "block";
                closeBtn.style.display = "none";
                openBtn.style.color = "white"
            })
        </script>
        <script>
            $(document).ready(function () {
                // Function to fetch data from the server and append rows to the table
                function fetchData() {
                    $.ajax({
                        type: "GET",
                        url: "getProfiles.php",
                        dataType: "json",
                        success: function (data) {
                            // Clear existing table rows
                            $("#userTable tbody").empty();

                            // Append new rows with fetched data
                            $.each(data, function (index, row) {
                                $("#userTable tbody").append(
                                    "<tr>" +
                                    "<td>" + row.id + "</td>" +
                                    "<td><img src='" + row.barcodeImage + "'></td>" +
                                    "<td>" + row.barcodeId + "</td>" +
                                    "<td><img width=150 height=150 src='" + row.userImage + "'></td>" +
                                    "<td>" + row.fullName + "</td>" +
                                    "</tr>"
                                );
                            });
                        },
                        error: function () {
                            console.log("Error fetching data");
                        }
                    });
                }

                // Call the fetchData function when the page loads
                fetchData();
            }); 
        </script>
    </body>
</html>