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
	<title>Document</title>
</head>
<body>
	<div>
		<form action="edit_do.php" method="POST">
			<textarea name="q_text" cols="20" rows="2"><?php echo htmlspecialchars($rows[0]['q_text']); ?></textarea>
      <?php if($rows[0]['answer_type'] == 'textbox'): ?>
        <p>正解: 
          <input type="text" name="c_texts[]" id="textbox_text" value="<?php echo htmlspecialchars($rows[0]['c_text']); ?>"></input>
          <input type="hidden" name="c_ids[]" value="<?php echo $rows[0]['c_id']; ?>">
          <input type="hidden" name="answer_type" value="textbox">
        </p>
      <?php else: ?>
        <p>選択肢</p>
        <div>
          <?php foreach ($rows as $row): ?>
            <textarea name="c_texts[]" cols="20" rows="2"><?php echo htmlspecialchars($row['c_text']); ?></textarea>
            <input type="<?php echo $row['answer_type']?>" name="check[]" value="<?php echo $row['c_id']?>"><br>
            <input type="hidden" name="c_ids[]" value="<?php echo $row['c_id']; ?>">
          <?php endforeach ?>
        </div>
      <?php endif; ?>
			<input type="hidden" name="id" value="<?php echo $id; ?>">
			<button type="submit">更新</button>
		</form>
		<a href="detail.php?id=<?php echo $id ?>">戻る</a>
	</div>
</body>
</html>