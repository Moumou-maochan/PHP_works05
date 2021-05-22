<?php

// 関数ファイルの読み込み
include("functions.php");

$id = $_POST['id'];
$date = $_POST['date'];
$start_time = $_POST['start_time'];
$end_time = $_POST['end_time'];
$break_time = $_POST['break_time'];
$comment = $_POST['comment'];

// DB接続
$pdo = connect_to_db();
// idを指定して更新するSQLを作成（UPDATE文）
$sql = "UPDATE works SET date=:date, start_time=:start_time,end_time=:end_time,break_time=:break_time,comment=:comment,
 updated_at=sysdate() WHERE id=:id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':date', $date, PDO::PARAM_STR); 
$stmt->bindValue(':start_time', $start_time, PDO::PARAM_STR); 
$stmt->bindValue(':end_time', $end_time, PDO::PARAM_STR); 
$stmt->bindValue(':break_time', $break_time, PDO::PARAM_STR); 
$stmt->bindValue(':comment', $comment, PDO::PARAM_STR); 
$status = $stmt->execute();

// 各値をpostで受け取る
if ($status == false) {
    // SQL実行に失敗した場合はここでエラーを出力し，以降の処理を中止する
    $error = $stmt->errorInfo();
    echo json_encode(["error_msg" => "{$error[2]}"]);
    exit();
   } else {
    // 正常に実行された場合は一覧ページファイルに移動し，処理を実行する
    header("Location:todo_read.php");
    exit();
   }