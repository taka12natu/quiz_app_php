<?php 
  require('dbconnect.php');

  $stmt = $db->prepare('DELETE questions,choices FROM questions LEFT JOIN choices ON questions.id = choices.questions_id WHERE questions.id=?');
  if(!$stmt){
    die($db->error);
  }
  $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
  $stmt->bind_param('i', $id);
  $success = $stmt->execute();
  if(!$success){
    die($db->error);
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./css/style.css">
  <title>Document</title>
</head>
<body>
  <header>
    <h1 class="title">Quiz</h1>
  </header>
  <main>
    <p>削除しました</p>
    <a href="question_list.php" class="back margin_top20">一覧に戻る</a>
  </main>
</body>
</html>
