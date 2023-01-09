<?php
include("admin/db/pdo.php");
$obj = new database();
if (isset($_POST['contact'])) {
    sleep(4);
    $name = $_POST['name'];
    $email = $_POST['email'];
    $mes = $_POST['message'];
    $ip = $_SERVER['REMOTE_ADDR'];
    $date = date("Y-m-d");
    // check ip exist or not in this day
    $obj->select("contact", null, null, "ip = '$ip' and date ='$date'");
    $getip = $obj->show_result();
    if (count($getip[0]) > 0) {
        echo json_encode(["status" => false, "message" => "You are already placing your question"], true);
    } else {

        if ($obj->insert("contact", ['name' => $name, 'date' => $date, 'email' => $email, 'message' => $mes, 'ip' => $ip])) {
            echo json_encode(['status' => true], true);
        } else {
            echo json_encode(['status' => false, "message" => "something went wrong"], true);
        }
    }
}
if (isset($_POST['placeOrder'])) {
    $name = $_POST['name'];
    $mobile = $_POST['mobile'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $table = $_POST['ttyp'];
    if (preg_match("/[a-zA-Z]{3,}/", $name)) {
        if (preg_match("/(^(\+88|0088)?(01){1}[3dffds456789]{1}(\d){8})$/", $mobile)) {
            function validateDate($date, $format = 'Y-m-d')
            {
                $d = DateTime::createFromFormat($format, $date);
                // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
                return $d && $d->format($format) === $date;
            }
            if (validateDate($date)) {
                if (preg_match("/^(?:2[0-3]|[01][0-9]):[0-5][0-9]$/", $time)) {
                    $obj->select("booking", null, null, "time = '$time' and date = '$date'", null, null);
                    $res = $obj->show_result();
                    if (count($res[0]) > 8) {
                        echo json_encode(['status' => false, 'error' => "bussy"]);
                    } else {
                        if ($obj->insert("booking", ['name' => $name,'contact'=>$mobile, "date" => $date, 'time' => $time])) {
                            echo json_encode(["status" => true]);
                        } else {
                            echo json_encode(["status" => false, 'error' => "insert"]);
                        }
                    }
                } else {
                    echo json_encode(['status' => false, "error" => "time"]);
                }
            } else {
                echo json_encode(['status' => false, "error" => "date"]);
            }
        } else {
            echo json_encode(['status' => false, "error" => "mobile"]);
        }
    } else {
        echo json_encode(['status' => false, "error" => "name"]);
    }
}
