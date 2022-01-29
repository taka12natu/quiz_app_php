<?php 
  require('dbconnect.php');

  $stmt = $db->prepare('delete from questions where id=?');
  if(!$stmt){
    die($db->error);
  }
  $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
  $stmt->bind_param('i', $id);
  $success = $stmt->execute();
  if(!$success){
    die($db->error);
  }
?>

<p>削除しました</p>
<div><a href="question_list.php">一覧に戻る</a></div>