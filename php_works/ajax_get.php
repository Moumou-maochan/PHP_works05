<?php
// 関数ファイル読み込み処理を記述（認証関連は省略でOK）
// DB接続の処理を記述
$search_word = $_GET["searchword"]; // GETのデータ受け取り
$sql = "SELECT * FROM works
 WHERE date LIKE '%{$search_word}%'"; // LIKEを使って検索
// SQL実行の処理を記述
if ($status == false) {
 // エラー処理を記述
} else {
 $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
 echo json_encode($result); // JSON形式にして出力
 exit();
}