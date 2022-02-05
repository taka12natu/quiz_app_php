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
  $stmt = $db->prepare('update choices set text=?, correct_flg=? where id=?');
  if(!$stmt){
    die($db->error);
  } 
  $c_texts = filter_input(INPUT_POST, 'c_texts', FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY);
  $c_ids = filter_input(INPUT_POST, 'c_ids', FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY);
  $c_array = array_combine($c_ids, $c_texts);
  // 正解flgを入れた問題IDが配列で格納される
  $correct_flg_order = filter_input(INPUT_POST, 'check', FILTER_SANITIZE_NUMBER_INT, FILTER_REQUIRE_ARRAY);
  $cnt = 0;
   foreach ($c_array as $c_id => $c_text){
    // 正解フラグの設定
    $correct_flg = 0;
    // foreachの要素よりも$correct_flg_orderの要素の方が少ないため、issetで変数の存在確認をしてエラー回避
    if(isset($correct_flg_order[$cnt])){
      if($c_id == $correct_flg_order[$cnt]){
        $correct_flg = 1;
        $cnt++;
      }
    }
    $stmt->bind_param('sii', $c_text, $correct_flg, $c_id);
    $success = $stmt->execute();
    if(!$success){
      die($db->error);
    }
  }
?>

<p>更新しました</p>
<div><a href="detail.php?id=<?php echo $q_id ?>">戻る</a></div>