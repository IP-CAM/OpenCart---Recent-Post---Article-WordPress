<?php  
ini_set("memory_limit","24M");
require_once(DIR_SYSTEM . 'library/wordpress.php');

class ControllerModuleWordpressBlog extends Controller {
	
	protected function index($setting) {
		static $module = 0;
		
		$this->load->model('setting/setting');
		
		$this->language->load('module/wordpress_blog');
		
		// Get Text for Module
    	$this->data['heading_title'] = $this->language->get('heading_title');
		$this->data['by_txt'] = $this->language->get('by_txt');
		$this->data['read_more_txt'] = $this->language->get('read_more_txt');
		
		// Get Configuration
		$configuration= $this->model_setting_setting->getSetting('wordpress_blog_configuration');

		$posts= array();
		if( ! empty($configuration) ){
		$fields= array('length_description', 'format_date', 'posts_per_page');
		$fields = array_combine($fields, $configuration);
		$args= "?";
		foreach( $fields as $key=>$field ){
			$args.= "&" . $key . "=" . urlencode($field);
		}
		
		if( isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || 
		( $this->request->server['HTTPS'] == '1' )) ){
			$base_url= HTTPS_SERVER;
		}else{
			$base_url= HTTP_SERVER;
		}
		$url= $base_url . 'system/library/wordpress_ext.php' . $args;
		
		// Start Fetch Wordpress Post / Article
		$wordpress_posts_ins= new WordPressPosts($url);
		$posts= json_decode($wordpress_posts_ins->get());
		// End Fetch Wordpress Post / Article
		}else{
			// Set Text for Empty Data
			$this->data['empty_data'] = $this->language->get('empty_data');
		}
		
		// Check Position Horizontal or Vertical
		if( $setting['type'] == "horizontal" ){
			$this->document->addStyle('catalog/view/javascript/wordpress_blog/horizontal.css');
		}else{
			$this->document->addStyle('catalog/view/javascript/wordpress_blog/vertical.css');			
		}
		
		$this->data['setting']= $setting;
		$this->data['posts']= $posts;
		$this->data['module']= $module++;
		
		if( file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/wordpress_blog.tpl') ){
			$this->template = $this->config->get('config_template') . '/template/module/wordpress_blog.tpl';
		}else{
			$this->template = 'default/template/module/wordpress_blog.tpl';
		}
		
		$this->render();
	}
}
?>