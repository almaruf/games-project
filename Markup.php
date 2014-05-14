<?php
class Zend_View_Helper_Markup{

private $number = 1;

/*
* Image function should be used for any anchor link
*/
public function image($src){
  return "<img src='$src'/>";
}

/*
* Menu function should be used for any anchor link
*/
public function menu($text, $href, null, null, $letter = null){
  $number = 1;
  if($letter){
    $a = $letter;
  }else{
    $a = $this->number; $this->number++;
  }
  return "<a href='$href'>$a</a>) $text";
}

/*
* h1 function should be used for Slogan 
*/
public function h1($text){
  return "<h1>$text</h1>";
}


/*
* title function should be used for Slogan 
*/
public function title($text){
  return "<p style='text-align:center;'>$text</p>";
}


/*
* text function should be used for any body text 
*/
public function text($text){
  return "<p>$text</p>";
}
}
