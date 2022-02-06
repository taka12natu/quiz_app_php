<?php 
  session_start();

  require('dbconnect.php');
  $stmt = $db->prepare('insert into records(name, question_number, correct_answer, datetime) values(?,?,?,?)');
  if(!$stmt){
    die($db->error);
  }
  $name = $_SESSION['name'];
  $question_number = "5";
  $correct_answer = filter_input(INPUT_POST, 'result_score', FILTER_SANITIZE_NUMBER_INT);
  $datetime = new DateTime("now");
  $datetime = $datetime->format('Y-m-d H:i:s');

  $stmt->bind_param('siis', $name, $question_number, $correct_answer, $datetime);
  $success = $stmt->execute();
  if(!$success){
    die($db->error);
  }
?>

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
					echo $correct_answer . "問 正解！"; 
          echo "正答率: " . number_format($correct_answer / $question_number *100, 1);
        ?>
			</div>
			<div class="return">
				<a href="top.html">TOPに戻る</a>
			</div>
    </main>
</body>
</html>