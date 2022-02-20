<?php 
  require('dbconnect.php');
  $stmt = $db->query('SELECT * FROM records');
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
      <h2>回答履歴</h2>
      <table class="table_border">
        <tr>
          <th>no.</th>
          <th>ニックネーム</th>
          <th>問題数</th>
          <th>正答数</th>
          <th>正答率</th>
          <th>日時</th>
        </tr>
        <?php while($row = $stmt->fetch_assoc()): ?>
          <tr class="tr_border">
            <td><?php echo $row['id'] ?></td>
            <td><?php echo $row['name'] ?></td>
            <td><?php echo $row['question_number'] ?></td>
            <td><?php echo $row['correct_answer'] ?></td>
            <td><?php echo number_format($row['correct_answer'] / $row['question_number'] *100, 1) ?></td>
            <td><?php echo $row['datetime'] ?></td>
          </tr>
        <?php endwhile; ?>
      </table>
      <div class="btn_box">
        <a href="./top.php">戻る</a>
      </div>
    </main>
  </body>
</html>