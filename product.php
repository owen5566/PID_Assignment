<?php
  
  $userName = "Guest";
  $status = 0;
  $addCartMsg="";
  session_start();
  if (isset($_SESSION["userName"])) {
      $userName = $_SESSION["userName"];
      $status = 1;
  }
  if (isset($_GET["id"])) {
      $row = array();
      $target= intval($_GET["id"]);
      require_once("newPDO.php");
      $selectP = $db->prepare("select * from products where pId = :id");
      $selectP->bindParam("id", $target, PDO::PARAM_INT);
      if (!$selectP->execute()) {
          $info = $db->errorInfo();
          print_r($info);
      } else {
          $row = $selectP->fetch();
          if (!$row) {
            $db = null;
            header("location: index.php");
          }
      }
  } else {
    $db = null;
    header("location: index.php");
  }
  if(isset($_POST["btnAdd"])){
    if($status==0){
      $_SESSION["location"]="product.php?id=".$_GET["id"];
      header("location: login.php");
    }else{
        // PID UID QTY
        $uId = intval($_SESSION["userId"]);
        $pId = intval($row["pId"]);
        $qty = intval($_POST["qty"]);
        $checkP = $db->prepare("select * from cart where uId = $uId AND pId = $pId");
        $checkP->execute();
        if($result = $checkP->fetch()){
          $addCartMsg = "商品已經存在購物車中！";
        }else{
          $insertC = $db->prepare("insert into cart values(:uId , :pId, :qty)");
          $insertC->bindParam("uId",$uId,PDO::PARAM_INT);
          $insertC->bindParam("pId",$pId,PDO::PARAM_INT);
          $insertC->bindParam("qty",$qty,PDO::PARAM_INT);
            if(!$insertC->execute()){
              $info = $db->errorInfo();
              print_r($info);
            }else {
              $addCartMsg ="成功加入購物車！";
            }
        }
      }
  }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>product</title>
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
          background-color: darkgray  ;
          height:100px ;
          width: auto;
        }
    </style>
</head>
<body>
  <div class="container">
    <!-- header -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
      
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
              <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="memberPage.php">memberPage</a>
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
              <a class="nav-link disabled" href="admin/loginA.php" tabindex="-1" aria-disabled="true">Admin</a>
            </li>
          </ul>
          <span class="navbar-text" style="margin-right: 10px;">
            hello <?=$userName?>!
          </span>
          <a href="login.php"><button class="btn btn-outline-info my-2 my-sm-0"><?=($status)? "Logout" :"Login"?></button></a>
          <a href="cart.php"><i class="fa fa-shopping-cart fa-fw" ></i></a>

        </div>
      </nav><br>
    <!-- end of header -->
    <div class="row">
        <div class="col-5" style="padding: 20px;height: 300;">
            <div class="infoImg"style="background-color: antiquewhite;height:500px ;"></div>
        </div>
        <div class="col-7" style="padding: 40px;">
        <div class="row" style="margin: 20px"><h3><?=$row["pName"]?></h3></div>
        <div class="row" style="margin:20px"><?=$row["pInfo"]?></div>
        <div class="row" style="margin:20px">-info</div>
        <div class="row" style="margin:20px">-info</div>
        <div class="row" style="margin:20px">-info</div>
        <div class="row" style="margin:20px">-info</div>
        <div class="row" style="margin:20px">-info</div>
        <div class="row" style="margin:20px;"><div class="col" style="text-align: right;">$<?=$row["pPrice"]?></div></div>

        <div class="row" style="margin:20px">
        <div class="col-3" style="text-align: right;">Inventory:<?=$row["pInventory"]?></div>
          <div class="col" style="text-align: right;">
              <form method="post" >
                <input type="number" name = "qty" min="1" max="100" style="width: 70px"></input>    
                <input class="btn btn-info" type="submit" name="btnAdd" value="ADD TO CART"></input>
              </form>
              <div><?=$addCartMsg?></div>
          </div>
        </div>


        </div>
    </div>
    
  </div>
 
</body>
</html>