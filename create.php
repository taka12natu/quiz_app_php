<?php
  require('dbconnect.php');
  // questionsテーブルとchoicesテーブルを結合して、抽出したデータを$rowsに格納
  require('tableconnect.php');
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
				<label><input type="radio" name="form_select" value="textbox">記述回答</label>
			</div>
      <!-- チェックボックス -->
			<div id="checkbox_form" class="default_view">
        <p>選択肢</p>
			  <?php for($i=1; $i<=4; $i++): ?>
					<textarea name="c_texts[]" class="checkbox_text" cols="20" rows="2"></textarea>
					<input type="checkbox" name="check[]" class="checkbox_select" value="<?php echo $i ?>"><br>
				<?php endfor ?>
			</div>
      <!-- ラジオボタン -->
			<div id="radio_form" class="default_view">
        <p>選択肢</p>	
        <?php for($i=1; $i<=4; $i++): ?>
					<textarea name="c_texts[]" class="radio_text" cols="20" rows="2"></textarea>
					<input type="radio" name="check[]" class="radio_select" value="<?php echo $i ?>"><br>
				<?php endfor ?>
			</div>
      <!-- テキストボックス -->
			<div id="textbox_form" class="default_view">
        <p>正解</p>
        <input type="text" name="c_texts[]" id="textbox_text"></input>
			</div>
			<button type="submit" id="create_do">登録</button>
		</form>
		<a href="detail.php?id=<?php echo $id ?>">戻る</a>
	</div>
	<script type="text/javascript" src="./script.js"></script>
</body>
</html>