<?php
  require('dbconnect.php');

  // questionsテーブルとchoicesテーブルを結合
  $stmt = $db->prepare('select questions.id as q_id, questions.text as q_text, choices.id as c_id, choices.text as c_text, correct_flg, answer_type from questions join choices on questions.id = choices.questions_id where questions.id=?');
  if(!$stmt){
    die($db->error);
	}
  $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
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
  <link rel="stylesheet" href="style.css">
  <title>Quiz</title>
</head>
<body>
  <header>
      <h1 class="title">Quiz</h1>
  </header>
  <main>
    <div class="question_box">
      <p><?php echo $rows[0]['q_text']; ?></p>
    </div>    
    <form method="POST" class="answer_box">
      <ul class="choice_box">
        <?php if($rows[0]['answer_type'] != 'textbox' ): ?>
          <?php foreach($rows as $row): ?>
            <li><input type="<?php echo $row['answer_type']?>" name="choice" value=<?php echo $row['c_id']; ?>><?php echo $row['c_text']; ?></li>
            <!-- 選択肢の表示ついでに正解の選択肢を配列に格納 -->
            <?php if($row['correct_flg'] == 1){
                $answer_text[] = $row['c_text'];
                $answer_id[] = $row['c_id'];
            } ?>
          <?php endforeach; ?>
        <?php endif; ?>
      </ul>
    </form>
    <div class="judge_text">
      <?php
        $choice_id = filter_input(INPUT_POST, 'choice', FILTER_SANITIZE_NUMBER_INT, FILTER_REQUIRE_ARRAY);
        $input_text = filter_input(INPUT_POST, 'input_text', FILTER_SANITIZE_SPECIAL_CHARS);
        $result_score = filter_input(INPUT_POST, 'result_score', FILTER_SANITIZE_NUMBER_INT);
        if($input_text){
          //　記述形式（テキストボックス）の正誤判定
          if($rows[0]['c_text'] == $input_text){
            echo "<p class='correct'>正解</p>";
            $result_score ++;
          }else{
            echo "正解は「" . htmlspecialchars($rows[0]['c_text']) . "」";
          }
        // 選択形式（ラジオボタン、チェックボックス）の正誤判定
        }elseif($choice_id == $answer_id){
          echo "<p class='correct'>正解</p>";
          $result_score ++;
        }else{
          echo "正解は";
          foreach ($answer_text as $text){
            echo "「" . htmlspecialchars($text) . "」";
          } 
        }
        
      ?>
    </div>

    <!-- 次の問題のidを取得して$next_idに格納 -->
    <?php 
      $stmt = $db->prepare('select MIN(id) from questions where id > ?');
      if(!$stmt){
        die($db->error);
      }
      $stmt->bind_param('i', $id);
      $result = $stmt->execute();
      // 問題(レコード)が最後の場合、結果はnullになるので分岐処理
      if(!$result){
        die($db->error);
      }elseif($result != null){
        $stmt->bind_result($next_id);
        $stmt->fetch();
     }
    ?>

    <!-- 次の問題(レコード)の有無で表示ボタンを変える -->
    <?php if($next_id): ?>
      <form method="POST" action="quiz.php?id=<?php echo $next_id; ?>">
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
