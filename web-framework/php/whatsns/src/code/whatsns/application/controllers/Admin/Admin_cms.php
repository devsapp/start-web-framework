<?php

defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Admin_cms extends ADMIN_Controller {

  	function __construct() {
		parent::__construct ();
        $this->load->model('setting_model');
    }

    function setting() {
    	if (null !== $this->input->post ( 'submit' )) {
            $this->setting['cms_open'] = intval($this->input->post ('cms_open'));
            $config = "<?php \r\n";
            if($this->input->post ('cms_db_config')){
                $config .= trim($this->input->post ('cms_db_config'))."\r\n";
            }
            if($this->input->post ('cms_db_article')){
                $config .= trim($this->input->post ('cms_db_article'));
            }
            writetofile(FCPATH . '/data/cms.config.inc',  tstripslashes($config));
            $message = 'cms参数配置完成！';
            $this->setting_model->update($this->setting);
        }
        include template("cms_setting", "admin");
    }

}
