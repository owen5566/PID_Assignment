<?php
    require_once("../newPDO.php");
    // $url = explode("/", rtrim($_GET["url"], "/") );
    switch($_GET["action"]){
        case "getOrders":
            echo json_encode(getOrders());
    }
    function getOrders(){
        global $db;
        $start = $_POST["startTime"];
        $end = $_POST["endTime"];
        $statType= $_POST["type"];
        $sql = <<<multi
        select oDate,uId, productId, unitPrice ,qty ,pName from orders o 
        join orderDetail od on o.oId = od.orderId 
        join products p on p.pId = od.productId
        where odate BETWEEN '$start 00:00:00' AND '$end 23:59:59'
        multi;
        // return $sql;
        if($result = $db->query($sql)){
            while($row = $result->fetch(PDO::FETCH_ASSOC)){
                $orderArr[]=$row;
            }return $orderArr;
        }
    }
?>