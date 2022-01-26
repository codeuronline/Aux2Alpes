<?php

if (isset($_POST['submit'])) {

    var_dump(@$_POST);
    echo "<hr>";
    var_dump(@$_FILE);
} ?>
<form method='post' action='testform.php' enctype='multipart/form-data'>
    <input type="file" name="photo[]" id="photo" multiple>
    <input type='submit' name='submit' value='Upload'>
</form>