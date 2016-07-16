<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Item
 *
 * @author pligor
 */
class Item extends Model {
    public $name;
    
    public function __construct($name=null) {
        $this->name = $name;
    }
    
    /**
     * Remember this is actually how much items are similar to each other
     * We are going to save this result
     * But this result is NOT personalized
     * Personalization comes when you take each item of a single person (along
     * with its rank) and you find for each other item if there is a match
     * @param int $n
     * @return array
     */
    public function calculateSimilarItems($n=10) {
        $items = self::findAll();
        $result = array();
        foreach($items as $item) {
            //print $item->name ."\n";
            $result[$item->name] = $item->topMatches('euclidean',$n);
        }
        return $result;
    }
    
    public function topMatches($distFunc='euclidean', $n=3) {
        $items = self::findAll();
        unset($items[ reset(array_keys($items,$this->name)) ]);
        
        $scores = array();
        foreach($items as $item) {
            $scores[$item->name] = $this->similarity($item,$distFunc);
        }
        
        arsort($scores,SORT_NUMERIC);
        
        while(count($scores)>$n) {
            array_pop($scores);
        }
        
        return $scores;
    }
    
    public function similarity($user,$distFunc='euclidean') {
        $sharedPrefs = $this->getSharedPrefs($user);    //remember every preference is a dimension
        if(empty($sharedPrefs)) {
            return 0;
        }
        
        $point1 = array();
        $point2 = array();
        foreach($sharedPrefs as $sharedPref) {
            $point1[] = $this->getPreference($sharedPref);
            $point2[] = $user->getPreference($sharedPref);
        }
        
        return Distance::$distFunc($point1,$point2);
    }
    
    public function getSharedPrefs($user) {
        $myPrefs = $this->getPreferences();
        $othersPrefs = $user->getPreferences();
        
        return array_intersect(array_keys($myPrefs), array_keys($othersPrefs));
    }
    
    public function getPreferences() {
        $prefs = self::getMovieUserRate();
        return isset($prefs[$this->name]) ? $prefs[$this->name] : null;
    }
    
    public function getPreference($key) {
        $prefs = $this->getPreferences();
        return $prefs[$key];
    }
    
    public static function & findAll() {
        $names = array_keys( self::getMovieUserRate() );
        $items = array();
        foreach($names as $name) {
            $items[$name] = new Item($name);
        }
        return $items;
    }
    
    public static function getMovieUserRate() {
        $array = require Yii::getPathOfAlias('application.data') . '/user_movie_rate.php';
        $array = ArrayHelper::array_transpose($array);
        return $array;
    }
}

?>
