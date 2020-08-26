<?php
    session_start();
    if(isset($_POST["txtUserName"])&&isset($_POST["txtUserPass"])){
        print_r($_POST);
        $db = new PDO("mysql:host=localhost;dbname=PID_db;port=8889", "root", "root");
        $db->exec("set names utf8");
        
        $sql = $db->prepare("select * from admin where adminName = :adminName");
        $sql->bindParam("adminName",$_POST["txtUserName"],PDO::PARAM_STR);
        if (!$sql->execute()) {
                $info = $db->errorInfo();
                print_r($info);
                echo "error";
        } else {
                $row = $sql->fetch();
                print_r($row);
                if (!empty($row)) {
                    if ($_POST["txtUserPass"]===$row["adminPass"]) {
                        $_SESSION["AdminId"]=$row["adminId"];
                        $_SESSION["AdminName"]=$_POST["txtUserName"];
                        if (isset($_SESSION["location"])) {
                            $historyPage = $_SESSION["location"];
                            unset($_SESSION["location"]);
                            header("location: ".$historyPage);
                        } else {
                            header("location: indexA.php");
                        }
                    } else {
                        header("location: loginA.php?error=2");
                    }
                } else {
                    header("location: loginA.php?error=1");
                }
            }

        }
$db = NULL;
        
?>