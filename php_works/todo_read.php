<?php

session_start();
include("functions.php");
check_session_id();

// DB接続
$pdo = connect_to_db();

// データ取得SQL作成
$sql = 'SELECT * FROM works LEFT OUTER JOIN (SELECT todo_id, COUNT(id) AS cnt FROM like_table GROUP BY todo_id) AS likes ON works.id = likes.todo_id';

// SQL準備&実行
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

// データ登録処理後
if ($status==false) {
  $error = $stmt->errorInfo();
  echo json_encode(["error_msg" => "{$error[2]}"]);
  exit();
    // 失敗時􏰂エラー出力
   
   } else {
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC); 
  $output = "";
  $user_id = $_SESSION['id'];


  foreach ($result as $record) {
  $output .= "<tr>";
  $output .= "<td>{$record["date"]}</td>"; 
  $output .= "<td>{$record["start_time"]}</td>"; 
  $output.= "<td>{$record["end_time"]}</td>"; 
  $output.= "<td>{$record["break_time"]}</td>"; 
  $output.= "<td>{$record["comment"]}</td>"; 
  $output .= "<td><a href='like_create.php?user_id={$user_id}&todo_id={$record["id"]}'>like{$record["cnt"]} </a> </td>";
  $output .= "<td><a href='todo_edit.php?id={$record["id"]}'>edit</a></td>";
  $output .= "<td><a href='todo_delete.php?id={$record["id"]}'>delete</a></td>";
  $output .= "<td><img src='{$record["image"]}' height=150px></td>";
  $output .= "</tr>";
  } }


  // $valueの参照を解除する．解除しないと，再度foreachした場合に最初からループしない
  // 今回は以降foreachしないので影響なし
  unset($value);

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>DB連携型todoリスト（一覧画面）</title>
</head>

<body>
  <fieldset>
    <legend>勤怠管理リスト（一覧画面）</legend>
    <a href="todo_input.php">入力画面</a>
    <table>
      <thead>
        <tr>
          <th>日にち</th>
          <th>始業時刻</th>
          <th>終業時刻</th>
          <th>休憩</th>
          <th>コメント</th>
        </tr>
      </thead>
      <tbody>
        <!-- ここに<tr><td>deadline</td><td>todo</td><tr>の形でデータが入る -->
        <?= $output ?>
      </tbody>
    </table>
  </fieldset>
</body>

</html>