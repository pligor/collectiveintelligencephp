<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Cluster
 *
 * @author pligor
 */
class Cluster extends Model {
    /**
     * the array of the data for the current cluster
     * @var int[]
     */
    public $vec;
    
    /**
     * left branch
     * @var Cluster
     */
    public $left;
    
    /**
     * right branch
     * @var Cluster
     */
    public $right;
    
    /**
     * 
     * @var float
     */
    public $distance;
    
    public $id;
    
    public function __construct($vec=null,$id=null,$left=null,$right=null,$distance=0) {
        $this->vec = $vec;
        $this->left = $left;
        $this->right = $right;
        $this->distance = $distance;
        $this->id = $id;
    }
    
    public function mergeVec($cluster) {
        $avgVec = array();
        foreach($this->vec as $key => $value) {
            $avgVec[$key] = ($value+$cluster->vec[$key])/2;
        }
        return $avgVec;
    }
}

?>
