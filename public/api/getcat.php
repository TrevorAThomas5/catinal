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
$userid = $_GET['userid'];

$stmt = $con->prepare("SELECT * FROM cats WHERE ownerid=?");
$stmt->bind_param('i', $userid);
$stmt->execute();
$result = $stmt->get_result();

if(!$result) {
    echo 404;
    die(mysqli_error($con));
}
else {
    $data = mysqli_fetch_array($result);
    
    if($data)
        echo json_encode($data);
    else
        echo 404;
}

$con->close();

?>
