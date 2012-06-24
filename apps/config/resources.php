<?php defined('BASEPATH') OR exit('No direct script access allowed');  

$config['expires'] = 60*60*24*14;
$config['html_expires'] = 0;
$config['resource_folder'] = 'resources/';
$config['photos'] = 'resources/';

$config['static_url'] = $url;
$config['css_url'] = $url;

$config['css']['default'] = array(
     array('path'=>'css/','file'=>'bootstrap.css')
    ,array('path'=>'css/','file'=>'style.css')
    );
    
$config['css']['patcher'] = array(
    array('path'=>'css/','file'=>'patcher.css')
    );
 
$config['css']['loggedin'] = array(
     array('path'=>'css/','file'=>'bootstrap.css')
    ,array('path'=>'css/flexigrid/','file'=>'flexigrid.css')
    ,array('path'=>'css/','file'=>'style.css')
    ,array('path'=>'css/','file'=>'style.loggedin.css')
    );
    
$config['js']['default'] = array(
     array('path'=>'js/','file'=>'jquery-1.7.2.min.js')
    ,array('path'=>'js/','file'=>'bootstrap.min.js')
    ,array('path'=>'js/','file'=>'script.main.js')
    );
 
    
$config['js']['loggedin'] = array(
     array('path'=>'js/','file'=>'jquery-1.7.2.min.js')
    ,array('path'=>'js/','file'=>'bootstrap.min.js')
    ,array('path'=>'js/','file'=>'jquery.livequery.js')
    ,array('path'=>'tiny_mce/','file'=>'jquery.tinymce.js')
    ,array('path'=>'js/','file'=>'flexigrid.js')
    ,array('path'=>'js/','file'=>'char.js')
    ,array('path'=>'js/','file'=>'script.js')
    ,array('path'=>'js/','file'=>'stream.js')
    ,array('path'=>'js/','file'=>'cms.js')
    ,array('path'=>'js/','file'=>'flex.js')
    ,array('path'=>'js/','file'=>'vote.js')
    );

$config['css3_browsers'] = array(
    "Internet Explorer" => 7
    ,"Firefox" => 3.5
    ,"Opera" => 9
    ,"Safari" => 4
    ,"Chrome" => 4
);
