<?php
$conn = mysqli_connect("localhost", "root", "", "barcode_attendance_system") OR die("Connection Failed:" . mysqli_connect_error());

// Reset auto-increment value
$sqlResetAutoIncrement = "SET @num := 0;";
$sqlUpdateId = "UPDATE member_profile SET ID = @num := (@num+1);";
$sqlAlterAutoIncrement = "ALTER TABLE member_profile AUTO_INCREMENT = 1;";

mysqli_query($conn, $sqlResetAutoIncrement);
mysqli_query($conn, $sqlUpdateId);
mysqli_query($conn, $sqlAlterAutoIncrement);

// Retrieve data
$sqlSelectData = "SELECT * FROM `member_profile`";
$result = mysqli_query($conn, $sqlSelectData);

$data = array();

while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

echo json_encode($data);

mysqli_close($conn);
?>