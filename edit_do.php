<?php 
  require('dbconnect.php');
  // 問題文を更新
  $stmt = $db->prepare('UPDATE questions SET text=? WHERE id=?');
  if(!$stmt){
    die($db->error);
  }
  $q_id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
  $q_text = filter_input(INPUT_POST, 'q_text', FILTER_SANITIZE_SPECIAL_CHARS);
  $stmt->bind_param('si', $q_text, $q_id);
  /* 最初の7問は編集できないように設定 */
  if($q_id>7){
    $success = $stmt->execute();
    if(!$success){
      die($db->error);
    }
    // 選択肢を更新
    $stmt = $db->prepare('UPDATE choices SET text=?, correct_flg=? WHERE id=?');
    if(!$stmt){
      die($db->error);
    } 
    $c_texts = filter_input(INPUT_POST, 'c_texts', FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
    $c_ids = filter_input(INPUT_POST, 'c_ids', FILTER_SANITIZE_NUMBER_INT, FILTER_REQUIRE_ARRAY);
    $c_array = array_combine($c_ids, $c_texts);
    $answer_type = filter_input(INPUT_POST, 'answer_type', FILTER_SANITIZE_SPECIAL_CHARS); 
    // 正解flgを入れた問題IDが配列で格納される
    $correct_flg_order = filter_input(INPUT_POST, 'check', FILTER_SANITIZE_NUMBER_INT, FILTER_REQUIRE_ARRAY);
    
    $cnt = 0;
    foreach ($c_array as $c_id => $c_text){
      // 正解フラグの設定 ※テキストボックス（記述形式）を除く
      if($answer_type != "textbox" ){
        $correct_flg = 0;
        // foreachの要素よりも$correct_flg_orderの要素の方が少ないため、issetで変数の存在確認をしてエラー回避
        if(isset($correct_flg_order[$cnt])){
          if($c_id == $correct_flg_order[$cnt]){
            $correct_flg = 1;
            $cnt++;
          }
        }
      }
      $stmt->bind_param('sii', $c_text, $correct_flg, $c_id);
      $success = $stmt->execute();
      if(!$success){
        die($db->error);
      }
    }
    $msg = '更新しました。';
  }else{
      $msg = 'この問題は編集できません。';
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./css/style.css">
  <title>Document</title>
</head>
<body>
  <header>
    <h1 class="title">Quiz</h1>
  </header>
  <main>
    <p><?php echo $msg ?></p>
    <a href="detail.php?id=<?php echo $q_id ?>" class="back margin_top20">戻る</a>
  </main>
</body>
</html>
