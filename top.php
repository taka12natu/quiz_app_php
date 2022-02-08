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
  <link rel="stylesheet" href="style.css">
  <title>TOP</title>
</head>
<body>
  <header>
    <h1 class="title">Quiz</h1>
  </header>
  <main>
    <div class="start">
      <form action="tmp.php" method="POST">
        <label>名前</label>
        <input type="text" name="name" placeholder="name"><br>
        <label>問題数</label><br>
        <label><input type="radio" name="question_number" value="3">3問</label>
        <label><input type="radio" name="question_number" value="5">5問</label>
        <label><input type="radio" name="question_number" value="10">10問</label><br>
        <label><input type="submit" value="Start">
      </form>
    </div>
    <div class="edit">
      <a href="question_list.php">Edit</a>
    </div>
  </main>
</body>
</html>