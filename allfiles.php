<?php

require_once('./response.php');
require_once('./db.php');

try {
	$connect = Db::getInstance()->connect();
} catch(Exception $e) {
	return Response::json(403, '数据库链接失败');
}

$sql = "SELECT * FROM `file`";

$result = mysql_query($sql, $connect);

$files = array();		
while ($file = mysql_fetch_assoc($result)) {
	$files[] = $file;
}

if ($files) {
	return Response::json(200, "文件数据获取成功", $files);
}else {
	return Response::json(400, "文件数据获取失败", $files);
}