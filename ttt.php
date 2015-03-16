<?php
$t = new T();
echo $t->getHtml();
echo "Won - " . var_dump($t->check());

class T{
    const GAME_NAME = 'TTT';
    const USER_VALUE = 'X';
    const SYS_VALUE = 'O';
    private $_s;
    private $_template = array(
        'a1' => null, 'a2' => null, 'a3' => null,
        'b1' => null, 'b2' => null, 'b3' => null,
        'c1' => null, 'c2' => null, 'c3' => null,
    );

    public function __construct($options = null){
        session_start();            
        if(! isset($_GET['ur'])){
            $_SESSION[ self::GAME_NAME ] = $this->_template;
        }else{
            $index = $_GET['ur'];
            if(null === $_SESSION[ self::GAME_NAME ][ $index ]){
                $_SESSION[ self::GAME_NAME ][ $index ] = self::USER_VALUE;
            }
        }

        $this->_s = $_SESSION[ self::GAME_NAME ];
    }

/*
    a1 a2 a3
    a1 b2 c3
    a1 b1 c1
    a2 b2 c2 
    a3 b3 c3
    a3 b2 c1 
    b1 b2 b3
    c1 c2 c3
 */
    private function tier1Move($sysOrUser){
        if($sysOrUser == $this->_s['a1'] && $this->_s['a1'] == $this->_s['a2'] && null === $this->_s['a3']){
            $this->_s['a3'] = self::SYS_VALUE; return true;
        }elseif($sysOrUser == $this->_s['a2'] && $this->_s['a2'] == $this->_s['a3'] && null === $this->_s['a1']){
            $this->_s['a1'] = self::SYS_VALUE; return true;
        }elseif($sysOrUser == $this->_s['a1'] && $this->_s['a1'] == $this->_s['a3'] && null === $this->_s['a2']){
            $this->_s['a2'] = self::SYS_VALUE; return true;        
        }elseif($sysOrUser == $this->_s['a1'] && $this->_s['a1'] == $this->_s['b2'] && null === $this->_s['c3']){
            $this->_s['c3'] = self::SYS_VALUE; return true;
        }elseif($sysOrUser == $this->_s['b2'] && $this->_s['b2'] == $this->_s['c3'] && null === $this->_s['a1']){
            $this->_s['a1'] = self::SYS_VALUE; return true;
        }elseif($sysOrUser == $this->_s['a1'] && $this->_s['a1'] == $this->_s['c3'] && null === $this->_s['b2']){
            $this->_s['b2'] = self::SYS_VALUE; return true;        
        }elseif($sysOrUser == $this->_s['a1'] && $this->_s['a1'] == $this->_s['b1'] && null === $this->_s['c1']){
            $this->_s['c1'] = self::SYS_VALUE; return true;
        }elseif($sysOrUser == $this->_s['b1'] && $this->_s['b1'] == $this->_s['c1'] && null === $this->_s['a1']){
            $this->_s['a1'] = self::SYS_VALUE; return true;
        }elseif($sysOrUser == $this->_s['a1'] && $this->_s['a1'] == $this->_s['c1'] && null === $this->_s['b1']){
            $this->_s['b1'] = self::SYS_VALUE; return true;        
        }elseif($sysOrUser == $this->_s['a2'] && $this->_s['a2'] == $this->_s['b2'] && null === $this->_s['c2']){
            $this->_s['c2'] = self::SYS_VALUE; return true;
        }elseif($sysOrUser == $this->_s['b2'] && $this->_s['b2'] == $this->_s['c2'] && null === $this->_s['a2']){
            $this->_s['a2'] = self::SYS_VALUE; return true;
        }elseif($sysOrUser == $this->_s['a2'] && $this->_s['a2'] == $this->_s['c2'] && null === $this->_s['b2']){
            $this->_s['b2'] = self::SYS_VALUE; return true;
        }elseif($sysOrUser == $this->_s['a3'] && $this->_s['a3'] == $this->_s['b3'] && null === $this->_s['c3']){
            $this->_s['c3'] = self::SYS_VALUE; return true;
        }elseif($sysOrUser == $this->_s['b3'] && $this->_s['b3'] == $this->_s['c3'] && null === $this->_s['a3']){
            $this->_s['a3'] = self::SYS_VALUE; return true;
        }elseif($sysOrUser == $this->_s['a3'] && $this->_s['a3'] == $this->_s['c3'] && null === $this->_s['b3']){
            $this->_s['b3'] = self::SYS_VALUE; return true;        
        }elseif($sysOrUser == $this->_s['a3'] && $this->_s['a3'] == $this->_s['b2'] && null === $this->_s['c1']){
            $this->_s['c1'] = self::SYS_VALUE; return true;
        }elseif($sysOrUser == $this->_s['b2'] && $this->_s['b2'] == $this->_s['c1'] && null === $this->_s['a3']){
            $this->_s['a3'] = self::SYS_VALUE; return true;
        }elseif($sysOrUser == $this->_s['a3'] && $this->_s['a3'] == $this->_s['c1'] && null === $this->_s['b2']){
            $this->_s['b2'] = self::SYS_VALUE; return true;
        }elseif($sysOrUser == $this->_s['b1'] && $this->_s['b1'] == $this->_s['b2'] && null === $this->_s['b3']){
            $this->_s['b3'] = self::SYS_VALUE; return true;
        }elseif($sysOrUser == $this->_s['b2'] && $this->_s['b2'] == $this->_s['b3'] && null === $this->_s['b1']){
            $this->_s['b1'] = self::SYS_VALUE; return true;
        }elseif($sysOrUser == $this->_s['b1'] && $this->_s['b1'] == $this->_s['b3'] && null === $this->_s['b2']){
            $this->_s['b2'] = self::SYS_VALUE; return true;
        }elseif($sysOrUser == $this->_s['c1'] && $this->_s['c1'] == $this->_s['c2'] && null === $this->_s['c3']){
            $this->_s['c3'] = self::SYS_VALUE; return true;
        }elseif($sysOrUser == $this->_s['c2'] && $this->_s['c2'] == $this->_s['c3'] && null === $this->_s['c1']){
            $this->_s['c1'] = self::SYS_VALUE; return true;
        }elseif($sysOrUser == $this->_s['c1'] && $this->_s['c1'] == $this->_s['c3'] && null === $this->_s['c2']){
            $this->_s['c2'] = self::SYS_VALUE; return true;
        }

        $_SESSION[ self::GAME_NAME ] = $this->_s;
   }

    public function tier2MoveForking(){

    }

    public function systemResponse(){
        // 1. Take a winning move
        return $this->tier1Move($sysOrUser);
        
        // 2. Block Opponent winning move
        if(false === $moveMade){
            $moveMade = $this->tier1Move(self::USER_VALUE);
        }
    }


    public function getHtml(){
        $html = "<table>";
        foreach($this->_s as $k => $v){
            if($k == 'a1' || $k == 'b1' || $k == 'c1'){
                $html .= "<tr>"; 
            }

            $ref = "<a href='?ur=$k'>$k</a>";
            $html .= "<td><b>" . (null === $v ? $ref : $v) . "</b></td>";

            if($k == 'a3' || $k == 'b3' || $k == 'c3'){
                $html .= "</tr>";
            }
        }
        return $html .= "</table>";
    }

    public function winner(){
        if(null !== $this->_s['a1'] 
            && $this->_s['a1'] == $this->_s['a2'] 
            && $this->_s['a2'] ==  $this->_s['a3']){
                return $this->_s['a1'];

        }elseif(null !== $this->_s['a1'] 
            && $this->_s['a1'] == $this->_s['b2']
            && $this->_s['b2'] ==  $this->_s['c3']){
                return $this->_s['a1'];       

        }elseif(null !== $this->_s['a1'] 
            && $this->_s['a1'] == $this->_s['b1']
            && $this->_s['b1'] ==  $this->_s['c1']){
                return $this->_s['a1'];

        }elseif(null !== $this->_s['a2'] 
            && $this->_s['a2'] == $this->_s['b2']
            && $this->_s['b2'] ==  $this->_s['c2']){
                return $this->_s['a2'];

        }elseif(null !== $this->_s['a3'] 
            && $this->_s['a3'] == $this->_s['b3'] 
            && $this->_s['b3'] ==  $this->_s['c3']){
                return $this->_s['a3'];       

        }elseif(null !== $this->_s['a3'] 
            && $this->_s['a3'] == $this->_s['b2'] 
            && $this->_s['b2'] ==  $this->_s['c1']){
                return $this->_s['a3'];

        }elseif(null !== $this->_s['b1'] 
            && $this->_s['b1'] == $this->_s['b2'] 
            && $this->_s['b2'] ==  $this->_s['b3']){
                return $this->_s['b1'];

        }elseif(null !== $this->_s['c1'] 
            && $this->_s['c1'] == $this->_s['c2']
            && $this->_s['c2'] ==  $this->_s['c3']){
               return $this->_s['c1'];
        }
    }
}

/*
a1 a2 a3 
b1 b2 b3
c1 c2 c3    

            a1 a2 a3
            a1 b2 c3
            a1 b1 c1
            a2 b2 c2 
            a3 b3 c3
            a3 b2 c1 
            b1 b2 b3
            c1 c2 c3
 
        */

