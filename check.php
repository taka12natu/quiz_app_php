<?php
  session_start();
  require('dbconnect.php');
  // questionsテーブルとchoicesテーブルを結合して、抽出したデータを$rowsに格納
  $stmt = $db->prepare('SELECT questions.id AS q_id, questions.text AS q_text, choices.id AS c_id, choices.text AS c_text, correct_flg, answer_type FROM questions JOIN choices ON questions.id = choices.questions_id WHERE questions.id=?');
  if(!$stmt){
    die($db->error);
	}
  $question_order = filter_input(INPUT_POST, 'question_order', FILTER_SANITIZE_NUMBER_INT);
  $id = $_SESSION['question_order'][$question_order];
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
  <link rel="stylesheet" href="./css/style.css">
  <title>Quiz</title>
</head>
<body>
  <header>
      <h1 class="title">Quiz</h1>
  </header>
  <main>
    <?php echo $question_order + 1 . "問目"  ?>
    <div class="question_box">
      <p><?php echo $rows[0]['q_text']; ?></p>
    </div>    
    <form method="POST" class="answer_box">
      <!-- 選択形式（ラジオボタン、チェックボックス） -->
      <?php if($rows[0]['answer_type'] != 'textbox' ): ?>
        <?php foreach($rows as $row): ?>
          <?php if($row['correct_flg'] == 1): ?>
            <?php // 正解の選択肢を配列に格納
              $answer_text[] = $row['c_text'];
              $answer_id[] = $row['c_id']; 
            ?>
            <!-- 正解の選択肢は枠線を変えるためにclassを追記 -->
            <label class="label correct_color"><input type="<?php echo $row['answer_type']?>" name="choice" value=<?php echo $row['c_id']; ?> class="btn_display" ><?php echo $row['c_text']; ?></label>
          <?php else: ?>
            <label class="label"><input type="<?php echo $row['answer_type']?>" name="choice" value=<?php echo $row['c_id']; ?> class="btn_display" ><?php echo $row['c_text']; ?></label>
          <?php endif; ?>
        <?php endforeach; ?>
      <?php endif; ?>
    </form>
    <div class="judge_text">
      <?php
        $choice_id = filter_input(INPUT_POST, 'choice', FILTER_SANITIZE_NUMBER_INT, FILTER_REQUIRE_ARRAY);
        $input_text = filter_input(INPUT_POST, 'input_text', FILTER_SANITIZE_SPECIAL_CHARS);
        $result_score = filter_input(INPUT_POST, 'result_score', FILTER_SANITIZE_NUMBER_INT);
        if($rows[0]['answer_type'] == 'textbox'){
          //　記述形式（テキストボックス）の正誤判定
          if($rows[0]['c_text'] == $input_text){
            echo "<p class='correct'>正解</p>";
            $result_score ++;
          }else{
            echo "不正解！　正解は「" . htmlspecialchars($rows[0]['c_text']) . "」";
          }
        // 選択形式（ラジオボタン、チェックボックス）の正誤判定
        }elseif($choice_id == $answer_id){
          echo "<p class='correct'>正解</p>";
          $result_score ++;
        }else{
          echo "不正解！　正解は";
          foreach ($answer_text as $text){
            echo "「" . htmlspecialchars($text) . "」";
          } 
        }
      ?>
    </div>

    <!-- 次の問題のidを取得して$next_idに格納 -->
    <?php $next_id = $_SESSION['question_order'][$question_order+1];?>

    <!-- 次の問題(レコード)の有無で表示ボタンを変える -->
    <?php if($next_id): ?>
      <form method="POST" action="quiz.php?id=<?php echo $next_id; ?>">
        <input type="submit" value="次の問題" class="button">
        <!-- 正解数をquiz.phpに渡す -->
        <input type="hidden" name="result_score" value=<?php echo $result_score; ?>>
        <!-- 次の問題idの配列keyを渡す -->
        <input type="hidden" name="question_order" value=<?php echo $question_order+1; ?>>
      </form>
    <?php else: ?>
      <form method="POST" action="result.php">
        <input type="submit" value="結果" class="button result_btn">
        <input type="hidden" name="result_score" value=<?php echo $result_score; ?>>
      </form>
    <?php endif ?>
  </main>
</body>
</html>
