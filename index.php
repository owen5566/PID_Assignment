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
    <!-- homeImg -->
    <div class="row homeImg" style="background-color: antiquewhite; margin-left: auto;margin-right: auto;height: 500px;">
        <div class="btn btn-light" style="height: 50px;width: 200px; position: relative;top:400px;left: 100px"></div>
    </div>
    <!-- product -->
    <div class="container">
    <div class="row">
      <?php while($row = mysqli_fetch_assoc($result)){?>
      <div class= "col-3" style="height: 200px;padding: 20px;">
        <a href="product.php<?="?id=".$row["pId"]?>" ><div class="productImg">img HERE</div></a>
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