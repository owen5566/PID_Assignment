<?php
  $userName = "Guest";
  $status = 0;
  $debug="";
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
  select c.pId,c.qty, p.pName , p.pPrice ,p.pInventory from cart c join products p on c.pId = p.pId
  where uId = $userId
  multiSql;
  $selectC = $db->prepare($sql);
  if(!$selectC->execute()){
    echo "query error";
  }else{
    while($row = $selectC->fetch()){
      $cartArray[] = $row;
    }
    //print_r($cartArray);
  }
  /// new order
  /// 建立流水編號->建立訂單->檢查購買商品庫存＆扣庫存->建立訂單詳細資料->清空購物車->流水號+1 
  if (isset($_POST["orderBtn"])&&isset($cartArray)) {
    $db->query("BEGIN");
    $sqlOrder = $db->prepare("select uOrderIdx from userTable where uId = $userId");
      if($sqlOrder->execute()){
        $result = $sqlOrder->fetch();
        echo $orderIdx =$userId.date("Ymd").(1000+$result["uOrderIdx"]);
        //create order
        $sqlOrder = $db->prepare("insert into orders (oId,uId,ship) values ($orderIdx,$userId,0)");
          if($sqlOrder->execute()){
            $debug = "create order success";
            //create order details

            foreach ($cartArray as $array) {
                echo $insertPid = $array["pId"];
                echo $insertUnitPrice = $array["pPrice"];
                echo $insertQty = $array["qty"];
                echo "<br>";
                $result = $db->query("select pInventory from products where pId=$insertPid");
                $inven = $result->fetch();
                if ($inven["pInventory"]>=$insertQty) {
                  if ($db->query("UPDATE products SET pInventory = pInventory - $insertQty where pId=$insertPid")) {
                      $sqlOrder = $db->prepare("insert into orderDetail (orderId,productId,unitPrice,qty) values ($orderIdx, $insertPid,$insertUnitPrice,$insertQty)");
                      if ($sqlOrder->execute()) {
                          $debug = "create detail succes";
                          $sqlOrder = $db->prepare("delete from cart where uId = $userId");
                          if ($sqlOrder->execute()) {
                              $debug = "drop cart";
                              $sqlOrder = $db->prepare("UPDATE userTable set uOrderIdx = uOrderIdx + 1 where uId = $userId");
                              if ($sqlOrder->execute()) {
                                  $debug = "update idx success";
                                  $cartArray=null;
                                  $db->query("commit");
                                  $_SESSION["orderSuccess"]=1;
                                  header("location: memberPage.php");
                              } else {
                                  $debug = "increase idx fail";
                                  $db->query("rollback");
                              }
                          } else {
                              $debug = "drop cart fail";
                              $db->query("rollback");
                          }
                      } else {
                          $debug = "creat detail fail";
                          $db->query("rollback");
                      }
                  }
                }else {
                  $debug = "Inventory not enough";
                  $db->query("rollback");
                }
            }
          }else{
            $debug = "create order fail";
            $db->query("rollback");
          }  
      }else{
        $debug = "query fail";
        $db->query("rollback");
      }
    }
    ///end of new order

    ///delete cart item
    if(isset($_POST["delCartItem"])){
      
      $debug= $_POST;
      $delItem=$_POST['pId'];
      if(!$db->query("delete from cart where pId =$delItem AND uId=$userId")){
        $debug = "delete cart item fail";
      }else {
        header("location: cart.php");
      }
    }

    ///edit cart item
    if(isset($_POST["editCartItem"])){
      $debug= $_POST;
      $editQty = $_POST["pQty"];
      $editItem=$_POST['pId'];
      if(!$db->query("update cart set Qty =$editQty where pId=$editItem AND uId=$userId")){
        $debug = "edit cart item fail";
      }else {
        header("location: cart.php");
      }
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
        <div class="col" style="text-align: right;">price</div>
        <div class="col" style="text-align: right;">Qty</div>
        <div class="col" style="text-align: right;">total</div>
        <div class="col" style="text-align: right;"></div>

    </div>
    <!-- contect -->
    <?php if(isset($cartArray)){
        $count = 0;
        foreach ($cartArray as $array) {?>
    <div class="row" style="margin-top: 20px">
      <div class="col-7">
        <div class="row">
          <div class="col-3"style="height: 120px; background-color: antiquewhite;"></div>
          <div class="col-9"><?=$array["pName"]?></div>
        </div>  
      </div>
      <div class="col" style="text-align: right;"><?=$array["pPrice"]?></div>
      <div class="col" id="txtQty<?= $count?>" style="text-align: right;"><?=$array["qty"]?></div>

      <div class="col" id="inputQty<?= $count?>" style="text-align: right;display: none;">
        <form method="POST">
          <input type="number"id="pQty<?= $count?>" name="pQty"style="width:50%" min=1 max = <?=$array["pInventory"]?> value="<?=$array["qty"]?>"></input>
          <input type="text" id = "pId<?= $count?>" name="pId"style="display:none" value="<?=$array["pId"]?>"></input>

      </div>

      <div class="col" style="text-align: right;"><?php echo $sum = $array["pPrice"]*$array["qty"];
        $subprice+=$sum?></div>
      <div class = "col">
        <input type = "button" id = "btnEdit<?= $count?>" class="btn row" style="height: 40px;"value="edit" onclick="showEdit(<?= $count?>)"></input>
        <input type = "button" id = "btnCancel<?= $count?>" class="btn row" style="height: 30px;width: 70px; display: none;padding: 1px;margin: 1px;"value="cancel" onclick="cancelEdit(<?= $count?>)"></input>
        <input type = "submit" id = "btnSave<?= $count?>" name="editCartItem"class="btn row" style="height: 30px;width: 70px; display: none;padding: 1px;margin: 1px;"value="save" ></input>
        <input type = "submit" id = "btnDel<?= $count?>" name="delCartItem" class="btn row" style="height: 30px; width: 70px;display: none;padding: 1px;margin:1px;"value="delete" ></input>
        </form>
      </div>
      <!-- <div class ="btn col-1" style="text-align: right;"><div> -->
    </div>
    <?php $count++;}
    }else{echo "購物車沒東西! 快去購物吧";}?>
    <!-- check Cart -->
    <div class="row">
      <div class="col-6" style="background-color: floralwhite;height: 300px;">
      <div>debug here:<?=var_dump($debug)?></div>
              
      </div>
      <div class="col-6" style="background-color: gainsboro;height: 300px; padding: 20px;">
        <div class="row" ><div class="col" style="text-align: right;">subprice: <?= $subprice?></div></div>
        <div class="row" ><div class="col" style="text-align: right;">shipping: free</div></div>
        <div class="row" ><div class="col" style="text-align: right;">total: <?= $subprice?></div></div>
        <div class="row" ><div class="col" style="text-align: right;">
          <form method  ="post">
            <input class="btn "type="submit" id="orderBtn" name ="orderBtn" value="ORDER"<?= isset($cartArray)?"":"disabled"?> ></input>  
          </form>
        </div></div>
      </div>
        
    </div>
  </div>
  <script>
    var tempQty=0;
    function showEdit(idx){
      tempQty = $("#txtQty"+idx).text();
      $("#btnCancel"+idx).show();
      $("#btnSave"+idx).show();
      $("#btnDel"+idx).show();
      $("#inputQty"+idx).show();
      $("#btnEdit"+idx).hide();
      $("#txtQty"+idx).hide();
      $("#orderBtn").attr("disabled","disabled");
    }
    function cancelEdit(idx){
      $("#pQty"+idx).val(tempQty);
      $("#btnCancel"+idx).hide();
      $("#btnSave"+idx).hide();
      $("#btnDel"+idx).hide();
      $("#inputQty"+idx).hide();
      $("#btnEdit"+idx).show();
      $("#txtQty"+idx).show();
      $("#orderBtn").removeAttr("disabled","disabled");

    }
  </script>
</body>
</html>