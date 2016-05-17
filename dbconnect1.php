<?php
$servername = "localhost";
$username = "admin";
$password = "ijoint";
$dbname = "nuntiyac_ijoint";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

/*$sql = "SELECT id, username, password FROM admin_user";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    //output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        echo "id: " . $row["id"]. " - Name: " . $row["username"]. " " . $row["password"]. "<br>";
    }
} else {
    echo "0 results";
}*/

#mysqli_close($conn);
?>