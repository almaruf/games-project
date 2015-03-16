<?php

$word = "test";
$sWord = str_shuffle($word);
$ur = null;

if(isset($_POST['ur'])){
    if($_POST['ur'] == $_POST['word']){
        echo "WON!";
    }else{
        echo "FAILED!";
    }
}
?>


What is the word '<?=$sWord?>'
<form type='POST'>
    <input type='hidden' name='word' value='<?=$word?>'/>
    <input type='text' name='ur'/>
    <input type='submit' name='submit'/>
</form>



