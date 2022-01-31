<?php
  require('dbconnect.php');
  $questions = $db->query('select * from questions');
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
    <title>Document</title>
</head>
<body>
    <?php while ($question = $questions->fetch_assoc()): ?>
    	<p><a href="detail.php?id=<?php echo $question['id']; ?>"><?php echo htmlspecialchars($question['text']);?></a></p>
    <?php endwhile; ?>

    <div>
        <a href="create.php">追加</a>
        <a href="top.html">戻る</a>
    </div>
</body>
</html>