<?php
    $sameName="";
    $signupSuccess="";
    if (isset($_POST["submit"])) {
      print_r($_POST);
        require_once("newPDO.php");
        $sql = $db->prepare("select * from userTable where uName = :uName");
        $sql->bindParam("uName", $_POST["sTxtUserName"], PDO::PARAM_STR);
        if (!$sql->execute()) {
            echo "userName q err";
        } else {
            $row = $sql->fetch();
            if (!empty($row)) {
                $sameName = "帳號重複";
            } else {
                $insert = $db->prepare("insert into `userTable` (`uName`, `uPass`, `uMail`) VALUES(:uName, :uPass, :uMail)");
                $insert->bindParam("uName", $_POST["sTxtUserName"], PDO::PARAM_STR);
                $insert->bindParam("uPass", hash("sha256",$_POST["sTxtPass"]), PDO::PARAM_STR);
                $insert->bindParam("uMail", $_POST["sTxtEmail"], PDO::PARAM_STR);
                if(!$insert->execute()){
                    $info = $db->errorInfo();
                    print_r($info);
                }else{
                  $signupSuccess="註冊成功！請重新登入";;
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
    <title>Sign UP</title>
    <link rel="stylesheet" href="bootstrap4/bootstrap.min.css">
    <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="bootstrap4/popper.js"></script>
    <script src="bootstrap4/bootstrap.min.js"></script>
</head>
<body>
    <div class="container">
    <!-- navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="index.php">JUST BUT IT</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
      
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
              <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">memberPage</a>
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
            hello Guest!
          </span>
          <a href="login.php"><button class="btn btn-outline-info my-2 my-sm-0">Login</button></a>
          <!-- <form class="form-inline my-2 my-lg-0">
            <button class="btn btn-outline-info my-2 my-sm-0" type="submit">Login</button>
          </form> -->
        </div>
      </nav>
      <!-- end navBar -->
      <!-- sign up Input -->
      <div class="row" style="margin: 20px;">
          <div class = "col" >
            <div style="font-size: xx-large;color: grey ;margin-bottom: 10px;">Sign Up</div>
                <form method = "POST">
                <div class="form-group row">
                    <label class="col-4 col-form-label" for="sTxtUserName">user name</label> 
                    <div class="col-8">
                    <input id="sTxtUserName" name="sTxtUserName" type="text" class="form-control" required>
                    <div id="checkUserName" class="" style="color: crimson; font-size: xx-small;"><?=$sameName?></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="sTxtPass" class="col-4 col-form-label">password</label> 
                    <div class="col-8">
                    <input id="sTxtPass" name="sTxtPass" type="password" class="form-control" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="sTxtPass2" class="col-4 col-form-label">check password</label> 
                    <div class="col-8">
                    <input id="sTxtPass2" name="sTxtPass2" placeholder="please input password again" type="password" class="form-control" aria-describedby="text2HelpBlock" required> 
                    <div id="passHelpBlock" class="" style="color: crimson; font-size: xx-small;"><i class="fa fa-close fa-1"></i>請確認兩次輸入是否相同</div>
                    <div id="passHelpBlock2" class="" style="color: green; font-size: xx-small;"><i class="fa fa-check fa-1" aria-hidden="true"></i>正確</div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="sTxtEmail" class="col-4 col-form-label">e-mail</label> 
                    <div class="col-8">
                    <div class="input-group">
                        <input id="sTxtEmail" name="sTxtEmail" type="text" class="form-control" required> 
                        <div class="input-group-append">
                        <div class="input-group-text">
                        </div>
                        </div>
                    </div>
                    </div>
                </div> 
                <div class="form-group row">
                    <div class="offset-4 col-8">
                    <button id="submit" name="submit" type="submit" class="btn btn-primary" value=1 >Sign Up</button>
                    <div id="HelpBlock3" class="" style="color: green; font-size: xx-small;"><?=$signupSuccess?></div>
                    </div>
                </div>
                </form>
          </div>
          <div class = 'col' style="background-color: antiquewhite;">
      </div>
    </div>
    <script>
        $(function(){
          $("#submit").prop("disabled",true);

            let checkPass = 0;
            $("#passHelpBlock").hide();
            $("#passHelpBlock2").hide();
            $("#sTxtPass2,#sTxtPass").on("blur",function(){
                if($("#sTxtPass2").val()!=$("#sTxtPass").val()||$("#sTxtPass2").val()==""){
                    $("#passHelpBlock").show();
                    $("#passHelpBlock2").hide();
                    checkPass= 0;
                    $("#submit").prop("disabled",true);
                }else{
                    $("#passHelpBlock").hide();
                    $("#passHelpBlock2").show();
                    checkPass= 1;
                }
            })
            $(".form-control").on("blur",function(){
              let count = 0 ;
              setTimeout(function(){
                  $(".form-control").each(function(){
                    if($.trim($(this).val())!="")
                      count++;
                      if(count==4 && checkPass==1){
                        $("#submit").prop("disabled",false);
                      }else{
                        $("#submit").prop("disabled",true);
                      }
                  });
              }, 1000);
            }) 
        })
    </script>
</body>
</html>