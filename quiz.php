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
?>

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
   
    <form method="POST" action="check.php" name="answer_box" onsubmit="return false">
        <ul>
        <?php while($choice->fetch()): ?>
            <li><input type="radio" name="choice" value=<?php echo $choice_id; ?>><?php echo $c_text; ?></li>
            <?php if($correct_flg == 1){
                $answer_id = $choice_id; 
                $answer_text = $c_text;
            }
            ?>
        <?php endwhile; ?>
        </ul>
        <input type="hidden" name="answer" value=<?php echo $answer_id; ?>>
        <input type="hidden" name="id" value=<?php echo $id; ?>>
        <input type="hidden" name="result_score" value=<?php echo $result_score; ?>>
        <input type="submit" id="send" value="送信">
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
</body>
</html>
