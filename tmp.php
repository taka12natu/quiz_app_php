<?php 
  session_start();

  $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
  $_SESSION['name'] = $name; 
  
  require('dbconnect.php');
  // 問題idをランダムに抽出して配列に格納
  $stmt = $db->prepare('SELECT id FROM questions ORDER BY RAND() LIMIT ?');
  if(!$stmt){
		die($db->error);
	}
  $q_number = filter_input(INPUT_POST, 'question_number', FILTER_SANITIZE_NUMBER_INT);
  $stmt->bind_param('i', $q_number);
  $stmt->execute(); 
  $stmt->bind_result($question_order);
  while ($stmt->fetch()) {
    $_SESSION['question_order'][] = $question_order;
  }
  
  // １問目にリダイレクト 
  $id = $_SESSION['question_order'][0];
  header('Location: ./quiz.php?id=' . $id);