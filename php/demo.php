<?php
//进行冒泡排序！
//有数组 $arr = [1, 5, 7, 20, 18, 67, 0, 2], 请对数组进行从小到大排序，不可以使用php内置排序函数
//$a = array(1,5,7,20,18,67,0,2);
//$number = count($a);
//for($i = 0;$i < $number;$i++) {
//   for($j= 0;$j < $number - $i - 1;$j++) {
  //      if($a[$j] > $a[$j+1]){
  //         $b = $a[$j];
  //         $a[$j] = $a[$j+1];
  //         $a[$j+1] = $b;
  //      }
  //  }
    //print_r($a);
//}
//数据库host:192.168.0.200 用户：cm 密码:123 数据库 demo   表:users
//取出 users表中id<10的记录  
//插入 name=coco age=25 一条记录
//更新 name=coco的记录将，age改为30
//删除 name=coco 的所有记录

/*
查看数据
$servername = "192.168.0.200";
$username = "cm";
$password = "123";
$dbname = "demo";
// 创建连接
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
} 
$sql = "SELECT id, name, age FROM users";
$result = $conn->query($sql);
//$result = mysqli_query($conn,"SELECT * FROM users WHERE id<10");
if ($result->num_rows > 0) {
    // 输出数据
    while($row = mysqli_fetch_assoc($result)){
        echo "id: " . $row["id"]. " - Name: " . $row["name"]. " " . $row["age"]. "<br>";
        echo "<br />";
    }
} else {
   echo "0 结果";
}
$conn->close();
*/
/*
取出id＜10
$servername = "192.168.0.200";
$username = "cm";
$password = "123";
$dbname = "demo";
// 创建连接
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
} 
$sql = "SELECT id, name, age FROM users";
$result = mysqli_query($conn,"SELECT * FROM users WHERE id<10");
    while($row = mysqli_fetch_assoc($result)){
        echo "id: " . $row["id"]. " - Name: " . $row["name"]. " " . $row["age"]. "<br>";
        echo "<br />";
    }
*/
/*
//插入数据
$servername = "192.168.0.200";
$username = "cm";
$password = "123";
$dbname = "demo";

// 创建连接
$conn = new mysqli($servername, $username, $password, $dbname);
// 检测连接
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
} 
/*
$sql = "INSERT INTO users (id, name, age)
VALUES ('10000', 'coco', '25')";

if ($conn->query($sql) === TRUE) {
    echo "新记录插入成功!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>*/
/*
//修改age

$servername = "192.168.0.200";
$username = "cm";
$password = "123";
$dbname = "demo";

// 创建连接
$conn = new mysqli($servername, $username, $password, $dbname);
// 检测连接
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
} 
mysqli_query($conn,"UPDATE users SET age=30
WHERE name='coco' AND id='10000'");
mysqli_close($conn);
*/
//删除

$con=mysqli_connect("192.168.0.200","cm","123","demo");
// 检测连接
if (mysqli_connect_errno())
{
    echo "连接失败: " . mysqli_connect_error();
}

mysqli_query($con,"DELETE FROM users WHERE name='coco'");

mysqli_close($con);

