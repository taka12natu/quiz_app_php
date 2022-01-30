<?php
  require('dbconnect.php');

  // questionsテーブルとchoicesテーブルを結合
  $stmt = $db->prepare('select questions.id as q_id, questions.text as q_text, choices.id as c_id, choices.text as c_text, correct_flg from questions join choices on questions.id = choices.questions_id where questions.id=?');
  if(!$stmt){
    die($db->error);
	}
  $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
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
	<title>Document</title>
</head>
<body>
	<div>
		<form action="create_do.php" method="POST">
			<textarea name="q_text" cols="20" rows="2"></textarea>
			<p>選択肢</p>
			<div>
				<?php for($i=1; $i<=4; $i++): ?>
					<textarea name="c_texts[]" cols="20" rows="2"></textarea>
					<input type="radio" name="check" value="<?php echo $i ?>"><br>
				<?php endfor ?>
			</div>
			<button type="submit">更新</button>
		</form>
		<a href="detail.php?id=<?php echo $id ?>">戻る</a>
	</div>
</body>
</html>