<?php
    $userName = "";
    $status = 0;
    session_start();
    if(isset($_SESSION["AdminName"])){
      $userName = $_SESSION["AdminName"];
      $status = 1;
    }else{
        header("location: loginA.php");
    }
    require_once("../newPDO.php");
    $result = $db->query("select pId from products order by pId DESC limit 1");
    if($row = $result->fetch()){
        $newPId =  $row["pId"] + 1;
    }else {
        $newPId = 1;
    }
    if(isset($_POST["btnNew"])){
        print_r($_POST);
        $insertP = $db->prepare("insert into `products` (`pName`, `pPrice`, `pInventory`, `pInfo`) VALUES (:pName, :pPrice, :pInven, :pInfo)");
        // $insertP->bindParam("pId", intval($newPId), PDO::PARAM_INT);
        $insertP->bindParam("pName", $_POST["txtName"], PDO::PARAM_STR);
        $insertP->bindParam("pPrice", intval($_POST["txtPrice"]), PDO::PARAM_INT);
        $insertP->bindParam("pInven", intval($_POST["txtInven"]), PDO::PARAM_INT);
        $insertP->bindParam("pInfo", $_POST["txtInfo"], PDO::PARAM_STR);
        if($insertP->execute()){
            $_SESSION["newMsg"]="新增成功";
            header("location: shopManage.php");
        }else{
            print_r($db->errorinfo());
        }
    }
            
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>new product...</title>
    <link rel="stylesheet" href="../bootstrap4/bootstrap.min.css">
    <script src="../js/jquery-3.2.1.min.js"></script>
    <script src="../bootstrap4/popper.js"></script>
    <script src="../bootstrap4/bootstrap.min.js"></script>
    <style>
      .btn{
        margin-right: 10px;
      }
    </style>
</head>
<body>
    <div class="container">
        <?php require("header.php")?>
        <!-- end navBar -->
        <!-- head -->
        <div class="row" style="margin-top: 20px;">
            <div class = "col" >
                <div style="font-size: xx-large;color: grey ;margin-bottom: 10px;">ProductInfo</div>
            </div>
            <div class = "col" style="text-align:right;">
                <span>
                <form method="post">
                    <input type = "submit" id = "btnNew" name="btnNew" class="btn" style="height: 40px;"value="new"></input>
                    <a href="productInfo.php"><input type = "button" id = "btnCancel" class="btn" style="height: 40px;" value="cancel"></input></a>
                </span>
            </div>            
        </div>

        <!-- end of head -->
        <!-- table -->
        <div class="row" style="height: 300px;margin: auto;">
            <div class="col" style="background-color: bisque;margin-top: 10px;"></div>
            <div class="col" style="border-style: groove;margin-top: 10px;">
                <table class="table table-striped">
                    <tbody>
                        <tr>
                        <td>product ID</td>
                        <td style="text-align: right;"><?php echo $newPId?></td>
                      </tr>
                      <tr>
                        <td>product Name</td>
                        <td style="text-align: right;" ><input type= "text" name = "txtName" required></input></td>
                      </tr>
                      <tr>  
                        <td>UnitPrice</td>
                        <td style="text-align: right;"><input type= "number" name = "txtPrice" min = "1" required></input></td>
                      </tr>
                      <tr>
                        <td>Inventory</td>
                        <td style="text-align: right;"><input type= "number" name = "txtInven" min = "0" required></input></td>
                      </tr>
                      <tr>
                        <td>Info</td>
                        <td style="text-align: right;"><textarea name = "txtInfo" required></textarea></td>
                      </tr>
                   </tbody>
                  </table>
            </div>

        </div>
      
    </div>
  <script>
 
    
  </script>
</body>
</html>