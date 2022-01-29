<!-- detail.phpのようにテーブル結合でコード簡略化する -->

<!-- questionsテーブルから問題文を抽出 -->
<?php
  require('dbconnect.php');
  $stmt = $db->prepare('select * from questions where id=?');
  $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
  $stmt->bind_param('i', $id);
  $stmt->execute();
  $stmt->bind_result($id, $text);
  $stmt->fetch();
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
    <div class="question_box">
      <p><?php echo $text; ?></p>
    </div>
    <?php 
      require('dbconnect.php');
      $choice = $db->prepare('select * from choices where questions_id=?');
      $question_id = $id;
      $choice->bind_param('i', $question_id);
      $choice->execute();
      $choice->bind_result($choice_id, $question_id, $c_text, $correct_flg);
    ?>
    
    <form method="POST" class="answer_box">
      <ul class="choice_box">
        <?php while($choice->fetch()): ?>
          <li><input type="radio" name="choice" value=<?php echo $choice_id; ?>><?php echo $c_text; ?></li>
          <?php if($correct_flg == 1){
              $answer_text = $c_text;
          }
          ?>
        <?php endwhile; ?>
      </ul>
    </form>
    <div class="judge_text">
      <?php
        $c_id = filter_input(INPUT_POST, 'choice', FILTER_SANITIZE_NUMBER_INT);
        $a_id = filter_input(INPUT_POST, 'answer', FILTER_SANITIZE_NUMBER_INT);
        $result_score = filter_input(INPUT_POST, 'result_score', FILTER_SANITIZE_NUMBER_INT);
        if ($c_id == $a_id) {
          echo "<p class='correct'>正解</p>";
          $result_score ++;
        }else{
          echo "<p class='incorrect'>不正解</p>正解は" . $answer_text;

        };
      ?>
    </div>
    <!-- 問題数をカウント -->
    <?php
    require('dbconnect.php');
    $counts = $db->query('select count(*) as cnt from questions');
    $count = $counts->fetch_assoc();
    ?>
    <!-- 現在が最終問題か次も問題があるかどうかで分岐 -->
    <?php if($id < $count['cnt']): ?>
      <form method="POST" action="quiz.php?id=<?php echo $id = $id+1; ?>">
        <input type="submit" value="次の問題" class="button">
        <input type="hidden" name="result_score" value=<?php echo $result_score; ?>>
      </form>
    <?php else: ?>
      <form method="POST" action="result.php">
        <input type="submit" value="結果" class="button">
        <input type="hidden" name="result_score" value=<?php echo $result_score; ?>>
      </form>
    <?php endif ?>
  </main>
</body>
</html>
