<?php 
  require('dbconnect.php');

  $stmt = $db->prepare('DELETE questions,choices FROM questions LEFT JOIN choices ON questions.id = choices.questions_id WHERE questions.id=?');
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
