<?php 
  require('dbconnect.php');
  // 問題文を更新
  $stmt = $db->prepare('update questions set text=? where id=?');
  if(!$stmt){
    die($db->error);
  }
  $q_id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
  $q_text = filter_input(INPUT_POST, 'q_text', FILTER_SANITIZE_SPECIAL_CHARS);
  $stmt->bind_param('si', $q_text, $q_id);
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
  // 元の正解フラグをfalseにする
  $stmt_3 = $db->prepare('update choices set correct_flg=0 where questions_id=? and correct_flg=1');
  if(!$stmt_3){
    die($db->error);
  } 
  $stmt_3->bind_param('i', $id);
  $success = $stmt_3->execute();
  if(!$success){
    die($db->error);
  }
  // 正解フラグを設定する
  $stmt_4 = $db->prepare('update choices set correct_flg=1 where id=?');
  if(!$stmt_4){
    die($db->error);
  }
  // 正解フラグを設定するidを取得
  $check = filter_input(INPUT_POST, 'check', FILTER_SANITIZE_NUMBER_INT);
  if(!$check){
    echo "正解が設定されていません"; // 更新前に処理したい
  }
  $stmt_4->bind_param('i', $check);
  $success = $stmt_4->execute();
  if(!$success){
    die($db->error);
  }
?>

<p>更新しました</p>
<div><a href="edit.php?id=<?php echo $id ?>">戻る</a></div>