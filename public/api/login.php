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

$stmt = $con->prepare("SELECT * FROM users WHERE username=? AND password=?");
$stmt->bind_param("ss", $username, $password);
$stmt->execute();
$result = $stmt->get_result();

if(!$result) {
    echo 404;
    die(mysqli_error($con));
}
else {
    $data = mysqli_fetch_array($result);
    
    if($data) {
        $cur_date = date_create(date("Y-m-d"));
        $date = date_create($data['lastmoney']);
        $diff = date_diff($date, $cur_date); 
 
        // determine if the user earned money or not
        if($diff->format("%a") != 0) {
            $new_money = $data['money'] + 3;

            $stmt = $con->prepare("UPDATE users SET money=?, lastmoney=? WHERE userid=?");
            $stmt->bind_param("isi", $new_money, date("Y-M-d"), $data['userid']);
            $stmt->execute();

            // the cat is now older, more hungry, and less happy
            $stmt = $con->prepare("SELECT * FROM cats WHERE ownerid=?");
            $stmt->bind_param("i", $data['userid']);
            $stmt->execute();
            $res = $stmt->get_result();
            
            $cat = mysqli_fetch_array($res);
            $new_age = $cat['age'] + $diff->format("%a");
            $new_hunger = $cat['hunger'] - $diff->format("%a");
            $new_happiness = $cat['happiness'] - $diff->format("%a");
            
            $stmt = $con->prepare("UPDATE cats SET age=?, hunger=?, happiness=? WHERE name=?");
            $stmt->bind_param("iiis", $new_age, $new_hunger, $new_happiness, $cat['name']);
            $stmt->execute();

            $data['money'] = $new_money;
            echo json_encode($data);
        }
        else {
            echo json_encode($data);
        } 
    }
    else {
        echo 404;
    }
}

$con->close();

?>
