<?php

session_start();
include("functions.php");
check_session_id();
$id = $_GET["id"];

$pdo = connect_to_db();

// データ取得SQL作成
$sql = 'SELECT * FROM works WHERE id=:id';

// SQL準備&実行
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

// データ登録処理後
if ($status == false) {
  // SQL実行に失敗した場合はここでエラーを出力し，以降の処理を中止する
  $error = $stmt->errorInfo();
  echo json_encode(["error_msg" => "{$error[2]}"]);
  exit();
} else {
  // 正常にSQLが実行された場合は指定の11レコードを取得
  // fetch()関数でSQLで取得したレコードを取得できる
  $record = $stmt->fetch(PDO::FETCH_ASSOC);
}


?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>DB連携型todoリスト（入力画面）</title>
</head>

<body>
  <form action="todo_create.php" method="POST">
  <input type="hidden" name="id" value="<?=$record['id']?>">
    <fieldset>
      <legend>勤怠管理（入力画面）</legend>
      <a href="todo_read.php">一覧画面</a>
      <div>
       <input type="date" name="date" value="<?= $record["date"] ?>">
      </div>
      <div>
        <input type="time" name="start_time" value="<?= $record["start_time"] ?>">
      </div>
      <div>
        <input type="time" name="end_time" value="<?= $record["end_time"] ?>">
      </div>
      <div>
        <input type="time" name="break_time" value="<?= $record["break_time"] ?>">
      </div>
      <div>
        <textarea name="comment" id="" cols="30" rows="10" value="<?= $record["comment"] ?>"></textarea>
      </div>
      <div>
        <button>submit</button>
      </div>
    </fieldset>
  </form>

</body>

</html>