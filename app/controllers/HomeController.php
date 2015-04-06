<?php

// This class is stored in app/controllers/HomeController.php

class HomeController extends BaseController{

    public function index(){

        return View::make( 'home' )->with( array(

    		'husband'		=> 'Luc',
    		'wife'			=> 'Ellen'


    	));
    }
}

?>