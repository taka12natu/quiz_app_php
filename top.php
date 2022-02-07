<?php
  session_start();
  require('dbconnect.php');
  // 問題idをランダムに５問抽出して、配列に格納
  $stmt = $db->query('SELECT id FROM questions ORDER BY RAND() LIMIT 5');
  if(!$stmt){
		die($db->error);
	}
  $i = 0;
  while ($result = $stmt->fetch_assoc()) {
    $_SESSION['question_order'][$i] = $result['id'];
    $i++;
  }
  // １問目の問題id
  $first_question = $_SESSION['question_order'][0];
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
      <form action="quiz.php?id=<?php echo $first_question ?>" method="POST">
        <label>名前</label>
        <input type="text" name="name" placeholder="name">
        <input type="submit" value="Start">
        <!-- セッションでquiz.phpを初めに開いた際のみ処理を行う場合の判別用 -->
        <input type="hidden" name="first_question" value="first_question"> 
      </form>
    </div>
    <div class="edit">
      <a href="question_list.php">Edit</a>
    </div>
  </main>
</body>
</html>