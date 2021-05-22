<?php
session_start();
include("functions.php");
check_session_id();

if (
  !isset($_POST['todo']) || $_POST['todo'] == '' ||
  !isset($_POST['deadline']) || $_POST['deadline'] == ''
) {
  echo json_encode(["error_msg" => "no input"]);
  exit();
}

$todo = $_POST['todo'];
$deadline = $_POST['deadline'];


// ここからファイルアップロード&DB登録の処理を追加しよう！！！
if (isset($_FILES['upfile']) && $_FILES['upfile']['error'] == 0) {
  // 送信が正常に行われたときの処理（この後記述）
  $uploaded_file_name = $_FILES['upfile']['name']; //ファイル名の取得
  $temp_path = $_FILES['upfile']['tmp_name']; //tmpフォルダの場所
  $directory_path = 'upload/'; //アップロード先ォルダ

  $extension = pathinfo($uploaded_file_name, PATHINFO_EXTENSION);
  $unique_name = date('YmdHis').md5(session_id()) . "." . $extension;
  $filename_to_save = $directory_path . $unique_name;
  if (is_uploaded_file($temp_path)) {
    if (move_uploaded_file($temp_path, $filename_to_save)) {
    chmod($filename_to_save, 0644); // 権限の変更
   // 今回は権限を変更するところまで
    } else {
    exit('Error:アップロードできませんでした'); // 画像の保存に失敗
    }
   } else {
    exit('Error:画像がありません'); // tmpフォルダにデータがない
   }
 } else {
  // 送られていない，エラーが発生，などの場合
  exit('Error:画像が送信されていません');
 } 


//  db接続
$pdo = connect_to_db();
// idを指定して更新するSQLを作成（UPDATE文）
$sql = 'INSERT INTO works(id, date, start_time, end_time, break_time,image, comment) VALUES(NULL, :date, :start_time, :end_time, :break_time,:image, :comment)';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':date', $date, PDO::PARAM_STR); 
$stmt->bindValue(':start_time', $start_time, PDO::PARAM_STR); 
$stmt->bindValue(':end_time', $end_time, PDO::PARAM_STR); 
$stmt->bindValue(':break_time', $break_time, PDO::PARAM_STR); 
$stmt->bindValue(':image', $filename_to_save, PDO::PARAM_STR); 
$stmt->bindValue(':comment', $comment, PDO::PARAM_STR); 

$status = $stmt->execute();

if ($status == false) {
  $error = $stmt->errorInfo();
  echo json_encode(["error_msg" => "{$error[2]}"]);
  exit();
} else {
  header("Location:todo_input.php");
  exit();
}