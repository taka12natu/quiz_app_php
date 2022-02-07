<?php
  $stmt = $db->prepare('SELECT questions.id AS q_id, questions.text AS q_text, choices.id AS c_id, choices.text AS c_text, correct_flg, answer_type FROM questions JOIN choices ON questions.id = choices.questions_id WHERE questions.id=?');
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