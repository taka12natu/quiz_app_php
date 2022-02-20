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
	<link rel="stylesheet" href="./css/style.css" type="text/css">
	<title>Document</title>
</head>
<body>
	<main>
    <div class="create_box">
      <form action="create_do.php" method="POST" id="create_form">
        <h2>問題登録</h2>
        
        <h3 id="question_label">問題文</h3>
        <input type="text" name="q_text" class="question_box" onclick="check(this)">
        
        <h3 id="type_label">問題形式</h3>
        <div id="type">
          <label><input type="radio" name="form_select" value="radio" onclick="check(this)">単一回答</label>
          <label><input type="radio" name="form_select" value="checkbox" onclick="check(this)">複数回答</label>
          <label><input type="radio" name="form_select" value="textbox" onclick="check(this)">記述回答</label>
        </div>
        <!-- チェックボックス -->
        <div id="checkbox_form" class="default_view">
          <table>
            <tr>
              <th>正解</th>
              <th>選択肢</th>
            </tr>
            <?php for($i=1; $i<=4; $i++): ?>
              <tr>
                <td class="td_btn"><input type="checkbox" name="check[]" class="checkbox_select choice_btn" onclick="check(this)" value="<?php echo $i ?>"></td>
                <td class="td_text"><input type="text" name="c_texts[]" class="checkbox_text choice_box" onclick="check(this)"></td>
              </tr>
            <?php endfor ?>
          </table>
        </div>
        <!-- ラジオボタン -->
        <div id="radio_form" class="default_view">
          <table>
            <tr>
              <th>正解</th>
              <th>選択肢</th>
            </tr>          
            <?php for($i=1; $i<=4; $i++): ?>
              <tr>
              <td class="td_btn"><input type="radio" name="check[]" class="radio_select choice_btn" onclick="check(this)" value="<?php echo $i ?>"></td>
              <td class="td_text"><input type="text" name="c_texts[]" class="radio_text choice_box" onclick="check(this)"></td>
              </tr>
            <?php endfor ?>
          </table>
        </div>
        <!-- テキストボックス -->
        <div id="textbox_form" class="default_view">
          <h3>正解</h3>
          <input type="text" name="c_texts[]" id="textbox_text" class="answer_box" onclick="check(this)"></input>
        </div>
        <button type="submit" id="create_do" class="button" onclick="return confirmValue()">登録</button>
      </form>
      <a href="question_list.php" class="back">戻る</a>
    </div>
  </main>
	<script type="text/javascript" src="./JS/create.js"></script>
</body>
</html>