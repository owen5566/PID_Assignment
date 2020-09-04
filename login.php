<?php
    $userName = "Guest";
    $errorInfo="";
    session_start();
    if(isset($_SESSION["userName"])){
      header("location: index.php");
  }
    if(isset($_GET["logout"])){
        unset($_SESSION["userName"]);
        unset($_SESSION["userId"]);

        header("location: index.php");
    }
    if(isset($_GET["error"])){
      switch($_GET["error"]){
        case 1:
          $errorInfo = "<div style='color:red'>*wrong username/password</div>";
        break;
        case 2:
          $errorInfo = "<div style='color:red'>*帳號被禁用ㄌ！</div>";
        break;
      }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="bootstrap4/bootstrap.min.css">
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="bootstrap4/popper.js"></script>
    <script src="bootstrap4/bootstrap.min.js"></script>
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
              <a class="nav-link disabled" href="admin/loginA.php" tabindex="-1" aria-disabled="true">Admin</a>
            </li>
          </ul>
          <span class="navbar-text" style="margin-right: 10px;">
            hello <?=$userName?>!
          </span>
          <!-- <form class="form-inline my-2 my-lg-0">
            <button class="btn btn-outline-info my-2 my-sm-0" type="submit">Login</button>
          </form> -->
        </div>
      </nav>
      <!-- end navBar -->
      <!-- loginInput -->
      <div class="row" style="margin: 20px;">
          <div class = "col" >
            <div style="font-size: xx-large;color: grey ;margin-bottom: 10px;">Login</div>
            <form action="login_p.php" id="login_form" name = "login_input" method="POST">
                <!-- username -->
                <div class="input-group mb-3 col-6">
                    <input type="text" name = "txtUserName" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
                  </div>
                <!-- password -->
                <div class="input-group mb-3 col-6">
                    <input type="password" name = "txtUserPass"class="form-control" placeholder="password" aria-label="Username" aria-describedby="basic-addon1">
                  </div>
                <div class="" style="margin-left: 16px;">
                    <!-- <div>
                        <input type="checkbox" id="checkbox_terms" name="regular_checkbox" class="regular_checkbox" checked="checked">
                        <span class="checkbox_title">remember me</span>
                    </div> -->
                    <div class = row>
                    <input type="submit" name ="btn_submit" value="login" class="btn btn-outline-success col-1.5"></input>
                    <div style="margin-top:6px;">Don't have account?<a href="signUp.php">sign up</a></div>
                    </div>
                    <?= $errorInfo?>
                </div>
            </form>
          </div>
          <div class = 'col' style="background-color: antiquewhite;">
      </div>
    </div>
</body>
</html>