<?php
/**
 * Typically nothing to be rendered here
 *
 * @author pligor
 */
class MovieMeterController extends Controller {
    /**
     * You can have static actions or declare them dynamically here
     */
    public function actions() {
        return array(
            /*'captcha'=>array(
                'class'=>'CCaptchaAction',
                'backColor'=>0xFFFFFF,
            ),*/
        );
    }
    
    //"user" N-N relation with "movie"
    
    public function actionHate($uid, $movie_id) {
        print "store $uid rates the movie_id as 1 star";
    }
    
    public function actionBad() {
        print "store $uid rates the movie_id as 2 stars";
    }
    
    public function actionIndifferent() {
        print "store $uid rates the movie_id as 3 stars";
    }
    
    public function actionLike() {
        print "store $uid rates the movie_id as 4 stars";
    }
    
    public function actionLove() {
        print "store $uid rates the movie_id as 5 stars";
    }
}