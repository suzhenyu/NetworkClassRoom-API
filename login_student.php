<?php
/**
*  http://127.0.0.1/login_student.php
*  这个接口是用来学生登陆。
*/
require_once('./response.php');
require_once('./db.php');

if (!isset($_GET['account'])) {
	echo "Please enter the account";
	exit;
}
if (!isset($_GET['password'])) {
	echo "Please enter the password";
	exit;
}

$account = $_GET['account'];
$password = $_GET['password'];

$sql = "SELECT * FROM `student` 
		WHERE `student_account` = '$account' && `student_password` = '$password'";

try {
	$connect = Db::getInstance()->connect();
} catch(Exception $e) {
	return Response::json(403, '数据库链接失败');
}

$result = mysql_query($sql, $connect); 
$info = mysql_fetch_assoc($result);

if($info) {
	return Response::json(200, '学生数据获取成功', $info);
} else {
	return Response::json(400, '学生数据获取失败', $info);
}
