<?php 
  $questions = [
    ['title' => "Color", 
      'body' => 'Is your favorite color Blue?', 
      'answers' => [
        'true',
        'false',
      ]],
    ['title' => "Color", 
      'body' => 'Is your favorite color Green?', 
      'answers' => [
        'true',
        'false',
      ]],
    ['title' => "Color", 
      'body' => 'Is your favorite color Red?', 
      'answers' => [
        'true',
        'false',
      ]],
    ['title' => "Color", 
      'body' => 'Is your favorite color Purple?', 
      'answers' => [
        'true',
        'false',
      ]],
      ];

      // $questions = json_encode($questions);
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
</head>
<body>

<?php foreach($questions as $que) { ?>
  <div>
    <h1><?= $que['title']?></h1>
    <p><?= $que['body']?></p>
  </div>
<?php }?>

  
</body>
</html>