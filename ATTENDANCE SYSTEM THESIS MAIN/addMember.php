<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $BarcodePath   = isset($_POST["barcodeImage"])       ? $_POST["barcodeImage"]           : "";
    $BarcodeID     = isset($_POST["barcodeId"])          ? $_POST["barcodeId"]              : "";
    $Image         = isset($_FILES["userImage"]["name"]) ? $_FILES["userImage"]["name"] : "placeholderImage.png";
    $FullName      = isset($_POST["fullName"])           ? $_POST["fullName"]               : "";
    $Email         = isset($_POST["email"])              ? $_POST["email"]                  : "";
    $ContactNumber = isset($_POST["contactNo"])          ? $_POST["contactNo"]              : "";
    $Address       = isset($_POST["address"])            ? $_POST["address"]                : "";
    $ImagePath = "http://localhost/ATTENDANCE%20SYSTEM%20THESIS%20MAIN/userProfileUploads/$Image";
    

    // Check if Barcode ID already exists
    if ($BarcodePath != "") {
        $Connection = mysqli_connect("localhost", "root", "", "barcode_attendance_system") OR die("Connection Failed:" . mysqli_connect_error());
        $CheckSQL = "SELECT COUNT(*) FROM `member_profile` WHERE `barcodeId` = ?";
        $CheckSTMT = mysqli_prepare($Connection, $CheckSQL);
        mysqli_stmt_bind_param($CheckSTMT, "s", $BarcodeID);
        mysqli_stmt_execute($CheckSTMT);
        mysqli_stmt_bind_result($CheckSTMT, $count);
        mysqli_stmt_fetch($CheckSTMT);
        mysqli_stmt_close($CheckSTMT);

        // ...

        if ($count > 0) {
            mysqli_close($Connection);
            echo 'BarcodeIDTaken';
            exit; // Stop further execution
        }
        
        // Insert the data if Barcode ID is not taken
        $SQL = "INSERT INTO `member_profile`(`barcodeImage`, `barcodeId`, `userImage`, `fullName`, `email`, `contactNo`, `address`) VALUES(?, ?, ?, ?, ?, ?, ?)";
        $STMT = mysqli_prepare($Connection, $SQL);
        mysqli_stmt_bind_param($STMT, "sssssss", $BarcodePath, $BarcodeID, $ImagePath, $FullName, $Email, $ContactNumber, $Address);
        $Query = mysqli_stmt_execute($STMT);
        mysqli_stmt_close($STMT);
        mysqli_close($Connection);
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
        <link rel="stylesheet" href="addMember.css">
        <link rel="icon" type="image/x-icon" href="logo.jpg">
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
                <a href="#" class="activeLink">Add Member</a>
                <a href="deleteMember.php">Delete Member</a>
                <a href="report.php">Reports</a>
                <a href="index.php">Logout</a>
            </div>
        </div>

        <div class="main-container">
            <div id="main">
                <form id="Form" action="addMember.php" method="POST" enctype="multipart/form-data">
                    <div class="profileImg-container">
                        <img src="placeholderImage.png" id="userImage" alt="profile">
                        <input type="file" id="chooseImage" name="userImage">
                    </div>

                    <input type="text" placeholder="Barcode ID" name="barcodeInput" id="barcodeInput">
                    <input type="text" placeholder="Full Name" id="FullName">
                    <input type="text" placeholder="Email" id="E-Mail">
                    <input type="text" placeholder="Contact Number" id="ContactNumber">
                    <input type="text" placeholder="Address" id="Address">
                    <h3>Generated Barcode:</h3>

                    <div class="barcodeImg-container">
                        <img id="Barcode">
                    </div>
                    
                    <div class="button-container">
                        <button id="GenerateBarcode">
                            Generate
                        </button>
                        <button id="Save">
                            Save
                        </button>
                        <button id="ClearAll">
                            Clear All
                        </button>
                    </div>
                </form>
            </div>
        </div>

        

        <script src="JsBarcode.all.min.js"></script>
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

            const chooseImage = document.getElementById("chooseImage");
            const userImage = document.getElementById("userImage");
        
            chooseImage.addEventListener("change", function() {
            if (chooseImage.files.length > 0) {
                userImage.src = URL.createObjectURL(chooseImage.files[0]);
            } else {
                userImage.src = "placeholderImage.png";
            }
            });

            const GenerateBarcode = document.getElementById("GenerateBarcode");
            GenerateBarcode.addEventListener("click", function(event) {
            event.preventDefault();
            const ID = document.getElementById("barcodeInput").value;
            if (!ID.trim()) {
                alert("Enter a Barcode ID before generating.");
            } else {
                try {
                    JsBarcode("#Barcode", ID);
                } catch (error) {
                    console.error("Barcode generation error:", error);
                    alert("Error generating barcode. Please check the console for details.");
                }
            }
            });

            const Save = document.getElementById("Save");
Save.addEventListener("click", function(Event) {
    Event.preventDefault();
    const Form = document.getElementById("Form");
    const Barcode = document.getElementById("Barcode");
    const ID = document.getElementById("barcodeInput").value;
    const FullName = document.getElementById("FullName").value;
    const Email = document.getElementById("E-Mail").value;
    const ContactNumber = document.getElementById("ContactNumber").value;
    const Address = document.getElementById("Address").value;
    const Prompt = Form.querySelector("p");  
                if (!ID.trim() || !FullName.trim() || !Email.trim() || !ContactNumber.trim() || !Address.trim()) {
                    if (!Prompt) {
                        Form.insertAdjacentHTML("beforeend", "<p id=\"Error\">Fill out the missing fields.</p>");
                        return;
                    } else {
                        Prompt.parentNode.removeChild(Prompt);
                        Form.insertAdjacentHTML("beforeend", "<p id=\"Error\">Fill out the missing fields.</p>");
                        return;
                    }
                } else {
                    if (Prompt) {
                        Prompt.parentNode.removeChild(Prompt);
                    }
                    if (Barcode.src == "") {
                        Form.insertAdjacentHTML("beforeend", "<p id=\"Error\">Generate a barcode before saving.</p>");
                        return;
                    } 
                }
                const Data = new FormData();
                Data.append("barcodeImage", Barcode.src);
                Data.append("barcodeId", ID);   
                Data.append("userImage", chooseImage.files[0]);
                Data.append("fullName", FullName);
                Data.append("email", Email);
                Data.append("contactNo", ContactNumber);
                Data.append("address", Address);
                fetch("addMember.php", {
        method: "POST",
        body: Data,
    })
    .then(Response => Response.text())
    .then(Data => {
        if (Data.trim() === "BarcodeIDTaken") {
            alert("Barcode ID is already taken.");
        } else {
            console.log(Data);
            alert("User added successfully!");
        }
    })
    .catch(Error => {
        console.error("There was a problem with the fetch operation:", Error);
    });
});
         
            const clearAll = document.getElementById("ClearAll");
                clearAll.addEventListener("click", function() {
                const ID = document.getElementById("barcodeInput").value;
                const FullName = document.getElementById("FullName").value;
                const Email = document.getElementById("E-Mail").value;
                const ContactNumber = document.getElementById("ContactNumber").value;
                const Address = document.getElementById("Address").value;
                ID = "";
                FullName = "";
                Email = "";
                ContactNumber = "";
                Address = "";
                userImage.src = "placeholderImage.png";
            })

        </script>
    </body>
</html>