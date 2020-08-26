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
    $result = $db->query("select * from products");
    while($row = $result->fetch()){
        $productArray[]=$row;
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="loginA.php">AdminHome</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
      
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item">
              <a class="nav-link" href="shopManage.php">ShopManage</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="userManage.php">UserManage</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Dropdown
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="#">Action</a>
                <a class="dropdown-item" href="#">Another action</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">Something else here</a>
              </div>
            </li>
            <li class="nav-item">
              <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
            </li>
          </ul>
          <span class="navbar-text" style="margin-right: 10px;">
            hello <?=$userName?>
          </span>
          <a href="loginA.php"><button class="btn btn-outline-info my-2 my-sm-0"><?=($status)? "Logout" :"Login"?></button></a>
          <!-- <form class="form-inline my-2 my-lg-0">
            <button class="btn btn-outline-info my-2 my-sm-0" type="submit">Login</button>
          </form> -->
        </div>
      </nav>
      <!-- end navBar -->
      <!-- head -->
      <div class="row" style="margin-top: 20px;">
        <div class = "col" >
          <div style="font-size: xx-large;color: grey ;margin-bottom: 10px;background-color: antiquewhite;">ProductInfo</div>
      <!-- end of head -->
      <!-- table -->
      <table class="table table-striped">
        <thead>
            <tr>
            <th scope="col">#</th>
            <th scope="col">ProductName</th>
            <th scope="col">UnitPrice</th>
            <th scope="col">Inventory</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($productArray as $array){?>
            <tr>
            <th scope="row"><?=$array["pId"]?></th>
            <td><?=$array["pName"]?></td>
            <td><?=$array["pPrice"]?></td>
            <td><?=$array["pInventory"]?></td>
            </tr>
            <tr>
            <?php }?>
            
        </tbody>
        </table>
      
    </div>
</body>
</html>