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
    $result = $db->query("select * from userTable");
    while($row = $result->fetch()){
        $userArray[]=$row;
    }
    if(isset($_POST["editPermission"])){
      $editUid = $_POST["uId"];
      if($db->query("update userTable set uPermission = '0' where uId=$editUid")){
        echo "update success";
        header("location: userManage.php");
      }else {
        echo "update error";
      }
    }
    if(isset($_POST["active"])){
      $editUid = $_POST["uId"];
      if($db->query("update userTable set uPermission = '1' where uId=$editUid")){
        echo "update success";
        header("location: userManage.php");
      }else {
        echo "update error";
      }
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UserManage</title>
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
    <!-- navbar -->
    <?php require("header.php")?>

      <!-- end navBar -->
      <!-- head -->
      <div class="row" style="margin-top: 20px;">
        <div class = "col" >
          <div style="font-size: xx-large;color: grey ;margin-bottom: 10px;background-color: antiquewhite;">CustomerInfo</div>
      <!-- end of head -->
      <!-- table -->
      <table class="table ">
        <thead>
            <tr>
            <th scope="col">#</th>
            <th scope="col">userName</th>
            <th scope="col">Email</th>
            <th scope="col">premission</th>
            <th scope="col"></th>

            </tr>
        </thead>
        <tbody>
            <?php foreach($userArray as $array){?>
            <tr>
            <th scope="row"><?=$array["uId"]?></th>
            <td><?=$array["uName"]?></td>
            <td><?=$array["uMail"]?></td>
            <td class= "row"><div class = "col-4 data"><?php switch($array["uPermission"]){
              case 0:
                echo "禁用";
              break;
              case 1:
                echo "正常";
              break;
              case 2:
                echo "正常2";
              break;}
            ?></div>
            <form method="POST">
              <input type = "text" name = "uId" style="display:none;" value="<?=$array["uId"]?>">            
              <?php if($array["uPermission"]!="0"){?>
              <input type = "submit" id = "btnEdit" name = "editPermission" class="btn btn-outline-danger" style="" value="ban"></input>
              <?php }else{?>
              <input type = "submit" id = "btnEdit" name = "active" class="btn btn-outline-success" style="" value="unban"></input>
              <?php } ?>
            </form>
          </td>
              <td><a href="customerOrders.php?cId=<?= $array["uId"]?>&cName=<?=$array["uName"]?>" target="blank"><button class = "btn btn-outline-info">歷史訂單</button></a></td>
            </tr>
            <?php }?>
            
        </tbody>
        </table>
      
    </div>
    <script>
      function showEdit(status){
      if(status){//edit
        $(".edit").show();
        $(".data").hide();

      }else{//cancel
        $(".edit").hide();
        $(".data").show();      
      }
    }
    </script>
</body>
</html>