<?php
  $userName = "Guest";
  $status = 0;
  session_start();
  if(isset($_SESSION["userName"])){
    $userName = $_SESSION["userName"];
    $userId = $_SESSION["userId"];
    $status = 1;
  }else{
    $_SESSION["location"]="memberPage.php";
    header("location: login.php");
  }
  require_once("newPDO.php");
  $sql = $db->prepare("select * from orders  where uId = $userId");
  $sql->execute();
  while($row = $sql->fetch()){
    $orderArray[] = $row;
  }
  if(isset($_POST["btnDetail"])){
    $idx = $_POST["btnIndex"];
    echo $orderArray[$idx][0];
    $sqlD = $db->prepare("select od.*,p.pName from orderDetail od join products p on od.productId = p.pId where orderId = ".$orderArray[$idx][0]);
    if($sqlD->execute()){
       while ($row = $sqlD->fetch()) {
           $detailArray[] = $row;
       }
       echo "detail query success";
     }else{
       echo "detail error";
     }
  }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign UP</title>
    <link rel="stylesheet" href="bootstrap4/bootstrap.min.css">
    <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">

    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="bootstrap4/popper.js"></script>
    <script src="bootstrap4/bootstrap.min.js"></script>
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
      <!-- sign up Input -->
      <div class="row" style="margin-top: 20px;">
        <div class = "col" >
          <div style="font-size: xx-large;color: grey ;margin-bottom: 10px;background-color: antiquewhite;">OrderInfo</div>
             
          
       </div>
      </div>
    <?php if(isset($orderArray)){?>
    <div class="row">
      <div class="col-6" >
      <?php $count=0; foreach ($orderArray as $array) {?>
        <div class="row">
          <div class="col-10">
            <ul>
                <li><?="訂單編號：".($array[0]);?></li>
                <li><?="訂單時間：".$array[1]?></li>
              </ul>
          </div>
          <div class="col-2">
             <form method="post">
               <input type="hidden" name="btnIndex" value="<?=$count?>">
               <input class="btn mr-auto" type="submit" name="btnDetail" value="更多">
            </form>
          </div>
        </div>
        <?php $count++;}?>
      </div>
      <div class="col-6" style="border-style:ridge;">
        <?php if (isset($detailArray)) {?>
          <div class="row" style="margin:20px ;"><?="訂單編號：".($array[0]);?></div>
          <div class="row" style="margin:20px">
            <div class="col-6"><?= "商品名稱"?></div>
            <div class="col-6"><?= "商品數量"?></div>
        </div>
        <?php foreach ($detailArray as $array) {?>
          <div class="row" style="margin:20px">
            <div class="col-6"><?= $array["pName"];?></div>
            <div class="col-6"><?= $array["qty"];?></div>
        </div>
        <?php }}}else{echo "沒有任何訂單記錄";}?>
      </div>
    </div>
    
</body>
</html>