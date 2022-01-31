<?php
  require('dbconnect.php');

  // questionsテーブルとchoicesテーブルを結合
  $stmt = $db->prepare('select questions.id as q_id, questions.text as q_text, choices.id as c_id, choices.text as c_text, correct_flg from questions join choices on questions.id = choices.questions_id where questions.id=?');
  if(!$stmt){
    die($db->error);
	}
  $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
  $stmt->bind_param('i', $id);
  $stmt->execute(); 

  // 抽出したデータを$rowsに格納
  $result = $stmt->get_result();
  $rows = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<p>
  <?php // 問題文の表示
    echo htmlspecialchars($rows[0]['q_text']); ?> 
</p>
<p>選択肢</p>
<ul>  <!-- 選択肢の表示 -->
  <?php foreach ($rows as $row): ?>
    <li> <?php echo htmlspecialchars($row['c_text']); ?> </li>
  <?php endforeach ?>
</ul>
<p>
  <?php // 正解の選択肢を表示
    foreach ($rows as $row){
      if($row['correct_flg'] == 1){
        echo "正解：" . htmlspecialchars($row['c_text']);
      }
    }    
  ?>
</p>
<div>
    <a href="edit.php?id=<?php echo $id ?>">編集</a>
    <a href="delete.php?id=<?php echo $id ?>">削除</a>
    <a href="question_list.php">戻る</a>
</div>
</body>
</html>