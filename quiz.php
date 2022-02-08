<?php
  session_start();
  require('dbconnect.php');
  // questionsテーブルとchoicesテーブルを結合して、抽出したデータを$rowsに格納
  require('tableconnect.php');
  // １問目と２問目以降で分岐処理
  if($id == $_SESSION['question_order'][0]){
    $result_score = 0;
    $question_order = 0; 
   }else{
    // 2問目以降 check.phpより受け取る
    // 問題idが入った配列のkey
    $question_order = filter_input(INPUT_POST, 'question_order', FILTER_SANITIZE_NUMBER_INT);
    // 正解数
    $result_score = filter_input(INPUT_POST, 'result_score', FILTER_SANITIZE_NUMBER_INT);  
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <title>Quiz</title>
</head>
<body>
  <header>
    <h1 class="title">Quiz</h1>
  </header>
  <main>
  <?php echo $question_order + 1 . "問目"  ?>
  <!-- 問題文 -->
  <div class="question_box">
    <p><?php echo $rows[0]['q_text']; ?></p>
  </div>
  <!-- 選択肢 -->
  <form method="POST" action="check.php" name="answer_box" onsubmit="return false" class="answer_box">
    <ul class="choice_box">
      <!-- 記述回答（テキストボックス） -->
      <?php if($rows[0]['answer_type'] == 'textbox' ): ?>
        <input type="text" name="input_text" id="textbox_text"></input>
      <!-- 選択形式（ラジオボタン、チェックボックス） -->
      <?php else: ?>
        <?php foreach($rows as $row): ?>
          <li><input type="<?php echo $row['answer_type']?>" name="choice[]" value=<?php echo $row['c_id']; ?>><?php echo $row['c_text']; ?></li>
        <?php endforeach; ?>
      <?php endif; ?>
    </ul>
    <!-- 問題idの配列key,正解数をcheck.phpに渡す -->
    <input type="hidden" name="question_order" value=<?php echo $question_order; ?>>
    <input type="hidden" name="result_score" value=<?php echo $result_score; ?>>
    <?php  ?>
    <input type="submit" id="send" class="button" value="送信">
    <!-- 未選択時に送信を行わずメッセージ表示 -->
    <script>
      let submitButton = document.getElementById('send');
      submitButton.addEventListener('click', function() {
          document.answer_box.submit();
        });
    </script>
  </form>
  </main>
</body>
</html>
