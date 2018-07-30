<?php
//if、for流程控制相关语法 3元表达式 类 变量 常量 数组 函数 

//命名空间 会话 cookie 正则表达式

/*
 * http://192.168.0.200/  数据库:cmcndb 用户:cm 密码:123
 * 1.从orders表查询出shopId=25，订单状态为已付款(paidTime>0视为已付款)的所有订单，统计出 实付金额（amount）与订单总价（totalPrice）
 */
//select*from orders WHERE shopId=25 and paidTime>0;

//SELECT SUM(amount) as amount,SUM(totalPrice) as totalPrice FROM Orders WHERE shopId=25 and paidTime>0


 /**
 * http://192.168.0.200/  数据库:cmcndb 用户:cm 密码:123
 * 2.从orders表查询出shopId=25，订单状态为已付款(paidTime>0视为已付款)的所有订单，按 shopUserCode(店员编号) 进行分组统计出各自的销售金额(金额字段取totalPrice)
 */

//SELECT SUM(amount) as amount,SUM(totalPrice) as totalPrice,shopUserCode FROM Orders WHERE shopId=25 and paidTime>0 GROUP BY shopUserCode 

//查询最近3个月各店员销售额
//date(),  strtotime()
//var_dump($_SERVER);

//$cTime = strtotime("-2 months", strtotime(date("Y-m-01 00:00:00")));
// var_dump($cTime);
// var_dump(date('Y-m-d H:i:s', $cTime));
//$paidtime=getpaidtime();
//$tTime=$paidtime+strtotime("-3 mons")-strtotime("now");
/*
$servername = "192.168.0.200";
$username = "cm";
$password = "123";
$dbname = "cmcndb";

// 创建连接
$conn = new mysqli($servername, $username, $password, $dbname);
// 检测连接
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
} 
//$sql = "SELECT amount, totalPrice, shopUserCode FROM orders";
$result = mysqli_query($conn,"SELECT SUM(amount) as amount,SUM(totalPrice) as totalPrice,shopUserCode 
FROM Orders WHERE shopId=25 and paidTime>$cTime GROUP BY shopUserCode");
    while($row = mysqli_fetch_assoc($result)){
        echo "amount " . $row["amount"]. " - totalPrice: " . $row["totalPrice"]. " " . $row["shopUserCode"]. "<br>";
        echo "<br />";
    }
    */

$cTime = strtotime("-2 months", strtotime(date("Y-m-01 00:00:00")));
$c1Time = strtotime("-1 months", strtotime(date("Y-m-01 00:00:00")));
$c2Time = strtotime("-0 months", strtotime(date("Y-m-01 00:00:00")));
//var_dump($c2Time);
//var_dump(date('Y-m-d H:i:s', $c2Time));
//echo $c2time;
/*
function getthemonth($date)
{
$c2Time = date('Y-m-01', strtotime($date));
$lastday = date('Y-m-d', strtotime("$c2Time +1 month -1 day"));
$cTime = date('Y-m-01',strtotime("$c2time -2 month"));
$c1Time = date('Y-m-01',strtotime("$c2time -1 month"));
return array($c2Time,$lastday,$cTime,$c1Time);
}
$today = date("Y-m-d");
$day=getthemonth($today);
echo "当月的第一天: ".$day[0]." 当月的最后一天: ".$day[1]." 上上个月第一天是：".$day[2]." 上个月第一天是：".$day[3];
echo "<br/>";
*/
$db = array(
    'dsn' => 'mysql:host=192.168.0.200;dbname=cmcndb;port=3306;charset=utf8',
    'username' => 'cm',
    'password' => '123',
);

//连接
$options = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, //默认是PDO::ERRMODE_SILENT, 0, (忽略错误模式)
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // 默认是PDO::FETCH_BOTH, 4
);

try{
    $pdo = new PDO($db['dsn'], $db['username'], $db['password'], $options);
}catch(PDOException $e){
    die('数据库连接失败:' . $e->getMessage());
}
$stmt = $pdo->query("SELECT SUM(amount) as amount,SUM(totalPrice) as totalPrice,shopUserCode 
FROM Orders WHERE shopId=25 and paidTime>$cTime and paidTime<$c1Time GROUP BY shopUserCode");
$rows1 = $stmt->fetchAll(); //获取所有

$row1_count = $stmt->rowCount(); //记录数，2

//
//echo ("五月份各业务员的销售额：<br />");
//echo json_encode($rows1);
    //$shop = new Shop;
    //$res = $shop->getsalesAmountInMay();
    //echo $res;
$stmt = $pdo->query("SELECT SUM(amount) as amount,SUM(totalPrice) as totalPrice,shopUserCode 
FROM Orders WHERE shopId=25 and paidTime>$c1Time and paidTime<$c2Time GROUP BY shopUserCode"); //返回一个PDOStatement对象

//$row = $stmt->fetch(); //从结果集中获取下一行，用于while循环
$rows2 = $stmt->fetchAll(); //获取所有

$row2_count = $stmt->rowCount(); //记录数，2

$ret = [$rows1,$rows2];
echo json_encode($ret);
//
//echo ("六月份各业务员的销售额：<br />");
//echo json_encode($rows);
//或者更通用的设置属性方式:
//$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);    //设置异常处理方式
//$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);   //设置默认关联索引遍历







//$_SERVER

// header('Content-Type: api/shop/userSaleAmount');
// header('Content-Type: text/html;charset=utf-8');

// $email = $_GET['email'];

// $user = [];

// $conn = @mysql_connect("localhost","Test","123456") or die("Failed in connecting database");
// mysql_select_db("Test",$conn);
// mysql_query("set names 'UTF-8'");
// $query = "select * from UserInformation where email = '".$email."'";
// $result = mysql_query($query);
// if (null == ($row = mysql_fetch_array($result))) {
//   echo $_GET['callback']."(no such user)";
// } else {
//   $user['email'] = $email;
//   $user['nickname'] = $row['nickname'];
//   $user['portrait'] = $row['portrait'];
//   echo $_GET['callback']."(".json_encode($user).")";
// }

switch ($_SERVER['REQUEST_URI']) {
    case '/api/shop/salesAmountInMay':
        $stmt = $pdo->query("SELECT SUM(amount) as amount,SUM(totalPrice) as totalPrice,shopUserCode 
        FROM Orders WHERE shopId=25 and paidTime>$cTime and paidTime<$c1Time GROUP BY shopUserCode"); //返回一个PDOStatement对象

        //$row = $stmt->fetch(); //从结果集中获取下一行，用于while循环
        $rows = $stmt->fetchAll(); //获取所有

        $row_count = $stmt->rowCount(); //记录数，2
        //print_r($rows);
        //
        echo ("五月份各业务员的销售额：<br />");
        echo json_encode($rows);
            //$shop = new Shop;
            //$res = $shop->getsalesAmountInMay();
            //echo $res;
        break;
    case '/api/shop/salesAmountInJune':
        $stmt = $pdo->query("SELECT SUM(amount) as amount,SUM(totalPrice) as totalPrice,shopUserCode 
        FROM Orders WHERE shopId=25 and paidTime>$c1Time and paidTime<$c2Time GROUP BY shopUserCode"); //返回一个PDOStatement对象
        
        //$row = $stmt->fetch(); //从结果集中获取下一行，用于while循环
        $rows = $stmt->fetchAll(); //获取所有
        
        $row_count = $stmt->rowCount(); //记录数，2
        //print_r($rows);
        //
        echo ("六月份各业务员的销售额：<br />");
        echo json_encode($rows);
        break;
    default:
        echo "找不到页面";
        break;
}
/*
class Shop {
    public function getsalesAmountInmay() {
        return "xxx";
    }
    */
    /*
$a = ['a', 'b'];
$b = [ 0 => 'a' , 1 => 'b'];
$c = [ 'name' => $a, 'sex' => '123'];

$rt = ['May' => $res1, '6' => $res2];
json_decode($rt);
*/