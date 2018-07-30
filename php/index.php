<?php
//编写接口地址为 /api/shop/userSaleAmount 请求方式为GET 返回json数据  各业务员近3个月的销售额
//编写接口地址为 /api/shop/amount 请求方式为GET 返回json数据    店铺最近3个月的总销售额与订单总价


//注册接口 /api/register 请求方式为POST  注册填手机与密码。
//登录接口 /api/login 请求方式为POST     获取post得数据 $_POST['mobile']/$_POST['password']
//注册与登录页面通过jqury的$.post与接口进行数据通信。


switch ($_SERVER['REQUEST_URI']) {
    // case '/api/shop/salesAmountInMay':
    //     $shop = new Shop;
    //     $ret = $shop->salesAmountInMay();
    //     echo json_encode($ret);
    //     break;
    // case '/api/shop/salesAmountInJune':
    //     $shop = new Shop;
    //     $ret = $shop->salesAmountInJune();
    //     echo json_encode($ret);
    //     break;
    case '/api/register':
        //var_dump($_POST);die;
        header("Content-type:text/json;charset=utf-8");
        $name = $_POST['name'];
        $pwd = $_POST['pwd'];
        $pwdConfirm = $_POST['pwdconfirm'];

        if ($name == '') {
            echo jsonResponse(400, '你的用户名不能为空，请重新输入');
            exit;
        }
        if ($pwd == '') {
            echo jsonResponse(400, '你的密码不能为空，请重新输入');
            exit;
        }
        if($pwd != $pwdConfirm){
            echo jsonResponse(400, '你输入的两次密码不一致，请重新输入');
            exit;
        }

        $link = mysqli_connect('192.168.0.200','cm','123','cmcndb');
        mysqli_set_charset($link,'utf8mb4'); //设定字符集

        $insert_sql = "insert into zcdl(username,password)values(? , ? )";
        $stmt = mysqli_prepare($link, $insert_sql);
        mysqli_stmt_bind_param($stmt, 'ss', $name, $pwd);
        $result_insert = mysqli_stmt_execute($stmt);

        if ($result_insert) {
            echo jsonResponse(200, '注册成功');
            exit;
        } else {
            echo jsonResponse(400, '用户已注册');
            exit;
        }
    case '/api/login':
        //var_dump($_POST);die;
        session_start();
        header("Content-type:text/html;charset=utf-8");
        $link = mysqli_connect('192.168.0.200','cm','123','cmcndb');  //链接数据库
        mysqli_set_charset($link ,'utf8'); //设定字符集 
        $name=$_POST['name'];
        $pwd=$_POST['pwd'];
        if($name==''){
            echo "<script>alert('请输入用户名');location='" . $_SERVER['HTTP_REFERER'] . "'</script>";
            exit;
        }
        if($pwd==''){
            echo "<script>alert('请输入密码');location='" . $_SERVER['HTTP_REFERER'] . "'</script>";
            exit;
        }
        $sql_select="select username,password from zcdl where username= ?";      //从数据库查询信息
        $stmt=mysqli_prepare($link,$sql_select);
        mysqli_stmt_bind_param($stmt,'s',$name);
        mysqli_stmt_execute($stmt);
        $result=mysqli_stmt_get_result($stmt);
        $row=mysqli_fetch_assoc($result);
        if($row){
            if($pwd !=$row['password'] || $name !=$row['username']){
                echo "<script>alert('密码错误，请重新输入');location='/dl.html'</script>";
                exit;
            }
            else{
                $_SESSION['username']=$row['username'];
                $_SESSION['id']=$row['id'];
                echo "<script>alert('登录成功');location='/index.html'</script>";
            }
        }else{
            echo "<script>alert('您输入的用户名不存在');location='/dl.html'</script>";
            exit;
        }
    default:
        echo "找不到页面";
        break;
}

function jsonResponse($code = 200, $msg = "", $data = []) {
    $res = ['code'=> $code, 'msg' => $msg, 'data' => $data];
    return json_encode($res);
}

// class Shop {

//     protected $pdo;

//     protected function initDb() {
//         $db = array(
//             'dsn' => 'mysql:host=192.168.0.200;dbname=cmcndb;port=3306;charset=utf8',
//             'username' => 'cm',
//             'password' => '123',
//         );
        
//         //连接
//         $options = array(
//             PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, //默认是PDO::ERRMODE_SILENT, 0, (忽略错误模式)
//             PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // 默认是PDO::FETCH_BOTH, 4
//         );
//         try{
//             $pdo = new PDO($db['dsn'], $db['username'], $db['password'], $options);
//             $this->pdo = $pdo;
//         }catch(PDOException $e){
//             die('数据库连接失败:' . $e->getMessage());
//         }
//     }

//     public function salesAmountInMay() {

//         $this->initDb();

//         $cTime = $this->getCtime();
//         $c1Time = strtotime("-1 months", strtotime(date("Y-m-01 00:00:00")));
//         $c2Time = strtotime("-0 months", strtotime(date("Y-m-01 00:00:00")));
//         $stmt = $this->pdo->query("SELECT SUM(amount) as amount,SUM(totalPrice) as totalPrice,shopUserCode 
//         FROM Orders WHERE shopId=25 and paidTime>$cTime and paidTime<$c1Time GROUP BY shopUserCode");
//         $rows1 = $stmt->fetchAll(); //获取所有

//         $stmt = $this->pdo->query("SELECT SUM(amount) as amount,SUM(totalPrice) as totalPrice,shopUserCode 
//         FROM Orders WHERE shopId=25 and paidTime>$c1Time and paidTime<$c2Time GROUP BY shopUserCode"); //返回一个PDOStatement对象

//         //$row = $stmt->fetch(); //从结果集中获取下一行，用于while循环
//         $rows2 = $stmt->fetchAll(); //获取所有
//         $ret = [$rows1,$rows2];

//         return $ret;
//     }

//     public function salesAmountInJune() {

//         $this->initDb();

//         $cTime = $this->getCtime();
//         $stmt = $this->pdo->prepare("SELECT SUM(amount) as amount,SUM(totalPrice) as totalPrice 
//         FROM Orders WHERE shopId=25 and paidTime>:padiTime");
//         $bindParms = [':padiTime' => $cTime];
//         $stmt->execute($bindParms);
//         return $stmt->fetchAll();
//     }

//     private function getCtime() {
//         return strtotime("-2 months", strtotime(date("Y-m-01 00:00:00")));
//     }
// }
