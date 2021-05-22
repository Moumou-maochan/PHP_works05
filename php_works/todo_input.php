<?php


session_start();
include("functions.php");
check_session_id();

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>DB連携型todoリスト（入力画面）</title>
</head>

<body>
  <form action="todo_create.php" method="POST" enctype="multipart/form-data">
    <fieldset>
      <legend>勤怠管理（入力画面）</legend>
      <a href="todo_read.php">一覧画面</a>
      <div>
       <input type="date" name="date">
      </div>
      <div>
        <input type="time" name="start_time">
      </div>
      <div>
        <input type="time" name="end_time">
      </div>
      <div>
        <input type="time" name="break_time">
      </div>
      <div>
        <textarea name="comment" id="" cols="30" rows="10"></textarea>
      </div>
      <div>
      image: <input type="file" name="upfile" accept="image/*"capture="camera">
      </div>
      <div>
        <button>submit</button>
      </div>
    </fieldset>
  </form>

</body>

</html>