<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>JTGSCM | Attendance</title>
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" type="image/x-icon" href="logo.jpg">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
    position: absolute;
    top: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    position: fixed;
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
    position: absolute;
    top: 0;
    left: 0;
    background-color: #0466c9; 
    padding: 0px 25px;
    color: white;
    position: fixed;
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
    padding-top: 10vh;
    padding-bottom: 10vh;

}

#main {
    width: 80%;
    overflow-x:auto;
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

.totalAttendeesContainer{
    margin-top: 10vh;
    padding: 20px;
    border-radius: 20px;
    background-color: white;
    width: 50%;
    display: flex;
    justify-content: center;
    flex-direction: column;
    align-items: center;
    margin-bottom: 5vh;
}

.totalAttendeesContainer span{
    color: #0456c9;
    font-size: 30px;
}

.recentAttend{
    margin: 2vh 0vw;
}

@media only screen and (max-width: 767px) {
    header{
        height: 15vh;
        font-size: 13px;
    }
    .totalAttendeesContainer{
        width: 100%;
        text-align: center;
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
                <a href="deleteMember.php">Delete Member</a>
                <a href="#" class="activeLink">Report</a>
                <a href="index.php">Logout</a>
            </div>
        </div>

        <div class="main-container">
            <section id="main">
                
            <?php
            $con = mysqli_connect("localhost", "root", "", "barcode_attendance_system");

            // Get total attendees for the month
            $sqlTotalAttendees = "SELECT COUNT(*) AS row_count FROM attendance WHERE MONTH(date) = MONTH(CURRENT_DATE()) AND YEAR(date) = YEAR(CURRENT_DATE())";
            $resultTotalAttendees = $con->query($sqlTotalAttendees);
            if ($resultTotalAttendees->num_rows > 0) {
                $rowTotalAttendees = $resultTotalAttendees->fetch_assoc();
                $totalAttendees = $rowTotalAttendees['row_count'];
            }

            // Get recent attendees
            $query = "SELECT * FROM attendance ORDER BY id DESC LIMIT 1000";
            $query_run = mysqli_query($con, $query);

            ?>
            <div class="totalAttendeesContainer">
                <h1>Total Attendees This Month</h1>
                <span id="attendeesNumber"><?= $totalAttendees; ?></span>
            </div>

            <h1 class="recentAttend">Recent Attendees</h1>
            <table id="userTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User Image</th>
                        <th>Full Name</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($query_run) > 0) {
                        foreach ($query_run as $row) {
                            // Determine the status based on attendance
                            $status = "";
                            $lastAttendanceDate = strtotime($row['date']);
                            $currentDate = strtotime(date('Y-m-d'));

                            if ($currentDate - $lastAttendanceDate <= 30 * 24 * 60 * 60) {
                                $status = "green"; // Attended at least once a month
                            } elseif ($currentDate - $lastAttendanceDate > 30 * 24 * 60 * 60 && $currentDate - $lastAttendanceDate <= 60 * 24 * 60 * 60) {
                                $status = "yellow"; // Hasn't attended for a month
                            } else {
                                $status = "red"; // Hasn't attended for more than a month
                            }

                            ?>
                            <tr>
                                <td><?= $row['id']; ?></td>
                                <td><img width=150 height=150 src='<?= $row['userImage']; ?>'></td>
                                <td><?= $row['fullName']; ?></td>
                                <td style="color: <?= $status; ?>;"><?= ucfirst($status); ?></td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
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
    </body>
</html>