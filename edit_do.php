<?php 
  require('dbconnect.php');
  // 問題文を更新
  $stmt = $db->prepare('update questions set text=? where id=?');
  if(!$stmt){
    die($db->error);
  }
  $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
  $q_text = filter_input(INPUT_POST, 'q_text', FILTER_SANITIZE_SPECIAL_CHARS);
  $stmt->bind_param('si', $q_text, $id);
  $success = $stmt->execute();
  if(!$success){
    die($db->error);
  }
  // 選択肢を更新
  $stmt_2 = $db->prepare('update choices set text=? where id=?');
  if(!$stmt_2){
    die($db->error);
  } 
  $c_texts = filter_input(INPUT_POST, 'c_texts', FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY);
  $c_ids = filter_input(INPUT_POST, 'c_ids', FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY);
  $c_array = array_combine($c_ids, $c_texts);
   foreach ($c_array as $c_id => $c_text){
    $stmt_2->bind_param('si', $c_text, $c_id);
    $success = $stmt_2->execute();
    if(!$success){
      die($db->error);
    }
  } 

/* 正解フラグの更新をどうするか　選択肢をプルダウンに入れて選択する？ */
?>

<p>更新しました</p>
<div><a href="edit.php?id=<?php echo $id ?>">戻る</a></div>