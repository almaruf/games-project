<?php
$t = new T();
echo $t->getHtml();
echo "Won - " . $t->winner();
echo "<a href='?'>new</a>";

class T {
    const GAME_NAME = 'TTT';    
    const SYS_SIGN = 'X';
    const USER_SIGN = 'O';
    
    private $_s;
    
    private $_template = array(
        'a1' => null, 'a2' => null, 'a3' => null,
        'b1' => null, 'b2' => null, 'b3' => null,
        'c1' => null, 'c2' => null, 'c3' => null,
    );

    public function __construct($options = null) {
        session_start();
        
        if (! isset($_GET['ur'])) {            
            $_SESSION[ self::GAME_NAME ] = $this->_template;
            $this->_s = $_SESSION[ self::GAME_NAME ];
        } else {
            $index = $_GET['ur'];            
            if (null === $_SESSION[ self::GAME_NAME ][ $index ]) {
                $_SESSION[ self::GAME_NAME ][ $index ] = $this->getUserSign();
            }

            $this->_s = $_SESSION[ self::GAME_NAME ];
            
            if (!$this->winner()) {
                if (! $this->_systemResponse()) {
                    die('drew!! drew!!');
                }
            }
        }
    }

    /*
    *    a1 a2 a3 ,  a1 b2 c3,  a1 b1 c1,  a2 b2 c2,  a3 b3 c3,  a3 b2 c1,  b1 b2 b3,  c1 c2 c3
    */
    private function _tier2Move($sysOrUser, $toPut) {
        $temp = array(
            array('a1', 'a2', 'a3'),
            array('a1', 'b2', 'c3'),
            array('a1', 'b1', 'c1'),
            array('a2', 'b2', 'c2'),
            array('a3', 'b3', 'c3'),
            array('a3', 'b2', 'c1'),
            array('b1', 'b2', 'b3'),
            array('c1', 'c2', 'c3'),
        );
        
        foreach ($temp as $t) {        
            $first = $t[0]; $second = $t[1]; $third = $t[2];
            
            if ($sysOrUser == $this->_s[ $first ] && 
                $this->_s[ $first ] == $this->_s[ $second ] 
                && null === $this->_s[ $third ]) {
                
                $this->_s[ $third ] = $toPut; 
                $_SESSION[ self::GAME_NAME ] = $this->_s;
                return true;
                
            } elseif ($sysOrUser == $this->_s[ $second ] && 
                $this->_s[ $second ] == $this->_s[ $third ] 
                && null === $this->_s[ $first ]) {
                
                $this->_s[ $first ] = $toPut;
                $_SESSION[ self::GAME_NAME ] = $this->_s;
                return true;
                
            } elseif ($sysOrUser == $this->_s[ $first ] && 
                $this->_s[ $first ] == $this->_s[ $third ] 
                && null === $this->_s[ $second ]) {
                
                $this->_s[ $second ] = $toPut;
                $_SESSION[ self::GAME_NAME ] = $this->_s;
                return true;
            }
        }
            
        /*
        $moveMade = false;
        if($sysOrUser == $this->_s['a1'] && $this->_s['a1'] == $this->_s['a2'] && null === $this->_s['a3']){
            $this->_s['a3'] = $toPut; $moveMade = true;
        }elseif($sysOrUser == $this->_s['a2'] && $this->_s['a2'] == $this->_s['a3'] && null === $this->_s['a1']){
            $this->_s['a1'] = $toPut; $moveMade = true;
        }elseif($sysOrUser == $this->_s['a1'] && $this->_s['a1'] == $this->_s['a3'] && null === $this->_s['a2']){
            $this->_s['a2'] = $toPut; $moveMade = true;
        }elseif($sysOrUser == $this->_s['a1'] && $this->_s['a1'] == $this->_s['b2'] && null === $this->_s['c3']){
            $this->_s['c3'] = $toPut; $moveMade = true;
        }elseif($sysOrUser == $this->_s['b2'] && $this->_s['b2'] == $this->_s['c3'] && null === $this->_s['a1']){
            $this->_s['a1'] = $toPut; $moveMade = true;
        }elseif($sysOrUser == $this->_s['a1'] && $this->_s['a1'] == $this->_s['c3'] && null === $this->_s['b2']){
            $this->_s['b2'] = $toPut; $moveMade = true;
        }elseif($sysOrUser == $this->_s['a1'] && $this->_s['a1'] == $this->_s['b1'] && null === $this->_s['c1']){
            $this->_s['c1'] = $toPut; $moveMade = true;
        }elseif($sysOrUser == $this->_s['b1'] && $this->_s['b1'] == $this->_s['c1'] && null === $this->_s['a1']){
            $this->_s['a1'] = $toPut; $moveMade = true;
        }elseif($sysOrUser == $this->_s['a1'] && $this->_s['a1'] == $this->_s['c1'] && null === $this->_s['b1']){
            $this->_s['b1'] = $toPut; $moveMade = true;
        }elseif($sysOrUser == $this->_s['a2'] && $this->_s['a2'] == $this->_s['b2'] && null === $this->_s['c2']){
            $this->_s['c2'] = $toPut; $moveMade = true;
        }elseif($sysOrUser == $this->_s['b2'] && $this->_s['b2'] == $this->_s['c2'] && null === $this->_s['a2']){
            $this->_s['a2'] = $toPut; $moveMade = true;
        }elseif($sysOrUser == $this->_s['a2'] && $this->_s['a2'] == $this->_s['c2'] && null === $this->_s['b2']){
            $this->_s['b2'] = $toPut; $moveMade = true;
        }elseif($sysOrUser == $this->_s['a3'] && $this->_s['a3'] == $this->_s['b3'] && null === $this->_s['c3']){
            $this->_s['c3'] = $toPut; $moveMade = true;
        }elseif($sysOrUser == $this->_s['b3'] && $this->_s['b3'] == $this->_s['c3'] && null === $this->_s['a3']){
            $this->_s['a3'] = $toPut; $moveMade = true;
        }elseif($sysOrUser == $this->_s['a3'] && $this->_s['a3'] == $this->_s['c3'] && null === $this->_s['b3']){
            $this->_s['b3'] = $toPut; $moveMade = true;
        }elseif($sysOrUser == $this->_s['a3'] && $this->_s['a3'] == $this->_s['b2'] && null === $this->_s['c1']){
            $this->_s['c1'] = $toPut; $moveMade = true;
        }elseif($sysOrUser == $this->_s['b2'] && $this->_s['b2'] == $this->_s['c1'] && null === $this->_s['a3']){
            $this->_s['a3'] = $toPut; $moveMade = true;
        }elseif($sysOrUser == $this->_s['a3'] && $this->_s['a3'] == $this->_s['c1'] && null === $this->_s['b2']){
            $this->_s['b2'] = $toPut; $moveMade = true;
        }elseif($sysOrUser == $this->_s['b1'] && $this->_s['b1'] == $this->_s['b2'] && null === $this->_s['b3']){
            $this->_s['b3'] = $toPut; $moveMade = true;
        }elseif($sysOrUser == $this->_s['b2'] && $this->_s['b2'] == $this->_s['b3'] && null === $this->_s['b1']){
            $this->_s['b1'] = $toPut; $moveMade = true;
        }elseif($sysOrUser == $this->_s['b1'] && $this->_s['b1'] == $this->_s['b3'] && null === $this->_s['b2']){
            $this->_s['b2'] = $toPut; $moveMade = true;
        }elseif($sysOrUser == $this->_s['c1'] && $this->_s['c1'] == $this->_s['c2'] && null === $this->_s['c3']){
            $this->_s['c3'] = $toPut; $moveMade = true;
        }elseif($sysOrUser == $this->_s['c2'] && $this->_s['c2'] == $this->_s['c3'] && null === $this->_s['c1']){
            $this->_s['c1'] = $toPut; $moveMade = true;
        }elseif($sysOrUser == $this->_s['c1'] && $this->_s['c1'] == $this->_s['c3'] && null === $this->_s['c2']){
            $this->_s['c2'] = $toPut; $moveMade = true;
        }        

        $_SESSION[ self::GAME_NAME ] = $this->_s;
        return $moveMade;
        */
    }
    
    private function _tier1Move($level = 'advanced') {
        $tmp = $this->_template;
        
        // get rid of the indexes which have been taken up
        foreach ($this->_s as $k => $v) {
            if (null !== $v) {
                unset($tmp[ $k ]);
            }
        }
        
        // See assign system sign on a smart index
        $smartIndices = array('a1' => null, 'a3' => null, 'b2' => null, 'c1' => null, 'c3' => null);                
        $smartIndicesLeft = array_intersect_assoc($tmp, $smartIndices);        
        if (! empty($smartIndicesLeft)) {
            $rand = array_rand($smartIndicesLeft);
            $this->_s[ $rand ] = $this->getSysSign();
            $_SESSION[ self::GAME_NAME ] = $this->_s;
            return true;
        }
        
        // Finally assign system sign on a non-smart index
        $nonSmartIndices = array('a2' => null, 'b1' => null, 'b3' => null, 'c2' => null);
        $nonSmartIndicesLeft = array_intersect_assoc($tmp, $nonSmartIndices);
        if (! empty($nonSmartIndicesLeft)) {
            $rand = array_rand($nonSmartIndicesLeft);
            $this->_s[ $rand ] = $this->getSysSign();
            $_SESSION[ self::GAME_NAME ] = $this->_s;
            return true;
        }
    }
    
    private function _systemResponse() {
        // 1. Take a winning move        
        if ($this->_tier2Move($this->getSysSign(), $this->getSysSign())) {
            return true;
        }
        
        // 2. Block Opponent winning move
        if ($this->_tier2Move($this->getUserSign(), $this->getSysSign())) {
            return true;
        }
        
        // 3. make a primary move
        if ($this->_tier1Move()) {
            return true;
        }
    }
    
    public function winner() {
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

    public function getHtml() {
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
    
    public function setUserSign($value) {
        $this->_s['user_sign'] = $value;
        return $this;
    }    
    public function getUserSign() {
        return (isset($this->_s['user_sign']) ? $this->_s['user_sign'] : self::USER_SIGN);
    }
    
    public function setSysSign($value) {
        $this->_s['sys_sign'] = $value;
        return $this;
    }    
    public function getSysSign() {
        return (isset($this->_s['sys_sign']) ? $this->_s['sys_sign'] : self::SYS_SIGN);
    }
}

