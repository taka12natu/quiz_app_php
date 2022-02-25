<?php 
  require('dbconnect.php');

  $stmt = $db->prepare('DELETE questions,choices FROM questions LEFT JOIN choices ON questions.id = choices.questions_id WHERE questions.id=?');
  if(!$stmt){
    die($db->error);
  }
  $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
  /* 最初の7問は削除できないように設定 */
  if($id>7){
    $stmt->bind_param('i', $id);
    $success = $stmt->execute();
    if(!$success){
      die($db->error);
    }
    $msg = '削除しました。';
  }else{
    $msg = 'この問題は削除できません。';
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
    <p><?php echo $msg ?></p>
    <a href="question_list.php" class="back margin_top20">一覧に戻る</a>
  </main>
</body>
</html>
