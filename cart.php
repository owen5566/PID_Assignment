<?php
  $userName = "Guest";
  $status = 0;
  session_start();
  if(isset($_SESSION["userName"])){
    $userName = $_SESSION["userName"];
    $userId = $_SESSION["userId"];
    $status = 1;
  }else{
    $_SESSION["location"]="cart.php";
    header("location: login.php");
  }
  $subprice=0;
  require_once("newPDO.php");
  $sql = <<<multiSql
  select c.pId,c.qty, p.pName , p.pPrice  from cart c join products p on c.pId = p.pId
  where uId = $userId
  multiSql;
  $selectC = $db->prepare($sql);
  if(!$selectC->execute()){
    echo "query error";
  }else{
    while($row = $selectC->fetch()){
      $cartArray[] = $row;
    }//print_r($cartArray);
  }
  
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>cart</title>
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
        <a class="navbar-brand" href="#">JUST BUY IT</a>
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
              <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
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
    <!-- row name-->
    <div class="row">
      <div class="col-7">product</div>
        <div class="col-1" style="text-align: right;">price</div>
        <div class="col-2" style="text-align: right;">Qty</div>
        <div class="col-2" style="text-align: right;">total</div>
    </div>
    <!-- contect -->
    <?php if(isset($cartArray)){
        foreach ($cartArray as $array) {?>
    <div class="row" style="margin-top: 20px">
      <div class="col-7">
        <div class="row">
          <div class="col-3"style="height: 120px; background-color: antiquewhite;"></div>
          <div class="col-9"><?=$array["pName"]?></div>
        </div>  
      </div>
      <div class="col-1" style="text-align: right;"><?=$array["pPrice"]?></div>
      <div class="col-2" style="text-align: right;"><input type="number" style="width: 70px;"value=<?=$array["qty"]?>></input></div>
        <div class="col-2" style="text-align: right;"><?php echo $sum = $array["pPrice"]*$array["qty"];
        $subprice+=$sum?></div>
    </div>
    <?php }
    }else{echo "購物車沒東西! 快去購物吧";}?>
    <!-- check Cart -->
    <div class="row">
      <div class="col-6" style="background-color: floralwhite;height: 300px;"></div>
      <div class="col-6" style="background-color: gainsboro;height: 300px; padding: 20px;">
        <div class="row" ><div class="col" style="text-align: right;">subprice: <?= $subprice?></div></div>
        <div class="row" ><div class="col" style="text-align: right;">shipping</div></div>
        <div class="row" ><div class="col" style="text-align: right;">total</div></div>
        <div class="row" ><div class="col" style="text-align: right;"><button class="btn">order</button></div></div>
      </div>
        
    </div>
  </div>
</body>
</html>