<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Result</title>
</head>
<body>
    <h1>Result</h1>
    <?php echo $_SESSION['result_score'];
    unset($_SESSION['result_score']);
     ?>

     <a href="top.html">TOPに戻る</a>
</body>
</html>