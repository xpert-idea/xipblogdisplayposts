<?php

if (!defined('_CAN_LOAD_FILES_')) {
	exit;
}

class xipblogdisplayposts extends Module {
	public $css_array = array("xipblogdisplayposts.css", "xipblogdisplayposts.css");
	public $js_array = array("xipblogdisplayposts.js", "xipblogdisplayposts.js");
	public function __construct() {
		$this->name = 'xipblogdisplayposts';
		$this->tab = 'front_office_features';
		$this->version = '1.0.1';
		$this->author = 'xpert-idea';
		$this->bootstrap = true;
		$this->dependencies = array('xipblog');
		parent::__construct();
		$this->displayName = $this->l('XipBlog Display Posts');
		$this->description = $this->l('Display Blog Posts Module');
		$this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
	}
	// For installation service
	public function install() {
		if (!parent::install()
			// || !$this->registerHook('displayheader')
			|| !$this->registerHook('displayFooterTop')
			|| !$this->registerHook('displayFooterTopFullwidth')
			// || !$this->registerHook('RightColumn')
			// || !$this->registerHook('displayxipblogleft')
			// || !$this->registerHook('displayxipblogright')
			)
			return false;
		$languages = Language::getLanguages(false);
           	foreach($languages as $lang){
        		Configuration::updateValue('xipbdp_title_'.$lang['id_lang'],"News");
        		Configuration::updateValue('xipbdp_subtext_'.$lang['id_lang'],"All Recent Posts From XipBlog");
           	}
        	Configuration::updateValue('xipbdp_postcount',4);
        	Configuration::updateValue('xipbdp_designlayout','general');
        	Configuration::updateValue('xipbdp_numcolumn',3);
			return true;
	}
	// For uninstallation service
	public function uninstall() {
		if (!parent::uninstall()
			)
			return false;
		else
			return true;
	}
	// Helper Form for Html markup generate
	public function SettingForm() {

		$default_lang = (int) Configuration::get('PS_LANG_DEFAULT');
		$this->fields_form[0]['form'] = array(
			'legend' => array(
				'title' => $this->l('Setting'),
			),
			'submit' => array(
				'title' => $this->l('Save'),
				'class' => 'button',
			),
		);
			$this->fields_form[0]['form']['input'][] = array(
				'type' => 'text',
				'label' => $this->l('Title'),
				'name' => 'xipbdp_title',
				'lang' => true,
			);
			$this->fields_form[0]['form']['input'][] = array(
				'type' => 'text',
				'label' => $this->l('Sub Title'),
				'name' => 'xipbdp_subtext',
				'lang' => true,
			);
			$this->fields_form[0]['form']['input'][] = array(
				'type' => 'text',
				'label' => $this->l('How Many Post You Want To Display'),
				'name' => 'xipbdp_postcount',
			);
			$this->fields_form[0]['form']['input'][] = array(
                'type' => 'select',
                'label' => $this->l('Select number of column to display'),
                'name' => 'xipbdp_numcolumn',
                'options' => array(
                    'query' => array(
                    		array(
                    			'id' => '1',
                    			'name' => '1 column',
                    		),
                    		array(
                    			'id' => '2',
                    			'name' => '2 column',
                    		),
                    		array(
                    			'id' => '3',
                    			'name' => '3 column',
                    		),
                    		array(
                    			'id' => '4',
                    			'name' => '4 column',
                    		),
                    	),
                    'id' => 'id',
                    'name' => 'name'
                )
            );
			$this->fields_form[0]['form']['input'][] = array(
                'type' => 'select',
                'label' => $this->l('Select Design Layout'),
                'name' => 'xipbdp_designlayout',
                'options' => array(
                    'query' => array(
                    		array(
                    			'id' => 'general',
                    			'name' => 'General',
                    		),
                    		array(
                    			'id' => 'classic',
                    			'name' => 'Classic',
                    		),
                    		array(
                    			'id' => 'creative',
                    			'name' => 'Creative',
                    		),
                    	),
                    'id' => 'id',
                    'name' => 'name'
                )
            );
		$helper = new HelperForm();
		$helper->module = $this;
		$helper->name_controller = $this->name;
		$helper->token = Tools::getAdminTokenLite('AdminModules');
		$helper->currentIndex = AdminController::$currentIndex . '&configure=' . $this->name;
		foreach (Language::getLanguages(false) as $lang) {
			$helper->languages[] = array(
				'id_lang' => $lang['id_lang'],
				'iso_code' => $lang['iso_code'],
				'name' => $lang['name'],
				'is_default' => ($default_lang == $lang['id_lang'] ? 1 : 0),
			);
		}
		$helper->toolbar_btn = array(
			'save' => array(
				'desc' => $this->l('Save'),
				'href' => AdminController::$currentIndex . '&configure=' . $this->name . '&save' . $this->name . 'token=' . Tools::getAdminTokenLite('AdminModules'),
			),
		);
		$helper->default_form_language = $default_lang;
		$helper->allow_employee_form_lang = $default_lang;
		$helper->title = $this->displayName;
		$helper->show_toolbar = true;
		$helper->toolbar_scroll = true;
		$helper->submit_action = 'save' . $this->name;
		$languages = Language::getLanguages(false);
           	foreach($languages as $lang){
           		$helper->fields_value['xipbdp_title'][$lang['id_lang']] = Configuration::get('xipbdp_title_'.$lang['id_lang']);
           		$helper->fields_value['xipbdp_subtext'][$lang['id_lang']] = Configuration::get('xipbdp_subtext_'.$lang['id_lang']);
           	}
           	$helper->fields_value['xipbdp_postcount'] = Configuration::get('xipbdp_postcount');
           	$helper->fields_value['xipbdp_designlayout'] = Configuration::get('xipbdp_designlayout');
           	$helper->fields_value['xipbdp_numcolumn'] = Configuration::get('xipbdp_numcolumn');
		return $helper;
	}
	// All Functional Logic here.
	public function getContent() {
		$html = '';
		if (Tools::isSubmit('save' . $this->name)) {
			$languages = Language::getLanguages(false);
               foreach($languages as $lang){
            		Configuration::updateValue('xipbdp_title_'.$lang['id_lang'],Tools::getvalue('xipbdp_title_'.$lang['id_lang']));
            		Configuration::updateValue('xipbdp_subtext_'.$lang['id_lang'],Tools::getvalue('xipbdp_subtext_'.$lang['id_lang']));
               }
            	Configuration::updateValue('xipbdp_postcount',Tools::getvalue('xipbdp_postcount'));
            	Configuration::updateValue('xipbdp_designlayout',Tools::getvalue('xipbdp_designlayout'));
            	Configuration::updateValue('xipbdp_numcolumn',Tools::getvalue('xipbdp_numcolumn'));
		}
		$helper = $this->SettingForm();
		$html .= $helper->generateForm($this->fields_form);
		return $html;
	}
	// Display Header Hook Execute Functions
	public function hookdisplayheader($params) {
		if(isset($this->css_array))
			foreach ($this->css_array as $css) {
				$this->context->controller->addCSS($this->_path.'css/'.$css);
			}
		if(isset($this->js_array))
			foreach ($this->js_array as $js) {
				$this->context->controller->addJS($this->_path.'js/'.$js);
			}
	}
	// Display Header Hook Execute Functions
	public function ExecuteHook(){
		$id_lang = (int)$this->context->language->id;
		$xipbdp_title = Configuration::get('xipbdp_title_'.$id_lang);
		$xipbdp_subtext = Configuration::get('xipbdp_subtext_'.$id_lang);
		$xipbdp_postcount = Configuration::get('xipbdp_postcount');
		$xipbdp_designlayout = Configuration::get('xipbdp_designlayout');
		$xipbdp_numcolumn = Configuration::get('xipbdp_numcolumn');
		$xipblogposts = array();
		if(Module::isInstalled('xipblog') && Module::isEnabled('xipblog')){
			$xipblogposts = xippostsclass::GetCategoryPosts(0,1,$xipbdp_postcount,'post','DESC');
		}
		$xipblogmainlink = xipblog::XipBlogLink();
		$this->smarty->assign(
			array(
				'xipbdp_title' => $xipbdp_title,
				'xipblogmainlink' => $xipblogmainlink,
				'xipbdp_subtext' => $xipbdp_subtext,
				'xipbdp_postcount' => $xipbdp_postcount,
				'xipbdp_designlayout' => $xipbdp_designlayout,
				'xipbdp_numcolumn' => $xipbdp_numcolumn,
				'xipblogposts' => $xipblogposts,
			)
		);
	}
	public function hookdisplayhome($params) {
		$this->ExecuteHook();
		return $this->display(__FILE__,'views/templates/front/xipblogdisplayposts.tpl');	
	}
	public function hookdisplayFooterTop($params) {
		$this->ExecuteHook();
		return $this->display(__FILE__,'views/templates/front/xipblogdisplayfooterposts.tpl');	
	}
	public function hookdisplayFooterTopFullwidth($params) {
		$this->ExecuteHook();
		return $this->display(__FILE__,'views/templates/front/xipblogdisplayfooterposts.tpl');	
	}
	public function hookLeftColumn($params) {
		$this->ExecuteHook();
		return $this->display(__FILE__,'views/templates/front/xipblogdisplayleftposts.tpl');	
	}
	public function hookRightColumn($params) {
		$this->ExecuteHook();
		return $this->display(__FILE__,'views/templates/front/xipblogdisplayleftposts.tpl');	
	}
	public function hookdisplayxipblogleft($params) {
		$this->ExecuteHook();
		return $this->display(__FILE__,'views/templates/front/xipblogdisplayleftposts.tpl');	
	}
	public function hookdisplayxipblogright($params) {
		$this->ExecuteHook();
		return $this->display(__FILE__,'views/templates/front/xipblogdisplayleftposts.tpl');	
	}
	// Display Header Hook Execute Functions
	public function hookdisplayHomeBottom($params) {
		$this->ExecuteHook();
		return $this->display(__FILE__,'views/templates/front/xipblogdisplayposts.tpl');
	}
	public function hookdisplayHomeMiddle($params) {
		$this->ExecuteHook();
		return $this->display(__FILE__,'views/templates/front/xipblogdisplayposts.tpl');
	}
}