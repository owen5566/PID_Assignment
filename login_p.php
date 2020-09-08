<?php
    session_start();
    if(isset($_POST["txtUserName"])&&isset($_POST["txtUserPass"])){
        $db = new PDO("mysql:host=localhost;dbname=PID_db;port=8889", "root", "root");
        $db->exec("set names utf8");
        
        $sql = $db->prepare("select * from userTable where uName = :userName");
        $sql->bindParam("userName",$_POST["txtUserName"],PDO::PARAM_STR);
        if (!$sql->execute())
            {
                // $info = $db->errorInfo();
                // print_r($info);
                echo "error";
            }
            else
            {
                $row = $sql->fetch();
                if(!empty($row))
                {
                    if(hash("sha256",$_POST["txtUserPass"])===$row["uPass"]){
                        if($row["uPermission"]=="0"){
                            header("location: login.php?error=2");
                        }else{
                            $_SESSION["userId"]=$row["uId"];
                            $_SESSION["userName"]=$_POST["txtUserName"];
                            if (isset($_SESSION["location"])) {
                                $historyPage = $_SESSION["location"];
                                unset($_SESSION["location"]);
                                header("location: ".$historyPage);
                            } else {
                                header("location: index.php");
                            }
                        }
                    }else{
                        header("location: login.php?error=1");
                    }
                }else{
                    header("location: login.php?error=1");
                }
            }
        }
$db = NULL;
        
?>