<?php
require_once('classes/MySQLDBConn.class.php');
$servername = "192.168.0.150";
$username = "myfriend";
$password = "System@min";
$dbname = "ijoint";

// Create connection
$conn = new MySQLDBConn($servername,$username,$password,$dbname);

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