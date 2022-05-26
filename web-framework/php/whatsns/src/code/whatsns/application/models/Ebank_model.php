<?php
require FCPATH . 'lib/alipay/alipay_service.class.php';
require FCPATH . 'lib/alipay/alipay_notify.class.php';

class Ebank_model  extends CI_Model{

	function __construct() {
		parent::__construct ();
		$this->load->database ();
	}

    function aliapytransfer($rechargemoney,$mtype="财富充值",$return_url='',$body='',$notify_url='') {
        $aliapy_config = include FCPATH . 'data/alipay.config.php';

        $tradeid = "u-" . strtolower(random(6));
        if($return_url==''){
        	$return_url=trim($aliapy_config['return_url']);
        }else{
        	$aliapy_config['return_url']=$return_url;
        }
      if($notify_url==''){
        	$return_url=trim($aliapy_config['notify_url']);
        }else{
        	$aliapy_config['notify_url']=$notify_url;
        }
        if($body==''){
        	$body=$mtype;
        }

        //构造要请求的参数数组
        $parameter = array(
            "service" => "create_direct_pay_by_user",
            "payment_type" => "1",
            "partner" => trim($aliapy_config['partner']),
            "_input_charset" => trim(strtolower($aliapy_config['input_charset'])),
            "seller_email" => trim($aliapy_config['seller_email']),
            "return_url" =>$aliapy_config['return_url'] ,
            "notify_url" => trim($aliapy_config['notify_url']),
            "out_trade_no" => $tradeid,
            "subject" => $mtype,
            "body" => $body,
            "total_fee" => $rechargemoney,
            "paymethod" => '',
            "defaultbank" => '',
            "anti_phishing_key" => '',
            "exter_invoke_ip" => '',
            "show_url" => '',
            "extra_common_param" => '',
            "royalty_type" => '',
            "royalty_parameters" => ''
        );

        //构造即时到帐接口
        $alipayService = new AlipayService($aliapy_config);
        $html_text = $alipayService->create_direct_pay_by_user($parameter);
        echo $html_text;
    }

    /**
     * 针对return_url验证消息是否是支付宝发出的合法消息
     * @return 验证结果
     */
    function aliapyverifyreturn($return_url='') {
        $aliapy_config = include FCPATH . 'data/alipay.config.php';
       if($return_url==''){
        	$return_url=trim($aliapy_config['return_url']);
        }else{
        	$aliapy_config['return_url']=$return_url;
        }
        $alipayNotify = new AlipayNotify($aliapy_config, $this->input->get, $this->input->post);
        return $alipayNotify->verifyReturn();
    }
   /**
     * 针对notify_url验证消息是否是支付宝发出的合法消息
     * @return 验证结果
     */
    function aliapyverifyNotify($notify_url='') {
        $aliapy_config = include FCPATH . 'data/alipay.config.php';
       if($notify_url==''){
        	$notify_url=trim($aliapy_config['notify_url']);
        }else{
        	$aliapy_config['notify_url']=$notify_url;
        }
        $alipayNotify = new AlipayNotify($aliapy_config,  $this->input->get, $this->input->post);
        return $alipayNotify->verifyNotify();
    }
}

?>