<!-- detail.phpのようにテーブル結合でコード簡略化する -->

<!-- questionsテーブルから問題文を抽出 -->
<?php
  require('dbconnect.php');
  $stmt = $db->prepare('select * from questions where id=?');
  $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
  $stmt->bind_param('i', $id);
  $stmt->execute();
  $stmt->bind_result($id, $text);
  $result = $stmt->fetch();
?>

<!-- 正解数をcheck.phpから受け取る -->
<?php 
  if(isset($_POST['result_score'])){
      $result_score = filter_input(INPUT_POST, 'result_score', FILTER_SANITIZE_NUMBER_INT);
  }else{
      $result_score = 0;
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
  <!-- 問題文 -->
  <div class="question_box">
    <p><?php echo $text; ?></p>
  </div>
  <!-- choicesテーブルから問題の選択肢を抽出 -->
  <?php 
    require('dbconnect.php');
    $choice = $db->prepare('select * from choices where questions_id=?');
    $question_id = $id;
    $choice->bind_param('i', $question_id);
    $choice->execute();
    $choice->bind_result($choice_id, $question_id, $c_text, $correct_flg);
  ?>
  <!-- 選択肢 -->
  <form method="POST" action="check.php" name="answer_box" onsubmit="return false" class="answer_box">
    <ul class="choice_box">
      <?php while($choice->fetch()): ?>
        <li><input type="radio" name="choice" value=<?php echo $choice_id; ?>><?php echo $c_text; ?></li>
        <!-- 正解の選択肢のidとテキストを変数に格納 -->
        <?php if($correct_flg == 1){
          $answer_id = $choice_id; 
          $answer_text = $c_text;
        }
        ?>
      <?php endwhile; ?>
    </ul>
    <!-- 正解の選択肢のid,問題のid,正解数をcheck.phpに渡す -->
    <input type="hidden" name="answer" value=<?php echo $answer_id; ?>>
    <input type="hidden" name="id" value=<?php echo $id; ?>>
    <input type="hidden" name="result_score" value=<?php echo $result_score; ?>>
    <input type="submit" id="send" class="button" value="送信">
    <!-- 未選択時に送信を行わずメッセージ表示 -->
    <script>
      let submitButton = document.getElementById('send');
      submitButton.addEventListener('click', function() {
        if (document.answer_box.choice.value == "") {
          alert("選択してください");
        } else {
          document.answer_box.submit();
        }
      })
    </script>
  </form>
  </main>
</body>
</html>
