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
	<link rel="stylesheet" href="./style.css" type="text/css">
	<title>Document</title>
</head>
<body>
	<div>
		<form action="create_do.php" method="POST" id="create_form">
			<p>問題文</p>
			<textarea name="q_text" cols="20" rows="2"></textarea>
			<p>問題形式</p>
			<div id="type">
				<label><input type="radio" name="form_select" value="radio">単一回答</label>
				<label><input type="radio" name="form_select" value="checkbox">複数回答</label>
			</div>
			<p>選択肢</p>
			<div id="checkbox_form" class="default_view">
			<?php for($i=1; $i<=4; $i++): ?>
					<textarea name="c_texts[]" class="checkbox_text" cols="20" rows="2"></textarea>
					<input type="checkbox" name="check[]" class="checkbox_select" value="<?php echo $i ?>"><br>
				<?php endfor ?>
			</div>
			<div id="radio_form" class="default_view">
				<?php for($i=1; $i<=4; $i++): ?>
					<textarea name="c_texts[]" class="radio_text" cols="20" rows="2"></textarea>
					<input type="radio" name="check[]" class="radio_select" value="<?php echo $i ?>"><br>
				<?php endfor ?>
			</div>
			<button type="submit" id="create_do">更新</button>
		</form>
		<a href="detail.php?id=<?php echo $id ?>">戻る</a>
	</div>
	<script type="text/javascript" src="./script.js"></script>
</body>
</html>