<?php include('secret.php');

$host = 'localhost';
$user = $USERNAME;
$password = $PASSWORD;
$dbname = 'test1';

$con = mysqli_connect($host, $user, $password, $dbname);

if(!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// construct query
$username = $_GET['username'];
$password = $_GET['password'];
$cat = $_GET['catname'];

$stmt = $con->prepare("SELECT * FROM users WHERE username=?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

// if this username isn't taken
if(mysqli_num_rows($result) < 1) {
    
    $stmt = $con->prepare("INSERT INTO users (username, password, lastmoney, money) VALUES (?, ?, CURDATE(), 5)");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();

    $stmt = $con->prepare("SELECT * FROM users WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $response = $stmt->get_result();
    
    $ret =  mysqli_fetch_array($response);
    
    // create cat
    $stmt = $con->prepare("INSERT INTO cats (name, hunger, age, happiness, lastpet, rarity, ownerid) VALUES (?, 5, 0, 5, '2020-04-01', 0, ?)");
    $stmt->bind_param("si", $cat, $ret['userid']);
    $stmt->execute();

    echo json_encode($ret); 
}
else {
    // this username is already taken
    echo 404;
    die(mysqli_error($con));
}

$con->close();

?>
