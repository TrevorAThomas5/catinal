<?php include('secret.php');

$host = 'localhost';
$user = $USERNAME;
$password = $PASSWORD;
$dbname = 'test1';

$con = mysqli_connect($host, $user, $password, $dbname);

if(!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// user sends userid and cat name
$userid = $_GET['userid'];
$cat = $_GET['cat'];

// query cat
$stmt = $con->prepare("SELECT * FROM cats WHERE ownerid=? AND name=?");
$stmt->bind_param("is", $userid, $cat);
$stmt->execute();
$res_cat = $stmt->get_result();

// query user
$stmt = $con->prepare("SELECT * FROM users WHERE userid=?");
$stmt->bind_param("i", $userid);
$stmt->execute();
$res_user = $stmt->get_result();

// query failure check
if(!$res_cat || !$res_user) {
    echo 404;
    die(mysqli_error($con));
}
else {
    $cat_data = mysqli_fetch_array($res_cat);
    $user_data  = mysqli_fetch_array($res_user);

    $cur_date = date_create(date("Y-m-d"));
    $date = date_create($cat_data['lastpet']);
    $diff = date_diff($date, $cur_date);
   
    if($diff->format("%a") == 0) {
        // same date
        echo 404;
    } 
    else {
        // different date
        if($cat_data['happiness'] == 10) {
            echo 404;
        }
        else {
            $new_happ = $cat_data['happiness'] + 2;
            if($new_happ > 10) 
                $new_happ = 10;

            $stmt = $con->prepare("UPDATE cats SET happiness=?, lastpet=? WHERE name=? AND ownerid=?");
            $stmt->bind_param("issi", $new_happ, date("Y-m-d"), $cat, $userid);
            $stmt->execute();
            $res_user = $stmt->get_result();

            mysqli_query($con, $query);        
            echo $new_happ;
        }
    }
}

$con->close();

?>
