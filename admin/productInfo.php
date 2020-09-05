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
    if (isset($_GET["pId"])) {
        require_once("../newPDO.php");
        $pId = $_GET["pId"];
        $result = $db->query("select * from products where pId = $pId");
        while ($row = $result->fetch()) {
            $productArray[]=$row;
        }
    }else {        
        header("location: shopManage.php");
    }
    if(isset($_POST["btnSave"])){
        var_dump($_POST);
        $sql = $db->prepare("update products set pName = :name,pPrice= :price,pInventory = :inventory, pInfo= :info where pId = :pId");
        $sql->bindParam("name", $_POST["txtName"], PDO::PARAM_STR);
        $sql->bindParam("price", intval($_POST["txtPrice"]), PDO::PARAM_INT);
        $sql->bindParam("inventory", intval($_POST["txtInven"]), PDO::PARAM_INT);
        $sql->bindParam("info", $_POST["txtInfo"], PDO::PARAM_STR);
        $sql->bindParam("pId", intval($pId), PDO::PARAM_INT);

        if($sql->execute()){
          echo "update success";
          header("location: productInfo.php?pId=$pId");

        }else{
          echo "update error";
        }
                
    }
    if(isset($_POST["btnSubmit"])){
      if (is_uploaded_file($_FILES['upfile']['tmp_name'])) {
        $upfile=$_FILES["upfile"];
    //獲取陣列裡面的值
        $name=$upfile["name"];//上傳檔案的檔名
        $type=$upfile["type"];//上傳檔案的型別
        $size=$upfile["size"];//上傳檔案的大小
        $tmp_name=$upfile["tmp_name"];//上傳檔案的臨時存放路徑
        //判斷是否為圖片
        switch ($type) {
        case 'image/pjpeg':$okType=true;
        break;
        case 'image/jpeg':$okType=true;
        break;
        case 'image/gif':$okType=true;
        break;
        case 'image/png':$okType=true;
        break;
        }
    if ($okType) {
        /**
        * 0:檔案上傳成功<br/>
        * 1：超過了檔案大小，在php.ini檔案中設定<br/>
        * 2：超過了檔案的大小MAX_FILE_SIZE選項指定的值<br/>
        * 3：檔案只有部分被上傳<br/>
        * 4：沒有檔案被上傳<br/>
        * 5：上傳檔案大小為0
        */
        $error=$upfile["error"];//上傳後系統返回的值
        //把上傳的臨時檔案移動到upload目錄下面(upload是在根目錄下已經建立好的！！！)
        move_uploaded_file($tmp_name, "upload/".$pId.".jpg");
        $destination="upload/".$pId.".jpg";
        if ($error==0) {
            echo "檔案上傳成功啦！";
        //echo " alt=\"圖片預覽:\r檔名:".$destination."\r上傳時間:\">";
        } elseif ($error==1) {
            echo "超過了檔案大小，在php.ini檔案中設定";
        } elseif ($error==2) {
            echo "超過了檔案的大小MAX_FILE_SIZE選項指定的值";
        } elseif ($error==3) {
            echo "檔案只有部分被上傳";
        } elseif ($error==4) {
            echo "沒有檔案被上傳";
        } else {
            echo "上傳檔案大小為0";
        }
      } else {
        echo "請上傳jpg,gif,png等格式的圖片！";
      }
    }

  }
  if(isset($_POST["btnDelete"])){
    $files = glob('upload/*'); // get all file names
    var_dump($files);  
    foreach($files as $file){ // iterate files
       if(is_file($file)&&$file=="upload/$pId.jpg")
          unlink($file);
      }
  }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>productInfo</title>
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
        <?php require("header.php")?>
        <!-- end navBar -->
        <!-- head -->
        <div class="row" style="margin-top: 20px;">
            <div class = "col" >
                <div style="font-size: xx-large;color: grey ;margin-bottom: 10px;">ProductInfo</div>
            </div>
            <div class = "col" style="text-align:right;">
                
            </div>            
        </div>

        <!-- end of head -->
        <!-- table -->
        <div class="row" style="height: 300px;margin: auto;">
            <div class="col" style="background-color: bisque;margin-top: 10px;">
            <!-- uploadImg -->
            product Img
            <img src="upload/<?= $pId?>.jpg" alt="img" style="width:90%;margin:20px">
            <form method="post" enctype="multipart/form-data" action="">
                upload new file:
                <input type="file" name="upfile" /><br>
                <input type="submit" name="btnSubmit" value="upload" />
            </form>
            <form method="post">
              <input type="submit" name="btnDelete" value="delete" />
            </form>
            </div>
            <div class="col" style="border-style: groove;margin-top: 10px;">
              <div class="row float-right" style="margin:10px">
                <input type="button" id="btnEdit" class="btn data btn-outline-info" style="height: 40px;" value="edit" onclick="showEdit(1)"></input>
                <span>
                  <form method="post">
                    <input type="submit" id="btnSave" name="btnSave" class="btn edit btn-outline-success" style="height: 40px;display:none"
                      value="save"></input>
                    <input type="button" id="btnCancel" class="btn edit btn-outline-danger" style="height: 40px;display:none" value="cancel"
                      onclick="showEdit(0)"></input>
                </span>
              </div>
                <table class="table table-striped">
                    
                    <tbody>
                      <?php if(isset($_GET["pId"])){?>
                      <tr>
                        <td>product ID</td>
                        <td style="text-align: right;"><?=$productArray[0][0]?></td>
                      </tr>
                      <tr>
                        <td>product Name</td>
                        <td  style="text-align: right;"><div id = "name" class="data"><?=$productArray[0][1]?></div>
                        <input class="edit" id ="txtName" name="txtName" type= "text" style="display: none" value="<?=$productArray[0][1]?>"></input></td>
                      </tr>
                      <tr>  
                        <td>UnitPrice</td>
                        <td  style="text-align: right;"><div id = "price" class="data"><?=$productArray[0][2]?></div>
                        <input class="edit" id="txtPrice" name="txtPrice" type= "text" style="display: none" value="<?=$productArray[0][2]?>"></input></td>
                      </tr>
                      <tr>
                        <td>Inventory</td>
                        <td  style="text-align: right;"><div id = "Inven" class="data"><?=$productArray[0][3]?></div>
                        <input class="edit" id="txtInven" name="txtInven" type= "number" min=0 style="display: none" value="<?=$productArray[0][3]?>"></input></td>
                      </tr>
                      <tr>
                        <td>Info</td>
                        <td  style="text-align: right;"><div id = "Info" class="data"><?=$productArray[0][4]?></div>
                        <textarea class="edit" id = "txtInfo" name="txtInfo" type= "text" style="display: none"value=""><?=$productArray[0][4]?></textarea></td>
                        </form>

                      </tr>

                      <?php }?>
                    </tbody>
                  </table>
            </div>

        </div>
      
    </div>
    <script>
    let temp = ["","","",""];

    function showEdit(status){
      if(status){//edit
        $(".edit").show();
        $(".data").hide();

      }else{//cancel
        $(".edit").hide();
        $(".data").show();
        $("#txtName").val($("#name").text());
        $("#txtPrice").val($("#price").text());
        $("#txtInven").val($("#Inven").text());
        $("#txtInfo").val($("#Info").text())
      }
    }
    
  </script>
</body>
</html>