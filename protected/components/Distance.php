<?php
/**
 * Description of Distance
 *
 * @author pligor
 */
class Distance extends CComponent {
    
    public static function euclidean($point1, $point2) {
        $dist = 0;
        foreach($point1 as $key => $val1) {
            $dist += pow($val1-$point2[$key], 2);
        }
        return sqrt($dist);
    }
    
    /**
     * http://en.wikipedia.org/wiki/Pearson_product-moment_correlation_coefficient
     * @param array $point1
     * @param array $point2
     * @return float 
     */
    public static function pearson($point1, $point2) {
        $sum1 = array_sum($point1);
        $sum2 = array_sum($point2);
        
        $inlineFunc = function($input) {
            return pow($input, 2);
        };
        
        $sum1sq = array_sum(array_map($inlineFunc, $point1));
        $sum2sq = array_sum(array_map($inlineFunc, $point2));
        
        $prod_sum = 0;
        foreach($point1 as $key => $val1) {
            $prod_sum += $val1*$point2[$key];
        }
        
        $n = count($point1);
        
        $nom = $prod_sum - ($sum1*$sum2)/$n;
        $denom = sqrt( ($sum1sq - pow($sum1,2)/$n)*($sum2sq - pow($sum2,2)/$n) );
        
        if($denom==0) {
            return 0;
        }
        
        return 1-($nom/$denom);
        /*
         * Remember that the Pearson correlation is 1.0 when two items match perfectly, and is
         * close to 0.0 when there’s no relationship at all. The final line of the code
         * returns 1.0 minus the Pearson correlation to create a smaller distance between
         * items that are more similar
         * (it can also take values from -1 to 0 if there is an inverse linear relation, but that's ok)
         */
    }
}

?>
