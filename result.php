<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="style.css">
	<title>Result</title>
</head>
<body>
	<header>
    <h1 class="title">Quiz</h1>
  </header>
    <main>
			<h2>Result</h2>
			<div class="result_text">
				<?php 
				  $result_score = filter_input(INPUT_POST, 'result_score', FILTER_SANITIZE_NUMBER_INT);
					echo $result_score . "問 正解！"; ?>
			</div>
			<div class="return">
				<a href="top.html">TOPに戻る</a>
			</div>
    </main>
</body>
</html>