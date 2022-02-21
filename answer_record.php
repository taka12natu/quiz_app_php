<?php 
  require('dbconnect.php');
  /* ページネーション用に最終ページの番号を取得 */
  $counts = $db->query('SELECT count(*) as cnt FROM records');
  $count = $counts->fetch_assoc();
  $last_page = ceil($count['cnt'] / 10); 
  /* 10件ずつ取得 */
  $stmt = $db->prepare('SELECT * FROM records order by id desc limit ?,10');
  if(!$stmt){
    die($db->error);
  }
  $page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_NUMBER_INT);
  if(!$page){ // page番号が設定されてない時は1を表示する 
    $page = 1;
  }
  $start = ($page - 1) * 10;
  $stmt->bind_param('i', $start);
  $stmt->execute();

  $stmt->bind_result($id, $name, $question_number, $correct_answer, $datetime);
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
        <?php while($stmt->fetch()): ?>
          <tr class="tr_border">
            <td><?php echo $id ?></td>
            <td><?php echo $name ?></td>
            <td><?php echo $question_number ?></td>
            <td><?php echo $correct_answer ?></td>
            <td><?php echo number_format($correct_answer / $question_number *100, 1) ?></td>
            <td><?php echo $datetime ?></td>
          </tr>
        <?php endwhile; ?>
      </table>
      <div class="pagenation">
        <?php if($page > 1): ?>
          <a href="?page=<?php echo $page-1 ?>">前へ</a>|
        <?php endif; ?>
        <?php if($page < $last_page): ?>
          <a href="?page=<?php echo $page+1 ?>">次へ</a>
        <?php endif; ?>
      </div>
      <div class="btn_box">
        <a href="./top.php">戻る</a>
      </div>
    </main>
  </body>
</html>