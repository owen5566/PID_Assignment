<?php
  $userName = "Guest";
  $status = 0;
  $msg="";
  $msgnew="";
  session_start();
  if(isset($_SESSION["userName"])){
    $userName = $_SESSION["userName"];
    $userId = $_SESSION["userId"];
    $status = 1;
  }else{
    $_SESSION["location"]="memberPage.php";
    header("location: login.php");
  }
  if(isset($_SESSION["orderSuccess"])){
    $msg = " :下單成功";
    $msgnew = " <div style='color: red;'>--new</div>";
    unset($_SESSION["orderSuccess"]);
  }
  require_once("newPDO.php");
  $sql = $db->prepare("select * from orders  where uId = $userId ORDER BY oId DESC");
  $sql->execute();
  while($row = $sql->fetch()){
    $orderArray[] = $row;
  }
  if(isset($_POST["btnDetail"])){
    $idx = $_POST["btnIndex"];
    $sqlD = $db->prepare("select od.*,p.pName from orderDetail od join products p on od.productId = p.pId where orderId = ".$orderArray[$idx][0]);
    if($sqlD->execute()){
       while ($row = $sqlD->fetch()) {
           $detailArray[] = $row;
       }
      //  echo "detail query success";
     }else{
      //  echo "detail error";
     }
  }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MemberPage</title>
    <link rel="stylesheet" href="bootstrap4/bootstrap.min.css">
    <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">

    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="bootstrap4/popper.js"></script>
    <script src="bootstrap4/bootstrap.min.js"></script>
</head>
<body>
    <div class="container">
    <!-- header -->
    <?php require("headerC.php")?>
    <br>
    <!-- end of header -->
      <!-- sign up Input -->
      <div class="row" style="margin-top: 20px;">
        <div class = "col" >
          <div style="font-size: xx-large;color: grey ;margin-bottom: 10px;background-color: antiquewhite;">OrderInfo<?= $msg?></div>
             
          
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
        <hr>
        <?php $count++;}?>
      </div>
      <div class="col-6" style="border-style:ridge;">
        <?php if (isset($detailArray)){?>
          <div class="row" style="margin:20px ;"><?="訂單編號：".($detailArray[0]["orderId"]).$msg?></div>
          <hr>
          <div class="row" style="margin:20px">
            <div class="col-6"><?= "商品名稱"?></div>
            <div class="col-6"><?= "購買數量"?></div>
        </div>
        <?php foreach ($detailArray as $array) {?>
          <div class="row" style="margin:20px">
            <div class="col-6"><a href="product.php?id=<?= $array["productId"] ?>" target="blank"><?= $array["pName"];?></a></div>
            <div class="col-6"><?= $array["qty"];?></div>
        </div>
        <?php }}}else{echo "沒有任何訂單記錄";}?>
      </div>
    </div>
    
</body>
</html>