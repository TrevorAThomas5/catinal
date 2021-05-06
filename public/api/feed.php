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
$food = $_GET['food'];

// query cat
$stmt = $con->prepare("SELECT * FROM cats WHERE ownerid=? AND name=?");
$stmt->bind_param('is', $userid, $cat);
$stmt->execute();
$res_cat = $stmt->get_result();

// query user
$stmt = $con->prepare("SELECT * FROM users WHERE userid=?");
$stmt->bind_param('i', $userid);
$stmt->execute();
$res_user = $stmt->get_result();

// query failure check
if(!$res_cat || !$res_user) {
    echo 404;
    die(mysqli_error($con));
}
else {
    $user_data = mysqli_fetch_array($res_user);
    $cat_data = mysqli_fetch_array($res_cat);

    $money = $user_data['money'];
    
     switch($food) {
        case 1:
            if($money >= 1 && $cat_data['hunger'] < 10) {
                $new_hunger = $cat_data['hunger'] + 1;
                $new_money = $money - 1;

                $stmt = $con->prepare("UPDATE cats SET hunger=? WHERE name=? AND ownerid=?");
                $stmt->bind_param('isi', $new_hunger, $cat, $userid);
                $stmt->execute();

                $stmt = $con->prepare("UPDATE users SET money=? WHERE userid=?");
                $stmt->bind_param('ii', $new_money, $userid);
                $stmt->execute();
                
                $obj->hunger = $new_hunger;
                $obj->money = $new_money;
                echo json_encode($obj);
            }
            else {
                $ret = ($money < 1) ? 405 : 404;
                echo $ret;
            }
            break;
        case 2:
            if($money >= 2 && $cat_data['hunger'] < 10) {
                $new_hunger = $cat_data['hunger'] + 3;
                $new_money = $money - 2;
            
                if($new_hunger > 10)
                    $new_hunger = 10;
                
                $stmt = $con->prepare("UPDATE cats SET hunger=? WHERE name=? AND ownerid=?");
                $stmt->bind_param('isi', $new_hunger, $cat, $userid);
                $stmt->execute();

                $stmt = $con->prepare("UPDATE users SET money=? WHERE userid=?");
                $stmt->bind_param('ii', $new_money, $userid);
                $stmt->execute();
                
                $obj->hunger = $new_hunger;
                $obj->money = $new_money;
                echo json_encode($obj);
            }
            else {
                $ret = ($money < 2) ? 405 : 404;
                echo $ret;
            }
            break;
        case 3:
            if($money >= 5 && $cat_data['hunger'] < 10) {
                $new_hunger = 10;
                $new_money = $money - 5;
                
                $stmt = $con->prepare("UPDATE cats SET hunger=? WHERE name=? AND ownerid=?");
                $stmt->bind_param('isi', $new_hunger, $cat, $userid);
                $stmt->execute();

                $stmt = $con->prepare("UPDATE users SET money=? WHERE userid=?");
                $stmt->bind_param('ii', $new_money, $userid);
                $stmt->execute();
                
                $obj->hunger = $new_hunger;
                $obj->money = $new_money;
                echo json_encode($obj);
            }
            else {
                $ret = ($money < 5) ? 405 : 404;
                echo $ret;
            }
            break;
        default;
            echo 404;
            break;
    }
}

$con->close();

?>
