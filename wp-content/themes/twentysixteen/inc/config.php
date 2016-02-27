<?php 
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "wordpress_1";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
     die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT ID, user_login FROM wp_users";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
     // output data of each row
     while($row = $result->fetch_assoc()) {
         echo "<br> id: ". $row["ID"]. " - Name: ". $row["user_login"].  "<br>";
     }
} else {
     echo "0 results";
}

$conn->close(); 






/** The name of the database for WordPress */
define('DB_NAME', 'wordpress_1');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');


echo "<br> DB_NAME " . DB_NAME;
echo "<br> DB_USER " . DB_USER;
echo "<br> DB_PASSWORD " . DB_PASSWORD;
echo "<br> DB_HOST " . DB_HOST;
echo "<br> DB_CHARSET " . DB_CHARSET;
echo "<br> DB_COLLATE " . DB_COLLATE;  


echo "<br><br><br><br>";

?>