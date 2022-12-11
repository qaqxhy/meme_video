<?php
/**
 * 
 *
 * @package meme_video
 * @author 2F1A
 * @version 0.1
 * @link 
 */

class meme_video_Plugin implements Typecho_Plugin_Interface{

    /* 激活插件方法 */
    public static function activate(){
        Typecho_Plugin::factory('Widget_Archive') -> header = array('meme_video_Plugin', 'header');
        Typecho_Plugin::factory('Widget_Archive') -> footer = array('meme_video_Plugin', 'footer');
    }

    /* 禁用插件方法 */
    public static function deactivate(){}

    /* 插件配置方法 */
    public static function config(Typecho_Widget_Helper_Form $form){

    }

    /* 个人用户的配置方法 */
    public static function personalConfig(Typecho_Widget_Helper_Form $form){}

    /* 插件实现方法 */
    public static function header($archive){
        
    }
    public static function footer($archive){
        
    }
}