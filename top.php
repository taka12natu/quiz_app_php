<?php
  require('dbconnect.php');
  $questions = $db->query('select id from questions');
  if(!$questions){
		die($db->error);
	}
/*   $total_question_num = $questions->num_rows;
  $question_order = range(0, $total_question_num-1);
  shuffle($question_order);  */
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <title>TOP</title>
</head>
<body>
  <header>
    <h1 class="title">Quiz</h1>
  </header>
  <main>
    <div class="start">
      <form action="quiz.php?id=2" method="POST">
        <label>名前</label>
        <input type="text" name="name" placeholder="name">
        <input type="submit" value="Start">
        <!-- nameをセッションで保持する場合の処理用 -->
        <input type="hidden" name="first_question" value="1"> 
      </form>
    </div>
    <div class="edit">
      <a href="question_list.php">Edit</a>
    </div>
  </main>
</body>
</html>