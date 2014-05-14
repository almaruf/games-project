games-project
=============

Rules to follow :

Languages to use :
1. PHP is to be used as server-side scripting language, Zend framework is preferrable.
2. An Object Oriented approach should be maintained.
3. No use of JS
4. No use of Inline CSS, only the provided view helper class (Zend_View_Helper_Makup) functions can be used for Styling as a wrapper.

Use of image constraints :
1. No use of more than one image per page.
2. Images should be minimul in size (120px*300px) and weight (must be in KB's, Not in MB's)




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
public function($text){
  return "<p>$text</p>";
}
}
