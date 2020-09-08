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
                    <option value="2">商品總銷售額</option>
                    <option value="3">商品銷售量</option>
                    <option value="4">商品銷售量/月</option>

                </select></div>
                <div class="col">
                    <label for="startTime"> 開始時間：</label>
                    <input id="startTime" name="startTime" type="date"></input>
                </div>
                <div class="col">
                    <label for="endTime"> 結束時間：</label>
                    <input id="endTime" name="endTime" type="date"></input>
                </div>
                <div id ="btnSubmit" class="btn btn-outline-success col">送出時間</div>
            </form>
        </div>
            <div id = "chartHere"><canvas id="myChart"></canvas></div>
    </div>
    <script>
        $(function(){
            let arr = Array();
            let data;
            document.getElementById('endTime').valueAsDate = new Date();
            $("#btnSubmit").click(function(){
                data={
                   startTime:$("#startTime").val(),
                   endTime:$("#endTime").val(),
                   type: $("#statType :selected").val()
                }
                if(data.startTime==""||data.endTime==""){
                    alert("請選擇時間");
                    return;
                }
                // 抓時間區間內的訂單資料
                $.ajax({
                type:"POST",
                url:"api.php?action=getOrders",
                data:data
                }).then(function(e){
                    arr= JSON.parse(e);
                    console.log(arr);
                    let monthSale = {};
                    makeChart(arr,$("#statType :selected").val());
                        })
                    })
            
            $("#statType").change(function(){
                makeChart(arr,$("#statType :selected").val());
            })
            //資料處理 製圖
            function makeChart(inputArr,type){
                $("#chartHere").html("<canvas id='myChart'></canvas>")//reset
                var ctx = document.getElementById('myChart').getContext('2d');
                
                let monthArr=[];
                let monthStr=["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];
                backgroundColor=["rgba(255, 99, 132, 0.7)","rgba(255, 159, 64, 0.7)","rgba(255, 205, 86, 0.7)","rgba(75, 192, 192, 0.7)","rgba(54, 162, 235, 0.7)","rgba(153, 102, 255, 0.7)","rgba(201, 203, 207, 0.7)"]
                borderColor=["rgb(255, 99, 132)","rgb(255, 159, 64)","rgb(255, 205, 86)","rgb(75, 192, 192)","rgb(54, 162, 235)","rgb(153, 102, 255)","rgb(201, 203, 207)"]
                if(type==1){
                    let monthSale = {};
                    for(i=new Date(data["startTime"]).getMonth();i<new Date(data["endTime"]).getMonth()+1;i++){
                        monthSale[`${i}`]=0
                        monthArr.push(monthStr[i])
                    }
                    inputArr.forEach(array => {
                        //group by month
                        monthSale[`${new Date(array.oDate).getMonth()}`]+=parseInt(array.unitPrice*array.qty);
                    });
                    // (Object.keys(monthSale)).forEach(element=>{
                    //     monthArr.push(monthStr[parseInt(element)]);
                    // })
                    var chart = new Chart(ctx, {
                          "type": "line",
                          "data": { 
                              "labels": monthArr,
                              "datasets": [{ "label": "月銷售額(TWD)",
                                             "data": Object.values(monthSale),
                                             "fill": false,
                                             "borderColor": "rgba(75, 192, 192,0.7)", "lineTension": 0.1 }] },
                              "options": {} });                    
                              return;
                }else if(type==2){
                    let productSale={};
                    inputArr.forEach(array=>{
                        if(typeof productSale[`${array.pName}`]=="undefined"){
                            // console.log("++");
                            productSale[`${array.pName}`]=0;
                        }
                        productSale[`${array.pName}`]+=parseInt(array.unitPrice*array.qty);
                        
                    });
                    console.log(Object.keys(productSale));
                    var ctx = document.getElementById('myChart').getContext('2d');
                    var chart = new Chart(ctx, {
                        // The type of chart we want to create
                        type: 'bar',

                        // The data for our dataset
                        data: {
                            labels: Object.keys(productSale),
                            
                            datasets: [{
                                label: '銷售額(NTD)',
                                backgroundColor: 'rgba(244, 167, 185,0.7)',
                                borderColor: '#F4A7B9',
                                fill: false,
                                data: Object.values(productSale)
                            }]
                        },

                        // Configuration options go here
                        options: {}
                    });
                    return;
                }else if(type==3){
                    let productSale={};
                    inputArr.forEach(array=>{
                        if(typeof productSale[`${array.pName}`]=="undefined"){
                            console.log("++");
                            productSale[`${array.pName}`]=0;
                        }
                        productSale[`${array.pName}`]+=parseInt(array.qty);
                        
                    });
                    console.log(Object.keys(productSale));
                    var ctx = document.getElementById('myChart').getContext('2d');

                    var chart = new Chart(ctx, {
                        // The type of chart we want to create
                        type: 'bar',

                        // The data for our dataset
                        data: {
                            labels: Object.keys(productSale),
                            
                            datasets: [{
                                label: '銷售量',
                                backgroundColor: 'rgba(145, 173, 112,0.7)',
                                borderColor: '#227D51',
                                fill: false,
                                data: Object.values(productSale)
                            }]
                        },

                        // Configuration options go here
                        options: {}
                    });
                }else if(type==4){
                    let mixData ={};
                    //Ｘ軸欄位名稱
                    for(i=new Date(data["startTime"]).getMonth();i<new Date(data["endTime"]).getMonth()+1;i++){
                                monthArr.push(monthStr[i]);
                            }
                    inputArr.forEach(array=>{
                        if(typeof mixData[`${array.pName}`]=="undefined"){
                            console.log("++");
                            mixData[`${array.pName}`]={};
                            for(i=new Date(data["startTime"]).getMonth();i<new Date(data["endTime"]).getMonth()+1;i++){
                                mixData[`${array.pName}`][`${i}`]=0
                            }
                        }
                        
                        mixData[`${array.pName}`][`${new Date(array.oDate).getMonth()}`]+=parseInt(array.qty);
                       
                    });
                        console.log(mixData);
                        datasets=Array();
                        Object.keys(mixData).forEach(function(key){
                            datasets.push(
                                {
                                    label: key,
                                    data: Object.values(mixData[key]),
                                    type: 'line',
                                    "fill": false,
                                    borderColor:backgroundColor[datasets.length%7],
                                    backgroundColor:backgroundColor[datasets.length%7],
                                    // this dataset is drawn on top
                                    order: 3
                                }
                            )
                        })
                        console.log(datasets);
                        var mixedChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            datasets: datasets,
                            labels: monthArr
                        },
                        options: {}
                    });

                }
            }
        })
    </script>
</body>
</html>