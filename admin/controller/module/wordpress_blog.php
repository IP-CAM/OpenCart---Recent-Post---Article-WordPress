<?php
require_once(DIR_SYSTEM . 'library/validation.php');
class ControllerModuleWordpressBlog extends Controller {
	private $error= array();
	private $list= array();

	public function get_list_of_pages(){
		$this->language->load('module/wordpress_blog');
		$this->pages= array(
		"blog_configuration"=>array(
		'label'=>$this->language->get('text_btn_go_to_blog_configuration'),
		'url'=>$this->url->link('module/wordpress_blog/configuration', 'token=' . $this->session->data['token'], 'SSL')
		),
		"blog_locator"=>array(
		'label'=>$this->language->get('text_btn_go_to_blog_locator'),
		'url'=>$this->url->link('module/wordpress_blog/locator', 'token=' . $this->session->data['token'], 'SSL')
		),
		);
		
		return $this->pages;
	}

	public function index() {
		$this->language->load('module/wordpress_blog');
		$this->load->model('setting/setting');

		$this->document->setTitle($this->language->get('heading_title'));
		
		// Start Get Text
		$this->data['heading_title'] = $this->language->get('heading_title');
		$this->data['heading_title_dashboard'] = $this->language->get('heading_title_dashboard');
		$this->data['description'] = $this->language->get('description');
		$this->data['text_btn_go_to_lookbook_category'] = $this->language->get('text_btn_go_to_lookbook_category');
		$this->data['text_btn_go_to_lookbook_products'] = $this->language->get('text_btn_go_to_lookbook_products');
		$this->data['text_btn_place_your_lookbook_on_opencart_page'] = $this->language
		->get('text_btn_place_your_lookbook_on_opencart_page');
		
		$this->data['text_btn_back'] = $this->language->get('text_btn_back');
		$this->data['button_save'] = $this->language->get('button_save');
		
		$this->data['pages']= $this->get_list_of_pages();
		// End Get Text
		
		$this->data['edit_link']= $this->url->link('module/email_template_manager/edit_template', 'token=' . 
		$this->session->data['token'], 'SSL');
	
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];	
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}
				
		// BreadCrumb Trail
  		$this->data['breadcrumbs'] = array();
		
   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/wordpress_blog', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . 
		$this->session->data['token'], 'SSL');
		
		$this->data['token'] = $this->session->data['token'];
		
		$this->template = 'module/wordpress_blog/dashboard.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
		
		$this->response->setOutput($this->render());
	}
	
	public function configuration(){
    	$this->language->load('module/wordpress_blog/configuration_form');

    	$this->document->setTitle($this->language->get('heading_title')); 
		
		$this->load->model('setting/setting');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateConfiguration()) {
			$POST= $this->request->post;
			
			$this->model_setting_setting->editSetting('wordpress_blog_configuration', $POST);
			
			$this->session->data['success'] = $this->language->get('text_success');
			
			$this->redirect($this->url->link('module/wordpress_blog/configuration', 'token=' . 
			$this->session->data['token'], 'SSL'));
		}
	
    	$this->getConfigurationForm();
  	}
	
	protected function getConfigurationForm(){
    	$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_wordpress_url_feed'] = $this->language->get('text_wordpress_url_feed');
		$this->data['text_number_of_post_article'] = $this->language->get('text_number_of_post_article');
		$this->data['text_format_date'] = $this->language->get('text_format_date');
		$this->data['text_format_date_url'] = $this->language->get('text_format_date_url');
		$this->data['text_length_description'] = $this->language->get('text_length_description');
		
    	$this->data['text_label_name'] = $this->language->get('text_label_name');
    	$this->data['text_label_image'] = $this->language->get('text_label_image');
		$this->data['text_image_manager'] = $this->language->get('text_image_manager');
    	$this->data['text_browse'] = $this->language->get('text_browse');
    	$this->data['text_clear'] = $this->language->get('text_clear');
		
    	$this->data['button_save'] = $this->language->get('button_save');
    	$this->data['button_cancel'] = $this->language->get('button_cancel');
    	
 		if( isset($this->error['warning']) ){
			$this->data['error_warning'] = $this->error['warning'];
		} 
		else {
			$this->data['error_warning'] = '';
		}
		
		// Start BreadCrumb Trail
  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);
		
   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_modules'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);		

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_wordpress_blog'),
			'href'      => $this->url->link('module/wordpress_blog', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_wordpress_blog_configuration'),
			'href'      => $this->url->link('module/wordpress_blog/configuration', 'token=' . 
			$this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		// End BreadCrumb Trail
				
		// Start Button Url
		$this->data['action'] = $this->url->link('module/wordpress_blog/configuration', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['cancel'] = $this->url->link('module/wordpress_blog/', 'token=' . $this->session->data['token'], 'SSL');
		// End Button Url
		
		// Start Load Configuration
		$this->data['modules'] = array();
		if( $this->request->server['REQUEST_METHOD'] == 'POST' ){
			// Get LookBook Module Configuration and Display Errors
			$this->data['modules'] = $this->request->post;
		}else{
			$wordpress_blog_configuration= $this->model_setting_setting->getSetting('wordpress_blog_configuration');
			if( $wordpress_blog_configuration ){
				$this->data['modules'] = $wordpress_blog_configuration;
			}
		}
		
		$this->load->model('design/layout');
		$this->data['layouts'] = $this->model_design_layout->getLayouts();
		
		// Get Error
		$this->data['errors'] = $this->error;
		
		// End Load Configuration
		
		$this->template = 'module/wordpress_blog/configuration_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
  	}
	
	public function locator(){
		$this->language->load('module/wordpress_blog/locator');
		
		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateLocator()) {
			$POST= $this->request->post;
			$this->model_setting_setting->editSetting('wordpress_blog', $POST);		
			
			$this->session->data['success'] = $this->language->get('text_success');
						
			$this->redirect($this->url->link('module/wordpress_blog/locator', 'token=' . 
			$this->session->data['token'], 'SSL'));
		}
				
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		
		$positions= array(
		'content_top'=>$this->language->get('text_content_top'),
		'content_bottom'=>$this->language->get('text_content_bottom'),
		'column_left'=>$this->language->get('text_column_left'),
		'column_right'=>$this->language->get('text_column_right'),
		);
		$this->data['positions'] = $positions;
		$this->data['types'] = array('horizontal', 'vertical');
		
		$this->data['entry_category'] = $this->language->get('entry_category'); 
		$this->data['entry_dimension'] = $this->language->get('entry_dimension');
		$this->data['entry_layout'] = $this->language->get('entry_layout');
		$this->data['entry_position'] = $this->language->get('entry_position');
		$this->data['entry_type'] = $this->language->get('entry_type');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_add_module'] = $this->language->get('button_add_module');
		$this->data['button_remove'] = $this->language->get('button_remove');
		
 		if( isset($this->error['warning']) ){
			$this->data['error_warning'] = $this->error['warning'];
		} 
		else {
			$this->data['error_warning'] = '';
		}
		
		// Start BreadCrumb Trail
  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);
		
   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_modules'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_wordpress_blog'),
			'href'      => $this->url->link('module/wordpress_blog', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_wordpress_blog_locator'),
			'href'      => $this->url->link('module/wordpress_blog/locator', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		// End BreadCrumb Trail
				
		// Start Button Url
		$this->data['action'] = $this->url->link('module/wordpress_blog/locator', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['cancel'] = $this->url->link('module/wordpress_blog/', 'token=' . $this->session->data['token'], 'SSL');
		// End Button Url
		
		// Start Load Configuration
		$this->data['modules'] = array();
		if( $this->request->server['REQUEST_METHOD'] == 'POST' ){
			// Get LookBook Module Configuration and Display Errors
			$this->data['modules'] = $this->request->post['wordpress_blog_module'];
		}else{
			if( $this->config->get('wordpress_blog_module') ){
				$this->data['modules'] = $this->config->get('wordpress_blog_module');
			}
		}
		
		$this->load->model('design/layout');
		$this->data['layouts'] = $this->model_design_layout->getLayouts();
		
		// Get Error
		$this->data['errors'] = $this->error;
		
		// End Load Configuration
		
		$this->template = 'module/wordpress_blog/locator.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}
		
	protected function validateConfiguration(){
		$this->language->load('module/wordpress_blog/configuration_form');
		
    	if( !$this->user->hasPermission('modify', 'module/wordpress_blog') ){
      		$this->error['warning'] = $this->language->get('error_permission');
    	}
		
		$POST= $this->request->post;
		$fields= array(
		array(
		'name'=>'number_of_post_article',
		'validators'=>array(
			array(
	        'name'=>'Digits',
			'constructor'=>array(''),
			'message'=>"Input failed. Please fill digits only.",
	        ),
			),
		),
		array(
		'name'=>'format_date',
		'validators'=>array(
			array(
	        'name'=>'Regex',
			'constructor'=>array('pattern'=>'/^[dDjlNSwzWFmMntLoYyaABgGhHisueIOPTZcrU ,-]+$/'),
			'message'=>"Input failed. Please fill with valid characters 
			( d D j l N S w z W F m M n t L o Y y a A B g G h H i s u e I O P T Z c r U space comma strip).",
	        ),
			),
		),
		array(
		'name'=>'length_description',
		'validators'=>array(
			array(
	        'name'=>'Digits',
			'constructor'=>array(''),
			'message'=>"Input failed. Please fill digits only.",
	        ),
			),
		),
		);
		
		try {
			$validation= new Validation($fields);
			$messages= $validation->validate($POST);
		}catch(Exception $e){
			echo "<pre>";
			print_r($e);
			echo "</pre>";
		}
		// Store Error Messages
		$this->error= $messages;
		
		if( !$this->error ){
			return true;
		}else{
			return false;
		}	
  	}
	
	protected function validateLocator() {
		if( !$this->user->hasPermission('modify', 'module/wordpress_blog') ){
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		$POST= $this->request->post;
		if (isset($this->request->post['wordpress_blog_module'])) {
		}
				
		if( !$this->error ){
			return true;
		}else{
			return false;
		}	
	}
}
?>