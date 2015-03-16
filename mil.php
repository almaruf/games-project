<?php 
public class Mil{
    
    const GAME_NAME = 'Mil';
    
    private $_session;
    
    public function __construct(){
        $this->_session = new Zend_Session_Namespace( self::GAME_NAME );
        
        if(isset($_GET['ur'])){
            $this->setUserReply( $_GET['ur'] );
            $this->checkAnswer();
        }
        
        return $this;
    }
    
    private function _checkAnswer(){
        // check if this is the letters between A-D -> than check for right answer
        // Also save the user reply as this will be used laters on _whatOthersSaid()
        
        // if the user input is something other than A-D than check the following 
        // If the User reply is 50-50 -> than use $this->_eliminateOptions(); 
        // If the User reply is what-others-said -> than use $this->_whatOthersSaid(); 
        // If the User reply is ask-a-friend -> than use $this->_askAFriend(); 
    }
    
    private function _eliminateOptions(){
        // Get rid of two of the wrong options
    }
    
    private function _whatOthersSaid(){
        // The system will go through the database to see what the previous users have answered about this answer
        // OR if there isnt enough (more than 4)answers the users will get two answers that include the right 
        // answer will have a random proportion of 70% of pretend votes - that might indicate that 
        // one of these are the right answer
    }
    
    private function _askAFriend(){
        // You get 5 mintes time bought for asking a friend
    }
    
    public function getRandomisedOptions(){
        return array_shuffle( $this->getOptions() );
    }
    
    public function getRightOption(){
        $options = $this->getOptions();
        return $options[ 0 ]; // the right naswer is always the first Option
    }
    
    public function setQuestion($value){
        $this->_session->question = $value;
        return $this;
    }
    
    public function getQuestion(){
        return $this->_session->question;
    }
    
    
    public function setOptions($value){
        $this->_session->options = $value;
        return $this;
    }
    
    public function getOptions(){
        return $this->_session->options;
    }
    
    
    public function setScore($value){
        $this->_session->score = $value;
        return $this;
    }
    
    public function getScore(){
        return $this->_session->score;
    }  
    
    
    public function setUserReply($value){
        $this->_session->user_reply = $value;
        return $this;
    }
    
    public function getUserReply(){
        return $this->_session->user_reply;
    }
}
