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
        move_uploaded_file($tmp_name, "upload/homeImage.jpg");
        if ($error==0) {
            $msg = "檔案上傳成功啦！";
        } elseif ($error==1) {
            $msg =  "超過了檔案大小，在php.ini檔案中設定";
        } elseif ($error==2) {
            $msg =  "超過了檔案的大小MAX_FILE_SIZE選項指定的值";
        } elseif ($error==3) {
            $msg =  "檔案只有部分被上傳";
        } elseif ($error==4) {
            $msg =  "沒有檔案被上傳";
        } else {
            $msg =  "上傳檔案大小為0";
        }
      } else {
        $msg =  "請上傳jpg,gif,png等格式的圖片！";
      }
    }

  }
  if(isset($_POST["btnDelete"])){
    $files = glob('upload/*'); // get all file names
    foreach($files as $file){ // iterate files
       if(is_file($file)&&$file=="upload/homeImage.jpg")
          unlink($file);
      }
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="../bootstrap4/bootstrap.min.css">
    <script src="../js/jquery-3.2.1.min.js"></script>
    <script src="../bootstrap4/popper.js"></script>
    <script src="../bootstrap4/bootstrap.min.js"></script>
    <style>
      .btn{
        margin: 10px;
      }
      .btn-lg{
        height: 200px;
      }
      .btnText{
        position: relative;
        top: 40%;
      }
    
      
    </style>
</head>
<body>
    <div class="container">
    <!-- navbar -->
    <?php require("header.php")?>
      <!-- end navBar -->
      <div class = "row" style="margin: 10px;">
        <img src="upload/homeImage.jpg" alt="home-image" style="max-height:500px">
      </div>
      <div class = "row" style="margin: 10px;">
          <form method="post" enctype="multipart/form-data" action="">
            上傳首頁圖片:
            <input type="file" name="upfile" class="btn"/><br>
            <input type="submit" name="btnSubmit" class="btn btn-success"value="upload" />
            <input id = "delImg" type="submit" class="btn btn-danger" name="btnDelete" value="delete" />
            <div ><?= (isset($msg))?$msg:""?></div> 
          </form>
        
      </div>
</body>
</html>