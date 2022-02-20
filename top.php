<?php
  session_start();
  $_SESSION = array();
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./css/style.css">
  <title>TOP</title>
</head>
<body>
  <header>
    <h1 class="header_title">Quiz</h1>
  </header>
  <main>
    <div class="top_box">
      <form action="tmp.php" method="POST" name="start_form">
        <div class="name_box" id="name_box">
          <label>ニックネーム</label>
          <input type="text" name="name" placeholder="name" class="input_box" id="input_name" onclick="check(this)">
        </div>
        <div class="radio_box">
          <div><label class="label_text">問題数</label></div>
          <div class="radio_btn_box">
            <input type="radio" id="q3" class="top_radio_text" name="question_number" value="3" onclick="check(this)">
            <label for="q3">3問</label>
            <input type="radio" id="q5" class="top_radio_text" name="question_number" value="5" onclick="check(this)">
            <label for="q5">5問</label>
            <input type="radio" id="q10" class="top_radio_text" name="question_number" value="10" onclick="check(this)">
            <label for="q10">10問</label>
          </div>
        </div>
      </form>
      <div class="btn_box">
        <a href="#" id="start">start</a>
        <a href="question_list.php" class="edit_btn">Edit</a>
      </div>
      <a href="./answer_record.php" class="answer_record">回答履歴を見る</a>
    </div>
  </main>
  <script src="./JS/top.js"></script>
</body>
</html>