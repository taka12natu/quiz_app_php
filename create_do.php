<?php 
  require('dbconnect.php');
  // 問題文を登録
  $stmt = $db->prepare('INSERT INTO questions(text) VALUES(?)');
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
  $stmt = $db->prepare('INSERT INTO choices(questions_id, text, correct_flg, answer_type) VALUES(?,?,?,?)');
  if(!$stmt){
    die($db->error);
  } 
  $c_texts = filter_input(INPUT_POST, 'c_texts', FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
  // 正解に選択した問題の番号(1~)が格納される
  $correct_flg_order = filter_input(INPUT_POST, 'check', FILTER_SANITIZE_NUMBER_INT, FILTER_REQUIRE_ARRAY);
  $answer_type = filter_input(INPUT_POST, 'form_select', FILTER_SANITIZE_SPECIAL_CHARS);
  if($answer_type == 'textbox'){
    $correct_flg_order[0] = 1;
  }
  // 選択肢の配列の整理（※未選択の問題形式の選択肢も空要素で入っているため）
  $c_texts = array_filter($c_texts); //空要素の削除
  $c_texts = array_values($c_texts); //インデックス番号の振り直し
  $cnt = 0; 
  // 選択肢毎にDBに登録
  for ($i=0; $i < count($c_texts); $i++){
    // $correct_flg_orderに正解の選択肢の番号が配列で入っているため、番号を比較し正解フラグを設定
     // foreachの要素よりも$correct_flg_orderの要素の方が少ないため、issetで変数の存在確認をしてエラー回避
    if(isset($correct_flg_order[$cnt])){
      $flg_order = $correct_flg_order[$cnt];
    }
    if($i+1 == $flg_order){
      $correct_flg = 1;
      $cnt++;
    }else{
      $correct_flg = 0;
    }
    $stmt->bind_param('isis', $q_id, $c_texts[$i], $correct_flg, $answer_type);
    $success = $stmt->execute();
    if(!$success){
      die($db->error);
    }
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
    <p>登録しました</p>
    <a href="detail.php?id=<?php echo $q_id ?>" class="back margin_top20">戻る</a>
  </main>
</body>
</html>
