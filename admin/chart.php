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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../bootstrap4/bootstrap.min.css">
    <script src="../js/jquery-3.2.1.min.js"></script>
    <script src="../bootstrap4/popper.js"></script>
    <script src="../bootstrap4/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
</head>
<body>
    <div class="container">
        <?php require("header.php")?>
        <div class="row" style="margin: 0px;">
        <form class="form-inline">
                <div class = "col"><label for="charts"> 報表類型：</label>
                <select id="statType"class ="custom-select" name="charts">
                    <option value="1" selected>月銷售額</option>
                    <option value="2">銷售量</option>
                    <option value="3">還有什麼</option>
                </select></div>
                <div class="col">
                    <label for="startTime"> 開始時間：</label>
                    <input id="startTime" name="startTime" type="date"></input>
                </div>
                <div class="col">
                    <label for="endTime"> 結束時間：</label>
                    <input id="endTime" name="endTime" type="date"></input>
                </div>
                <div id ="btnSubmit" class="btn btn-outline-success col">送出</div>
            </form>
        </div>
            <canvas id="myChart"></canvas>
    </div>
    <script>
        $(function(){
            document.getElementById('endTime').valueAsDate = new Date();
            $("#btnSubmit").click(function(){
                data={
                   startTime:$("#startTime").val(),
                   endTime:$("#endTime").val(),
                   type: $("#statType :selected").val()
                }
                $.ajax({
                type:"POST",
                url:"api.php?action=getOrders",
                data:data
                }).then(function(e){
                    let arr= JSON.parse(e);
                    console.log(arr);
                    let monthSale = {};
                    arr.forEach(array => {
                        if(typeof monthSale[`${new Date(array.oDate).getMonth()+1}`]=="undefined"){
                            console.log("++");
                            monthSale[`${new Date(array.oDate).getMonth()+1}`]=0;
                        }
                        monthSale[`${new Date(array.oDate).getMonth()+1}`]+=parseInt(array.unitPrice*array.qty);
                    // monthSale[new Date(array.oDate).getMonth()+1].push(array.productId);
                    });
                    console.log(Object.values(monthSale));
                    var ctx = document.getElementById('myChart').getContext('2d');
                    var chart = new Chart(ctx, {
                        // The type of chart we want to create
                        type: 'bar',

                        // The data for our dataset
                        data: {
                            labels: Object.keys(monthSale),
                            datasets: [{
                                label: 'My First dataset',
                                backgroundColor: 'rgb(255, 99, 132)',
                                borderColor: 'rgb(255, 99, 132)',
                                data: Object.values(monthSale)
                            }]
                        },

                        // Configuration options go here
                        options: {}
                    });
                        })
                    })
        
        })
    </script>
</body>
</html>