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
    <link rel="stylesheet" href="./css/style.css">
    <title>Document</title>
</head>
<body>
  <header>
    <h1 class="title">Quiz</h1>
  </header>
  <main>
    <div class="detail_box">
      <h2>問題内容</h2>
      <p class="detail_box_text">問題文: 
        <?php // 問題文の表示
          echo htmlspecialchars($rows[0]['q_text']); ?> 
      </p>
      <p class="detail_box_text">問題形式: 
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
        <p class="detail_box_text">正解: 
          <?php echo "「" . htmlspecialchars($rows[0]['c_text']) . "」"; ?>
        </p>
      <?php else: ?>
        <p>選択肢:</p>
        <ul>  <!-- 選択肢の表示 -->
          <?php foreach ($rows as $row): ?>
            <li> <?php echo htmlspecialchars($row['c_text']); ?> </li>
          <?php endforeach ?>
        </ul>
        <p class="detail_box_text">正解: 
          <?php // 正解の選択肢を表示
            foreach ($rows as $row){
              if($row['correct_flg'] == 1){
                echo "「" . htmlspecialchars($row['c_text']) . "」";
              }
            }    
          ?>
        </p>
      <?php endif; ?>
      <div class="btn_box">
          <a href="edit.php?id=<?php echo $id ?>">編集</a>
          <a href="delete.php?id=<?php echo $id ?>" class="delete_btn" onclick="return confirm('削除しますか？')">削除</a>
      </div>
        <a href="question_list.php" class="back">戻る</a>
    </div>
  </main>

</body>
</html>