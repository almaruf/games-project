<?php
class View {
    public $markup;
    public function __construct() {
        $this->markup = new Markup();
    }

    public function markup() {
        return $this->markup;
    }
}


class Markup {

    private $number = 1;

    /*
     *
     *
     */
    public function form( $form ){
        return "<p>$form</p>";
    }

    /*
     * Image function should be used for any anchor link
     */
    public function image($src){
        return "<img src='$src'/>";
    }

    /*
     * Menu function should be used for any anchor link
     */
    public function menu($text, $href, $depricated1 = null, $depricated2 = null, $letter = null){
        $number = 1;
        if($letter){
            $a = $letter;
        }else{
            $a = $this->number; $this->number++;
        }
        return "<a href='$href'>$a</a>) $text <br/>";
    }

    /*
     * h1 function should be used for Bold letter with a background color
     */
    public function h1($text){
        return "<h1 style='background-color: #ccc; font-color: #000; text-align:center'>$text</h1>";
    }


    /*
     * title function should be used for Slogan 
     */
    public function title($text){
        return "<p style='text-align:center; background-color: #ecc; font-color: #fff;'>$text</p>";
    }


    /*
     * text function should be used for any body text 
     */
    public function text($text){
        return "<p>$text</p>";
    }
}
