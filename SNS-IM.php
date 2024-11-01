<?php
/*
Plugin Name: 跨站聊天
Plugin URI: http://cnidgroup.com/
Description: 跨站聊天
Version: 0.1
Author: Prince
Author URI: http://cnidgroup.com/

*/

function get_sofa(){
global $user_ID;
?>
	<script type="text/javascript" src="http://cnidgroup.com/station.php?type=1&blog_name=<? bloginfo("name")?>&blog_admin=<? echo $user_ID?>&blog_url=<? bloginfo("url")?>"></script>
	<script type="text/javascript">view_other_user(0,'user','radomfriends');</script>
<?
}

function sofa(){
	$output = get_sofa();
	echo $output;
}

function widget_sidebar_sofa() {
	if ( !function_exists('register_sidebar_widget') || !function_exists('register_widget_control') )
		return;

	function widget_sofa($args) {
	    extract($args);
		echo $before_widget;
		
		$sofa_options = get_option('widget_sofa');
		$title = $sofa_options['title'];

		if ( empty($title) )	$title = '聊天窗口'; //设置默认的标题
		
		echo $before_title . $title . $after_title;

		$output = get_sofa();
		echo $output;

		echo $after_widget;
	}
 register_sidebar_widget('跨站聊天', 'widget_sofa');
	
	function widget_sofa_options() {
		global $user_ID;
		$sofa_options = $new_sofa_options = get_option('widget_sofa'); //获取数据库中的 widget_sofa
		if ( $_POST["sofa_submit"] ) { //如果提交更新
			$new_sofa_options['title'] = strip_tags(stripslashes($_POST["sofa_title"]));
			if ( $sofa_options != $new_sofa_options ) { //如果有更新
				$sofa_options = $new_sofa_options;
				update_option('widget_sofa', $sofa_options);
			}
		}
		$title = attribute_escape($sofa_options['title']);
?>
		<p><label for="wp_sofa_title"><?php _e('Title:'); ?> <input style="width: 80%;" id="sofa_title" name="sofa_title" type="text" value="<?php echo $title; ?>" /></label></p>
		<input type="hidden" id="sofa_submit" name="sofa_submit" value="1" />
	您的帐号信息：
	<iframe width="100%" height="48px" style="border:0" src="http://cnidgroup.com/station.php?type=3&blog_name=<? bloginfo("name")?>&blog_admin=<? echo $user_ID?>&blog_url=<? bloginfo("url")?>"></iframe>
	您可以在站外用此帐号登录，网站管理员登录后即自动登录
<?php
	}
	
	register_widget_control('跨站聊天', 'widget_sofa_options', 250, 90);
}

add_action('plugins_loaded', 'widget_sidebar_sofa');
?>