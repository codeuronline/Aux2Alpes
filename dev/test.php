<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form method="POST" action="">
        <input type="date" min="<?= date("Y-m-d"); ?>"
            max="<?= date("Y-m-d", strtotime(date('Y-m-d') . "+ 12 months")); ?>" name=" debut" id="debut">
    </form>

</body>

</html>