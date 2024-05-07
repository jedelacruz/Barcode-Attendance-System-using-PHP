<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>JTGSCM | Attendance</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="logo.jpg">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700&display=swap');

        * {
            font-family: 'Poppins', sans-serif;
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #0466C9;
            height: 10vh;
            width: 100%;
            padding: 50px 10px;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
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
        @media only screen and (max-width: 767px) {
            header{
                height: 15vh;
                font-size: 13px;
            }
            .main-container{
                padding-top: 5vh;
                padding-bottom: 5vh;
            }
        }

    </style>
</head>

<body>

    <header>
        <h1>Jesus The Good Sheperd Church Of Muntinlupa</h1>
        <p>Barcode Attendance System</p>
    </header>

    <div class="main-container">
        <section id="main">
            <table id="userTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Barcode ID</th>
                        <th>User Image</th>
                        <th>Full Name</th>
                        <th>Date</th>
                        <th>Time</th>
                    </tr>
                </thead>
                <tbody>
                
                </tbody>
            </table>
        </section>
    </div>


    <script src="" async defer></script>
    <script>
            $(document).ready(function () {
                // Function to fetch data from the server and append rows to the table
                function fetchData() {
                    $.ajax({
                        type: "GET",
                        url: "getAttendances.php",
                        dataType: "json",
                        success: function (data) {
                            // Clear existing table rows
                            $("#userTable tbody").empty();

                            // Append new rows with fetched data
                            $.each(data, function (index, row) {
                                $("#userTable tbody").append(
                                    "<tr>" +
                                    "<td>" + row.id + "</td>" +
                                    "<td>" + row.barcodeId + "</td>" +
                                    "<td><img width=150 height=150 src='" + row.userImage + "'></td>" +
                                    "<td>" + row.fullName + "</td>" +
                                    "<td>" + row.date + "</td>" +
                                    "<td>" + row.time + "</td>" +
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