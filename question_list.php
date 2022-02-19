<?php
  require('dbconnect.php');
  $questions = $db->query('SELECT * FROM questions');
  if(!$questions){
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
    <table class="table">
      <tr>
        <th>クイズ一覧</th>
      </tr>
      <?php while ($question = $questions->fetch_assoc()): ?>
        <tr class="table_row">
          <td class="table_data">
            <p class="table_text"><a href="detail.php?id=<?php echo $question['id']; ?>"><?php echo htmlspecialchars($question['text']);?></a></p>
          </td>
          <td class="td_edit"><a href="detail.php?id=<?php echo $question['id']; ?>">編集</a></td>
          <td class="td_delete"><a href="delete.php?id=<?php echo $question['id']; ?>">削除</td>
        </tr>
      <?php endwhile; ?>
    </table>      
    <div class="btn_box">
      <a href="create.php">追加</a>
      <a href="top.php">戻る</a>
    </div>
  </main>
</body>
</html>