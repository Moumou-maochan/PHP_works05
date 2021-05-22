<?php

session_start();
include("functions.php");
check_session_id();

if(
  !isset($_POST['date']) || $_POST['date']=='' ||
  !isset($_POST['start_time']) || $_POST['start_time']==''||
  !isset($_POST['end_time']) || $_POST['end_time']==''||
  !isset($_POST['break_time']) || $_POST['break_time']==''||
  !isset($_POST['comment']) || $_POST['comment']==''
){
   // 項目が入力されていない場合はここでエラーを出力し，以降の処理を中止する
   echo json_encode(["error_msg" => "no input"]);
   exit();
}
$date = $_POST['date'];
$start_time = $_POST['start_time'];
$end_time = $_POST['end_time'];
$break_time = $_POST['break_time'];
$comment = $_POST['comment'];


// DB接続
$pdo = connect_to_db();

// データ登録SQL作成
// `created_at`と`updated_at`には実行時の`sysdate()`関数を用いて実行時の日時を入力する
$sql = 'INSERT INTO works(id, date, start_time, end_time, break_time, comment) VALUES(NULL, :date, :start_time, :end_time, :break_time, :comment)';

// SQL準備&実行
$stmt = $pdo->prepare($sql);
// バインド変数に格納（セキュリティ）
$stmt->bindValue(':date', $date, PDO::PARAM_STR); 
$stmt->bindValue(':start_time', $start_time, PDO::PARAM_STR); 
$stmt->bindValue(':end_time', $end_time, PDO::PARAM_STR); 
$stmt->bindValue(':break_time', $break_time, PDO::PARAM_STR); 
$stmt->bindValue(':comment', $comment, PDO::PARAM_STR); 
$status = $stmt->execute(); // SQLを実行


// データ登録処理後
if ($status == false) {
  // SQL実行に失敗した場合はここでエラーを出力し，以降の処理を中止する
  $error = $stmt->errorInfo();
  echo json_encode(["error_msg" => "{$error[2]}"]);
  exit();
} else {
  // 正常にSQLが実行された場合は入力ページファイルに移動し，入力ページの処理を実行する
  header("Location:todo_input.php");
  exit();
}