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
  <link rel="stylesheet" href="./css/style.css">
	<title>Document</title>
</head>
<body>
<header>
    <h1 class="title">Quiz</h1>
  </header>
  <main>
    <div class="edit_box">
      <h2>編集画面</h2>
      <h3 id="question_label">問題文</h3>
      <form action="edit_do.php" method="POST" id="edit_form">
        <input type="text" name="q_text" class="question_box" onclick="check(this)" value="<?php echo htmlspecialchars($rows[0]['q_text']); ?>">
        <!-- 記述回答 -->
        <?php if($rows[0]['answer_type'] == 'textbox'): ?>
          <h3>正解:</h3>
            <input type="text" name="c_texts[]" id="textbox_text" class="answer_box" onclick="check(this)" value="<?php echo htmlspecialchars($rows[0]['c_text']); ?>">
            <input type="hidden" name="c_ids[]" value="<?php echo $rows[0]['c_id']; ?>">
            <input type="hidden" name="answer_type" value="textbox">
          </p>
          <!-- 選択回答 -->
        <?php else: ?>
          <table>
            <tr>
            <th>正解</th>
            <th>選択肢</th>
            </tr>
            <?php foreach ($rows as $row): ?>
              <tr>
                <td class="td_btn"><input type="<?php echo $row['answer_type']?>" name="check[]" class="choice_select" onclick="check(this)" value="<?php echo $row['c_id']?>"></td>
                <td class="td_text"><input type="text" name="c_texts[]" class="choice_box" onclick="check(this)" value="<?php echo htmlspecialchars($row['c_text']); ?>"></td>
                <input type="hidden" name="c_ids[]" value="<?php echo $row['c_id']; ?>">
              </tr>
              <?php endforeach ?>
          </table>
        <?php endif; ?>
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <button type="submit" class="button" id="edit_do" onclick="return confirmValue()">更新</button>
      </form>
        <a href="detail.php?id=<?php echo $id ?>" class="back">戻る</a>
    </div>
  </main>
  <script type="text/javascript" src="./JS/edit.js"></script>
</body>
</html>