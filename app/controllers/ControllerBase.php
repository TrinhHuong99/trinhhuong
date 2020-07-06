<?php

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{
    public function initialize()
    {
        $this->view->setTemplateAfter('home');

        $this->assets->addCss('bower_components/bootstrap/css/bootstrap.min.css');
        $this->assets->addCss('assets/pages/waves/css/waves.min.css');
        $this->assets->addCss('assets/icon/feather/css/feather.css');
        $this->assets->addCss('assets/css/style.css');
        $this->assets->addCss('assets/css/widget.css');
        $this->assets->addCss('assets/css/pages.css');
//        $this->assets->addCss('assets/css/mystyle.css');
        $this->assets->addCss('assets/icon/material-design/css/material-design-iconic-font.min.css');
        $this->assets->addCss('assets/icon/themify-icons/themify-icons.css');
        $this->assets->addCss('assets/icon/icofont/css/icofont.css');
        $this->assets->addCss('assets/icon/font-awesome/css/font-awesome.min.css');
        $this->assets->addCss('assets/icon/ion-icon/css/ionicons.min.css');


        // And some local JavaScript resources
        // Warning Section Ends
        // Required Jquery
        $this->assets->addJs('bower_components/jquery/js/jquery.min.js');
        $this->assets->addJs('bower_components/jquery-ui/js/jquery-ui.min.js');
        $this->assets->addJs('bower_components/popper.js/js/popper.min.js');
        $this->assets->addJs('bower_components/bootstrap/js/bootstrap.min.js');
        // waves js
        $this->assets->addJs('assets/pages/waves/js/waves.min.js');
        // jquery slimscroll js
        $this->assets->addJs('bower_components/jquery-slimscroll/js/jquery.slimscroll.js');
        // modernizr js
        $this->assets->addJs('assets/pages/chart/float/jquery.flot.js');
        $this->assets->addJs('assets/pages/chart/float/jquery.flot.categories.js');
        // i18next.min.js

//        $this->assets->addJs('assets/pages/chart/float/curvedLines.js');
//        $this->assets->addJs('assets/pages/chart/float/jquery.flot.tooltip.min.js');
//        $this->assets->addJs('assets/pages/widget/amchart/amcharts.js');
//        $this->assets->addJs('assets/pages/widget/amchart/serial.js');
//        $this->assets->addJs('assets/pages/widget/amchart/light.js');


        $this->assets->addJs('assets/js/pcoded.min.js');
        $this->assets->addJs('assets/js/vertical/vertical-layout.min.js');
        $this->assets->addJs('assets/js/script.min.js');
    }
}
