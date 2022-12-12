<?php
/**
 * 
 *
 * @package meme_video
 * @author 2F1A
 * @version 1.0
 * @link https://github.com/qaqxhy/meme_video
 */

if (!defined('__TYPECHO_ROOT_DIR__')) {
    exit;
}
class memevideo_Plugin implements Typecho_Plugin_Interface{

    /* 激活插件方法 */
    public static function activate(){
        Typecho_Plugin::factory('Widget_Archive') -> header = array('memevideo_Plugin', 'header');
        Typecho_Plugin::factory('Widget_Archive') -> footer = array('memevideo_Plugin', 'footer');
    }

    /* 禁用插件方法 */
    public static function deactivate(){}

    /* 插件配置方法 */
    public static function config(Typecho_Widget_Helper_Form $form){
        $position = new Typecho_Widget_Helper_Form_Element_Radio('position',
        array(
          'left' => _t('靠左'),
          'right' => _t('靠右'),
        ),
        'right', _t('自定义位置'), _t('自定义视频所在的位置'));
        $form -> addInput($position);

        $autoplay = new Typecho_Widget_Helper_Form_Element_Radio('autoplay',
        array(
          '0' => _t('关闭'),
          '1' => _t('开启'),
        ),
        '1', _t('自动播放'), _t('开启后将自动播放视频'));
        $form -> addInput($autoplay);

        $loop = new Typecho_Widget_Helper_Form_Element_Radio('loop',
        array(
          '0' => _t('关闭'),
          '1' => _t('开启'),
        ),
        '1', _t('循环播放'), _t('开启后将循环播放视频'));
        $form -> addInput($loop);

        $muted = new Typecho_Widget_Helper_Form_Element_Radio('muted',
        array(
          '0' => _t('关闭'),
          '1' => _t('开启'),
        ),
        '1', _t('静音播放'), _t('开启后将静音播放视频,关闭后将无法使用自动播放'));
        $form -> addInput($muted);

        $controls = new Typecho_Widget_Helper_Form_Element_Radio('controls',
        array(
          '0' => _t('关闭'),
          '1' => _t('开启'),
        ),
        '0', _t('HTML视频控件'), _t('开启后将显示视频控件'));
        $form -> addInput($controls);

        $src = new Typecho_Widget_Helper_Form_Element_Text('src', NULL, NULL, _t('视频地址'), _t('在这里填入一个视频地址链接'));// !todo 格式支持
        $form -> addInput($src);

        $custom_width = new Typecho_Widget_Helper_Form_Element_Text('custom_width', NULL, NULL, _t('自定义宽'), _t('在这里填入一个视频宽度,单位px,留空为100'));
        $form -> addInput($custom_width);

        $custom_height = new Typecho_Widget_Helper_Form_Element_Text('custom_height', NULL, NULL, _t('自定义高'), _t('在这里填入一个视频高度,单位px,留空为100'));
        $form -> addInput($custom_height);
    }

    /* 个人用户的配置方法 */
    public static function personalConfig(Typecho_Widget_Helper_Form $form){}

    /**
	 * 
	 * 
	 * @access public
	 * @return void
	 */
    public static function header(){
        echo "
        <style>
    .memevideo
    {
        bottom: 0;
        z-index: 52;
        color: #666;
        position: fixed;
        user-select: none;
    }
    .memevideo.left
    {
        left: 0;
    }
    .memevideo.right
    {
        right: 0;
    }
    .unshowctrl.video::-webkit-media-controls{
        display: none;
    }
    .showctrl.video::-webkit-media-controls{
        display: block;
    }
</style>
        ";
    }
    /**
	 * 
	 * 
	 * @access public
	 * @return void
	 */
    public static function footer(){
        function getHTMLvideo()
        {
             $auto = Typecho_Widget::widget('Widget_Options') -> Plugin('memevideo') -> autoplay;
             $lop = Typecho_Widget::widget('Widget_Options') -> Plugin('memevideo') -> loop;
             $mute = Typecho_Widget::widget('Widget_Options') -> Plugin('memevideo') -> muted;
             $showctrl = Typecho_Widget::widget('Widget_Options') -> Plugin('memevideo') -> controls;
             $link = Typecho_Widget::widget('Widget_Options') -> Plugin('memevideo') -> src;
            $w = Typecho_Widget::widget('Widget_Options') -> Plugin('memevideo') -> custom_width;
            $h = Typecho_Widget::widget('Widget_Options') -> Plugin('memevideo') -> custom_height;
            return '<video id="mvideo" src=" '. ($link) .' " '. ($auto ? "autoplay='autoplay'" : "") .' '.($mute ? "muted='muted'" : "").' '. ($lop ? "loop='loop'" : "") .' width='.($w ? $w : 100).' height='.($h ? $h : 100).'  '. ($showctrl ? "controls='controls'" : "") .'>您的浏览器不支持 video 标签。</video>';
        }
        
        function getVideoDiv()
        {
            $height = Typecho_Widget::widget('Widget_Options') -> Plugin('memevideo') -> custom_height;
            $width = Typecho_Widget::widget('Widget_Options') -> Plugin('memevideo') -> custom_width;
            $pos = Typecho_Widget::widget('Widget_Options') -> Plugin('memevideo') -> position;

            return '<div class="memevideo '.($pos == "right" ? "right" : "left").' "> '.(getHTMLvideo()).' </div>';
        }
        echo (getVideoDiv());
        
    }
}