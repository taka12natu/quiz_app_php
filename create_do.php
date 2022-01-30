<?php 
  require('dbconnect.php');
  // 問題文を登録
  $stmt = $db->prepare('insert into questions(text) values(?)');
  if(!$stmt){
    die($db->error);
  }
  $q_text = filter_input(INPUT_POST, 'q_text', FILTER_SANITIZE_SPECIAL_CHARS);
  $stmt->bind_param('s', $q_text);
  $success = $stmt->execute();
  if(!$success){
    die($db->error);
  }
  // 登録した問題のidを取得
  $q_id = $db->insert_id;

   // 選択肢を登録
  $stmt_2 = $db->prepare('insert into choices(questions_id, text, correct_flg) values(?,?,?)');
  if(!$stmt_2){
    die($db->error);
  } 
  $c_texts = filter_input(INPUT_POST, 'c_texts', FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY);
  $correct_flg_order = filter_input(INPUT_POST, 'check', FILTER_SANITIZE_NUMBER_INT);
  $i = 1;
  foreach ($c_texts as $c_text){
    if($i == $correct_flg_order){
      $correct_flg = 1;
    }else{
      $correct_flg = 0;
    }
    $stmt_2->bind_param('isi',$q_id, $c_text, $correct_flg);
    $success = $stmt_2->execute();
    if(!$success){
      die($db->error);
    }
    $i++;
  }
?>

<p>登録しました</p>
<div><a href="detail.php?id=<?php echo $q_id ?>">戻る</a></div>