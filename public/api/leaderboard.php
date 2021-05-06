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
$stmt = $con->prepare("SELECT * FROM cats ORDER BY age DESC");
$stmt->execute();
$result = $stmt->get_result();

if(!$result) {
    echo 404;
    die(mysqli_error($con));
}
else {
    $count = 0;

    while($cat_data = mysqli_fetch_array($result)) {
        $count++;  
        
        $stmt = $con->prepare("SELECT * FROM users WHERE userid=?");
        $stmt->bind_param("i", $cat_data['ownerid']);
        $stmt->execute();
        $user = $stmt->get_result();

        $user_data = mysqli_fetch_array($user);

        echo $count . '. ' . $user_data['username'] . " has a cat named " . $cat_data['name'] . " who is " . $cat_data['age'] . " days old.\n";
        
        //if($count > 10)
        //    break;
    }
}

$con->close();

?>
