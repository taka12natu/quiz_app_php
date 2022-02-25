<?php
  require('dbconnect.php');
  /* ページネーション用に最終ページの番号を取得 */
  $counts = $db->query('SELECT count(*) as cnt FROM questions');
  $count = $counts->fetch_assoc();
  $last_page = ceil($count['cnt'] / 10); 
  /* 10件ずつ取得 */
  $stmt = $db->prepare('SELECT * FROM questions order by id desc limit ?,10');
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

  $stmt->bind_result($id, $text);
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
    <table class="table">
      <tr>
        <th>クイズ一覧</th>
      </tr>
      <?php while ($stmt->fetch()): ?>
        <tr class="table_row">
          <td class="table_data">
            <p class="table_text"><a href="detail.php?id=<?php echo $id; ?>"><?php echo htmlspecialchars($text);?></a></p>
          </td>
          <td class="td_edit"><a href="detail.php?id=<?php echo $id; ?>">編集</a></td>
          <td class="td_delete"><a href="delete.php?id=<?php echo $id; ?>" id=<?php echo $id; ?> onclick="return confirmDelete(this.id)">削除</td>
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
      <a href="create.php">追加</a>
      <a href="top.php">戻る</a>
    </div>
  </main>
  <script src="./JS/deleteConfirmation.js"></script>
</body>
</html>