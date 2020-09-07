<?php
  $userName = "Guest";
  $status = 0;
  session_start();
  if(isset($_SESSION["userName"])){
    $userName = $_SESSION["userName"];
    $status = 1;
  }
  require_once("connDB.php");
  $pSql = <<<multiSQL
  select pId , pName , pPrice from products
  multiSQL;
  $result = mysqli_query($link,$pSql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>index</title>
    <link rel="stylesheet" href="bootstrap4/bootstrap.min.css">
    <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="bootstrap4/popper.js"></script>
    <script src="bootstrap4/bootstrap.min.js"></script>
    <style>
        a {
            color: inherit; /* blue colors for links too */
            text-decoration: inherit; /* no underline */
        }
        .productImg{
          background-color: powderblue  ;
          height:200px ;
          width: auto;
        }
    </style>
</head>
<body>
  <div class="container">
    <!-- header -->
    <?php require("headerC.php")?>
    <br>
    <!-- end of header -->
    <!-- homeImg -->
    <div class="row homeImg" style="background-color: antiquewhite; margin-left: auto;margin-right: auto;height: 500px;">
        <div class="btn btn-light" style="height: 50px;width: 200px; position: relative;top:400px;left: 100px"></div>
    </div>
    <!-- product -->
    <div class="container">
    <div class="row">
      <?php while($row = mysqli_fetch_assoc($result)){?>
      <div class= "col-md-3 col-sm-6" style="height: 300px;padding: 20px;">
        <a href="product.php<?="?id=".$row["pId"]?>" target="_blank">
          <div class="productImg"><img class="img-fluid img-thumbnail" src="admin/upload/<?= $row["pId"]?>.jpg" style="width:100%;height:100%"/></div>
        </a>
        <div class="productName"><?=$row["pName"]?></div>
        <div class="productPrice">$ <?=$row["pPrice"]?></div>
      </div>
      <?php }?>
    </div>
    </div>
  </div>
  <br><br><br><br><br><br><br><br><br><br><br><br><br>
  <br><br><br><br><br><br><br><br><br><br><br><br><br>
  <br><br><br><br><br><br><br><br><br><br><br><br><br>
  <br><br><br><br><br><br><br><br><br><br><br><br><br>
  <br><br><br><br><br><br><br><br><br><br><br><br><br>
  <p>o0o<p>
</body>
</html>