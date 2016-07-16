<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Clustering
 *
 * @author pligor
 */
class Clustering extends CComponent {
    /**
     * 
     * @var Cluster[]
     */
    public $clusters;
    
    public $rows;
    
    public $distances = array();
    
    public function readFile() {
        $file = Yii::getPathOfAlias('application.data') .'/blogdata.txt';
        $delimiter = "\t";
        
        return CsvHelper::parseCsvWithRowsColumns($file, $delimiter);
    }
    
    public function init() {
        extract($this->readFile()); //rowNames, colNames
        
        $this->rows = $rowNames;
        
        $this->clusters = array();
        
        for($i=0;$i<count($rowNames);$i++) {
            $this->clusters[$i] = new Cluster($data[$i], $i);
        }
    }
    
    /**
     * Hierarchical Clustering
     * returns the root node
     * @return Cluster
     */
    public function hcluster() {
        $this->init();
        while( count($this->clusters) >1 ) {
        //for($c=0;$c<2;$c++) {
            extract( $this->findClosestPair() );    //pair,distance
            $branches['left'] = $this->clusters[reset($pair)];
            $branches['right'] = $this->clusters[end($pair)];
            $avgVec = $branches['left']->mergeVec($branches['right']);
            
            $id = $branches['left']->id .'_'. $branches['right']->id;
            
            $mergedCluster = new Cluster($avgVec, $id, $branches['left'], $branches['right'], $distance);
            $this->insertCluster($mergedCluster);
        }
        
        return $mergedCluster;
    }
    
    public function renderDendrogram($node,$mult=0) {
        $ind = ' ';
        
        if($node===null) {
            return;
        }
        
        print str_repeat($ind, $mult);
        if( isset($this->rows[$node->id]) ) {
            print $this->rows[$node->id];
        }
        else {
            print '-';
        }
        print "\n";
        
        
        $mult++;
        
        $this->renderDendrogram($node->left, $mult);
        $this->renderDendrogram($node->right, $mult);
    }
    
    /**
     *
     * @param Cluster $cluster 
     */
    public function insertCluster($cluster) {
        $this->clusters[$cluster->id] = $cluster;
        if($cluster->left instanceof Cluster) {
            unset( $this->clusters[$cluster->left->id] );
        }
        if($cluster->right instanceof Cluster) {
            unset( $this->clusters[$cluster->right->id] );
        }
    }
    
    public function getOtherClusters($cluster) {
        $clusters = $this->clusters;
        unset($clusters[$cluster->id]);
        return $clusters;
    }
    
    /**
     * 
     * @return array
     */
    public function findClosestPair() {
        $distance = PHP_INT_MAX;
        
        foreach($this->clusters as $i => $cluster) {
            $otherClusters = $this->getOtherClusters($cluster);
            foreach($otherClusters as $j => $otherCluster ) {
                if( isset($this->distances[$i][$j]) ) {
                    $d = $this->distances[$i][$j];
                }
                elseif( isset($this->distances[$j][$i]) ) {
                    $d = $this->distances[$j][$i];
                }
                else {
                    $this->distances[$i][$j] = Distance::pearson($this->clusters[$i]->vec, $this->clusters[$j]->vec);
                    $d = $this->distances[$i][$j];
                }
                
                if($d < $distance) {
                    $distance = $d;
                    $pair = array($i,$j);
                }
            }
        }
        return compact('pair','distance');
    }
    /*
    public function findClosestPair() {
        $count = count($this->clusters);
        
        $distance = PHP_INT_MAX;
        
        for($i=0;$i<$count;$i++) {
            for($j=$i+1;$j<$count;$j++) {   //here is a trick to avoid recalculating same distances
                if( !isset($this->distances[$i][$j]) ) {
                    $this->distances[$i][$j] = Distance::pearson($this->clusters[$i]->vec, $this->clusters[$j]->vec);
                }
                $d = $this->distances[$i][$j];
                
                if($d < $distance) {
                    $distance = $d;
                    $pair = array($i,$j);
                }
            }
        }
        return compact('pair','distance');
    }
    //*/
}

?>
