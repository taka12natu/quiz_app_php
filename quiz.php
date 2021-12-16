<?php
    require('dbconnect.php');
    /* SQLをセット */
    $stmt = $db->prepare('select * from questions where id=?');
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
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
            <li><input type="radio" name="choice" value='<?php echo $choice_id; ?>'><?php echo $c_text; ?></li>
            <?php if($correct_flg == 1){
                $answer_id = $choice_id; 
                $answer_text = $c_text;
            }
            ?>
        <?php endwhile; ?>
        </ul>
        <input type="submit" id="button" name="submit">
    </form>

    <?php
    if($_POST['submit']){
        $c_id = (int) $_POST['choice'];
        if(!$_SESSION['result_score']) $_SESSION['result_score'] = 0;
        if ($c_id == $answer_id) {
             echo "正解";
            $_SESSION['result_score'] ++;
            echo $_SESSION['result_score'];
        }else{
            echo "不正解!<br> 正解は" . $answer_text;

        };
    }
  ?>
    <div>
        <?php if($id < $count['cnt']): ?>
            <a href="quiz.php?id=<?php echo $id = $id+1 ?>">次の問題へ</a>
        <?php else: ?>
            <a href="result.php">結果</a>
        <?php endif ?>
    </div>
  
</body>
</html>
