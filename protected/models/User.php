<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of User
 *
 * @author pligor
 */
class User extends Model {
    public $name;
    
    public function __construct($name=null) {
        $this->name = $name;
    }
    
    /**
     * This is using the result.php produced from the item-based algorithm
     */
    public function getRecommendedItems() {
        $prefs = $this->getPreferences();
        //print_r($prefs);
        
        $itemNames = array_keys($prefs);
        
        $itemMatches = require Yii::getPathOfAlias('application.data') .'/result.php';
        
        $scores = array();
        $simSum = array();
        foreach($prefs as $itemName => $rate) {
            $itemResults = $itemMatches[$itemName];
            foreach($itemResults as $itemName2 => $similarity) {
                if( in_array($itemName2, $itemNames) ) {
                    continue;
                }
                
                if(!isset($scores[$itemName2])) $scores[$itemName2]=0;
                if(!isset($simSum[$itemName2])) $simSum[$itemName2]=0;
                
                $scores[$itemName2] += $similarity * $rate;
                $simSum[$itemName2] += $similarity;
            }
        }
        
        $rankings = array();
        foreach($scores as $key => $score) {
            $rankings[$key] = $score/$simSum[$key];
        }
        
        arsort($rankings,SORT_NUMERIC);
        
        return $rankings;
    }
    
    public function getRecommendations($distFunc='pearson',$n=3) {
        $others = $this->findOthers();
        $scores = $this->mostSimilars($distFunc,INF);   //get all
        
        $myItems = array_keys( $this->getPreferences() );
        
        $totals = array();
        $similaritySums = array();
        
        foreach($others as $other) {
            
            $othersPrefs = $other->getPreferences();
            $items = array_keys($othersPrefs);
            
            $newItems = array_diff($items, $myItems);
            
            foreach($newItems as $newItem) {
                if(!isset($totals[$newItem])) $totals[$newItem] = 0;
                if(!isset($similaritySums[$newItem])) $similaritySums[$newItem] = 0;
                
                $totals[$newItem] += $othersPrefs[$newItem]*$scores[$other->name];
                $similaritySums[$newItem] += $scores[$other->name];
            }
        }
        
        $rankings = array();
        foreach($totals as $item => $total) {
            $rankings[$item] = $total/$similaritySums[$item];
        }
        
        arsort($rankings,SORT_NUMERIC);
        
        while(count($rankings)>$n) {
            array_pop($rankings);
        }
        
        return $rankings;
    }
    
    public function mostSimilars($distFunc='pearson',$n=3) {
        $usernames = self::findAllUsers();
        unset($usernames[ reset(array_keys($usernames,$this->name)) ]);
        
        $scores = array();
        foreach($usernames as $username) {
            $user = new User($username);
            $scores[$username] = $this->similarity($user,$distFunc);
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
        $prefs = self::getUserMovieRate();
        return isset($prefs[$this->name]) ? $prefs[$this->name] : null;
    }
    
    public function getPreference($key) {
        $prefs = $this->getPreferences();
        return $prefs[$key];
    }
    
    public static function findAllUsers() {
        return array_keys( self::getUserMovieRate() );
    }
    
    public static function & findAll() { 
        $usernames = self::findAllUsers();
        $users = array();
        foreach($usernames as $username) {
            $users[$username] = new User($username);
        }
        return $users;
    }
    
    public function & findOthers() {
        $users = self::findAll();
        unset($users[$this->name]);
        return $users;
    }
    
    public static function getUserMovieRate() {
        $array = require Yii::getPathOfAlias('application.data') . '/user_movie_rate.php';
        return $array;
    }
}