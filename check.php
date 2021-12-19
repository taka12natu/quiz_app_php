<?php
    require('dbconnect.php');
    /* SQLをセット */
    $stmt = $db->prepare('select * from questions where id=?');
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    /* prepare()内の?に入れる値を設定する */
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->bind_result($id, $text);
    $stmt->fetch();

    require('dbconnect.php');
    $counts = $db->query('select count(*) as cnt from questions');
    $count = $counts->fetch_assoc();

    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type="text/javascript" src="script.js"></script>
    <title>Quiz</title>
</head>
<body>
    <h1>quiz</h1>
    <!-- 選択肢憑表示 -->
    <p><?php echo $text; ?></p>

    <?php 
        require('dbconnect.php');
        $choice = $db->prepare('select * from choices where questions_id=?');
        $question_id = $id;
        $choice->bind_param('i', $question_id);
        $choice->execute();
        $choice->bind_result($choice_id, $question_id, $c_text, $correct_flg);
    ?>
   
    <form method="POST">
        <ul>
        <?php while($choice->fetch()): ?>
            <li><input type="radio" name="choice" value=<?php echo $choice_id; ?>><?php echo $c_text; ?></li>
            <?php if($correct_flg == 1){
                $answer_text = $c_text;
            }
            ?>
        <?php endwhile; ?>
        </ul>
    </form>

    <?php
        $c_id = filter_input(INPUT_POST, 'choice', FILTER_SANITIZE_NUMBER_INT);
        $a_id = filter_input(INPUT_POST, 'answer', FILTER_SANITIZE_NUMBER_INT);
        $result_score = filter_input(INPUT_POST, 'result_score', FILTER_SANITIZE_NUMBER_INT);
        if ($c_id == $a_id) {
             echo "正解";
            $result_score ++;
            echo $result_score;
        }else{
            echo "不正解!<br> 正解は" . $answer_text;

        };
  ?>
    <?php if($id < $count['cnt']): ?>
        <form method="POST" action="quiz.php?id=<?php echo $id = $id+1; ?>">
            <input type="submit" value="次の問題">
            <input type="hidden" name="result_score" value=<?php echo $result_score; ?>>
        </form>
    <?php else: ?>
        <form method="POST" action="result.php">
            <input type="submit" value="結果">
            <input type="hidden" name="result_score" value=<?php echo $result_score; ?>>
        </form>
    <?php endif ?>

</body>
</html>
