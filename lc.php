<?php
include_once('Markup.php');

$lc = new lc();
echo $lc->getHtml();

class lc {

    public $my_name;
    public $other_name;
    public $view;

    public function __construct() {
        session_start();
        $this->view = new View();
        $this->_getUserName();
    }

    public function getHtml(){
        $src = 'https://lh3.ggpht.com/f79UCpnLisZxO2P2C43f55YLvFpNco_cTcC-t9Ck-Qmqe5jwKbfnUvCh5N6-Te-mOw=w300';
        $html = $this->view->markup()->image( $src );

        if(! $this->my_name) {

            $html .= $this->view->markup()->title("Step 1 : Please enter your name.");
            $h  =  "<form method='GET'>";
            $h .= "Enter your name : <input name='lc_my_name' type='text' size='10'><br/>";
            $h .= "<input type='submit' name='compare' value='Submit!'>";
            $h .= "</form>";
            $html .= $this->view->markup()->form($h);
            return $html;
        } 

        if(isset($_GET['lc_other_name'])) {

            $this->other_name = strip_tags($_GET['lc_other_name']);
            $percentage = $this->_getPercentage();

            if(100 == $percentage) {
                $html .=  $this->view->markup->title("You must be joking!!!");
                return $html;
            }

            $html .=  $this->view->markup()->h1("You both have a " . ceil($percentage) . "% compatibility.");

            if($percentage > 50) {
                $html .= $this->view->markup()->title("Aha, you both seem to be a sparkling match!");
            } else {
                $html .= $this->view->markup()->title(":( You both need to work hard on your relationship!");
            }
        }        

        $html .= $this->view->markup()->title("Please enter your partners name OR try someone else :D ");
        $h  = "<form method='GET'>";
        $h .= "Enter your loved one's name : <input name='lc_other_name' type='text' size='10'><br/>";
        $h .= "<input type='submit' name='compare' value='Go Compare!'>";
        $h .= "</form>";
        $html .= $this->view->markup()->form( $h );
        return $html;
    }

    private function _getPercentage(){
        $percentage = 0;
        $sameStr = strcasecmp( $this->my_name, $this->other_name );
        similar_text($this->my_name, $this->other_name, $percentage);
        return ( ! $sameStr ? $percentage = 100 : $percentage);
    }
    
    private function _getUserName() {
        if(isset($_SESSION['lc_my_name']) || isset($_GET['lc_my_name'])) {
            if(isset($_GET['lc_my_name'])) {
                $_SESSION['lc_my_name'] = $_GET['lc_my_name'];
            }
            
            $this->my_name = $_SESSION['lc_my_name'];
        }
    }
}
