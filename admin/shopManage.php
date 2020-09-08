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
    $msg = (isset($_SESSION["newMsg"]))?$_SESSION["newMsg"]:"";
    require_once("../newPDO.php");
    $result = $db->query("select * from products");
    while($row = $result->fetch()){
        $productArray[]=$row;
    }
    //delete product
    if(isset($_POST["btnDel"])){
      print_r($_POST);
      $pIdDel = $_POST["pIdDel"];
      if(!$db->query("delete from products where pId =$pIdDel")){
        $debug = "delete product item fail";
      }else {
        $files = glob('upload/*'); // get all file names
        var_dump($files);  
        foreach($files as $file){ // iterate files
          if (is_file($file)&&$file=="upload/$pId.jpg") {
              unlink($file);
          }
      }
        header("location: shopManage.php");
      }
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ShopManage</title>
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
    <?php require("header.php")?>
    <!-- end navBar -->
      <!-- head -->
      <div class="row" style="margin-top: 20px;">
        <div class = "col" >
          <div style="font-size: xx-large;color: grey ;margin-bottom: 10px;background-color: antiquewhite;">ProductList<?= $msg?></div>
      <!-- end of head -->
      <!-- table -->
      <table class="table table-striped">
        <thead>
            <tr>
            <th scope="col">#</th>
            <th scope="col">ProductId</th>
            <th scope="col">ProductIMG</th>
            <th scope="col">ProductName</th>
            <th scope="col">UnitPrice</th>
            <th scope="col">Inventory</th>
            </tr>
        </thead>
        <tbody>
            <?php if(isset($productArray)){
                $count=1;
                foreach ($productArray as $array) {?>
            <tr>
            <th scope="row"><?= $count?></th>
            <td><?=$array["pId"]?></td>
            <td><img id = "pImg" src="upload/<?= $array["pId"]?>.jpg" alt="not set yet:<" style="width:100px;margin:5px" onerror="imgError()"></td>
            <td><a href="productInfo.php?pId=<?= $array["pId"]?>" target = "blank"><?=$array["pName"]?></a></td>

            <td><?=$array["pPrice"]?></td>
            <td class='row' style="margin-right:0px">
              <div class="col"><?=$array["pInventory"]?></div>
              <form class ="col-4" method="post">
                <input type = "submit" id = "" name = "btnDel" class="btn btn-outline-danger" style="" value="delete">
                <input type = "text" name = "pIdDel" value="<?=$array["pId"]?>" style="display: none;">
              </form>
            </td>
            </tr>
            
            <?php $count++;}
            }else{

            }?>
            
        </tbody>
        </table>
      <a href="newItem.php"><button class="btn">add item</button>
    </div>
</body>
<?php unset($_SESSION["newMsg"]);?>

</html>