<?php
  require('dbconnect.php');
 // questionsテーブルとchoicesテーブルを結合して、抽出したデータを$rowsに格納
 require('tableconnect.php');
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
<p>問題形式: 
  <?php 
    if ($rows[0]['answer_type'] == 'radio'){
      echo "単一回答（ラジオボタン）";
    }else if($rows[0]['answer_type'] == 'checkbox'){
      echo "複数回答（チェックボックス）"; 
    }else if($rows[0]['answer_type'] == 'textbox'){
      echo "記述回答（テキストボックス）"; 
    } 
  ?>
</p>
<!-- テキストボックスだと選択肢がないので、表記を分岐処理 -->
<?php if($rows[0]['answer_type'] == 'textbox'): ?>
  <p>正解: 
    <?php echo "「" . htmlspecialchars($rows[0]['c_text']) . "」"; ?>
  </p>
<?php else: ?>
  <p>選択肢</p>
  <ul>  <!-- 選択肢の表示 -->
    <?php foreach ($rows as $row): ?>
      <li> <?php echo htmlspecialchars($row['c_text']); ?> </li>
    <?php endforeach ?>
  </ul>
  <p>正解: 
    <?php // 正解の選択肢を表示
      foreach ($rows as $row){
        if($row['correct_flg'] == 1){
          echo "「" . htmlspecialchars($row['c_text']) . "」";
        }
      }    
    ?>
  </p>
<?php endif; ?>
<div>
    <a href="edit.php?id=<?php echo $id ?>">編集</a>
    <a href="delete.php?id=<?php echo $id ?>">削除</a>
    <a href="question_list.php">戻る</a>
</div>
</body>
</html>