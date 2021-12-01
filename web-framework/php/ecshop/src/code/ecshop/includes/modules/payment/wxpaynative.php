<?php
/**
 * ECSHOP 中国银联支付
 * ============================================================================
 * 版权所有 2005-2018 上海商派网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.ecshop.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 */

if (!defined('IN_ECS'))
{
    die('Hacking attempt');
}

$payment_lang = ROOT_PATH . 'languages/' .$GLOBALS['_CFG']['lang']. '/payment/wxpaynative.php';

if (file_exists($payment_lang))
{
    global $_LANG;

    include_once($payment_lang);
}


/* 模块的基本信息 */
if (isset($set_modules) && $set_modules == TRUE)
{
    $i = isset($modules) ? count($modules) : 0;

    /* 代码 */
    $modules[$i]['code']    = basename(__FILE__, '.php');

    /* 描述对应的语言项 */
    $modules[$i]['desc']    = 'wxpaynative_desc';

    /* 是否支持货到付款 */
    $modules[$i]['is_cod']  = '0';

    /* 是否支持在线支付 */
    $modules[$i]['is_online']  = '1';

    /* 作者 */
    $modules[$i]['author']  = 'ECSHOP TEAM';

    /* 网址 */
    $modules[$i]['website'] = 'http://www.ecshop.com';

    /* 版本号 */
    $modules[$i]['version'] = '1.0.0';

    /* 配置信息 */
    $modules[$i]['config']  = array(
        array('name' => 'wxpaynative_appid',           'type' => 'text',   'value' => ''),
        array('name' => 'wxpaynative_appsecret',       'type' => 'text',   'value' => ''),
        array('name' => 'wxpaynative_mchid',      'type' => 'text',   'value' => ''),
        array('name' => 'wxpaynative_key',      'type' => 'text', 'value' => ''),
    );
    return;
}


class wxpaynative
{

    var $parameters; // cft 参数
    var $payment; // 配置信息

    /**
     * 生成支付代码
     * @param   array   $order      订单信息
     * @param   array   $payment    支付方式信息
     */
    public function get_code($order, $payment)
    {
        
        //为respond做准备
        $this->payment = $payment;
        
        $site_url=$GLOBALS['ecs']->url();

        $notify_url = $site_url.'/respond.php';

        $this->setParameter("body", $order['order_sn']); // 商品描述
        $this->setParameter("out_trade_no", $order['order_sn'] . $order['log_id']); // 商户订单号
        $this->setParameter("total_fee", $order['order_amount'] * 100); // 总金额
        $this->setParameter("notify_url", $notify_url); // 通知地址
        $this->setParameter("trade_type", "NATIVE"); // 交易类型
        $this->setParameter("product_id", $order['order_sn']);
        $this->setParameter("attach", $order['order_sn']);


        $code_url = $this->getCodeUrl();

        $payment_path=$site_url.'includes/modules/payment/wxpaynative/';

        $javascript='<style>#paymentDiv{width:760px}#wxPhone{float:left;width:445px;height:479px;padding-left:50px;background:url('.$payment_path.'wxscan.png) 50px 0 no-repeat}#qrcode{display:block;float:left;margin-top:30px}#qrcode img{height:215px;width:215px;}.qrcode-inner{background:#00BA2A;padding:20px;}.wxscan-title{background:url('.$payment_path.'wxpay-ic.png) 50px 0 no-repeat;font-size: 24px;text-indent:50px;margin-bottom:0;padding:15px 0;color:#333;margin:10px 0}</style> ';

        if(!$code_url){
            $button = '<div id="paymentDiv"><div style="text-align:center" id="qrcode"><p class="wxscan-title">微信支付</p><div class="qrcode-inner"><img src=""></div></div><div id="wxPhone"></div></div>';
            $this->logInfo("error::get_code::code_url为空");
            return $javascript.$button;
        }

        $javascript.='<script src="'.$payment_path.'qrcode.js"></script>';

        $javascript.='<script>
        if("'.$code_url.'"!==""){
            var wording=document.createElement("p");
            wording.innerHTML = "微信扫描，立即支付";
            var code=document.createElement("DIV");
            new QRCode(code, "'.$code_url.'");
            var element=document.getElementById("qrcode");
            element.appendChild(wording);
            element.appendChild(code);
        }
        </script>';

        $button = '<div id="paymentDiv"><div style="text-align:center" id="qrcode"></div><div id="wxPhone"></div></div>';
    
        $javascript .=  '
                <script>
function getInterval() {
    Ajax.call("'.$notify_url.'?code=wxpaynative&check=true&log_id='.$order["log_id"].'&time="+new Date().getTime(), "", qrcodeResponse, "GET", "JSON");
}

setTimeout(function() {getInterval();},2000); 

function qrcodeResponse(result){
    if (result.error > 0 && result.error < 100) {
        setTimeout(function() {
            getInterval();
        },
        '.(WXPAYNATIVE_QUERY_INTERVAL*1000).');
        new Date().getTime();
    } else {
        location = "'.$notify_url.'?code=wxpaynative&check=true&redirect=true&log_id='.$order["log_id"].'";
    }
}
</script>';




        $this->logInfo("code_url:".$code_url);
        $this->logInfo("button:".$javascript.$button);
        return $button.$javascript;
    }


    public function respond() {
        $this->payment = get_payment('wxpaynative');

        if(!empty($_GET["check"])){

         
            $log_id = intval($_GET['log_id']);
            $result=$this->_checkStatus($log_id);
            if(!empty($_GET["redirect"])){
                $this->logInfo(__LINE__."==result=".json_encode($result));
                if($result["error"]>0){
                    $this->logInfo(__LINE__."=return false");
                    return false;
                }else{
                    $this->logInfo(__LINE__."=return true");
                    return true;
                }
            }else{
                die(json_encode($result));
            }
        }else{

            $xml = file_get_contents('php://input');
            $this->logInfo("respond_wxpaynative_xml:".$xml);
            $postdata=$this->xmlToArray($xml);

            $wxsign = $postdata['sign'];
            unset($postdata['sign']);
            $sign = $this->getSign($postdata);
            $this->logInfo("respond_wxpaynative_sign sign:{$sign},   wxsign:{$wxsign}, result_code:{$postdata['result_code']}, out_trade_no:{$postdata['out_trade_no']}, attach:{$postdata['attach']}");
            if ($wxsign == $sign) {
                // 交易成功
                if ($postdata['result_code'] == 'SUCCESS' && $postdata['return_code'] == 'SUCCESS')  {
                    // log_id
                    $log_id = str_replace($postdata['attach'], '', $postdata['out_trade_no']);
                    order_paid($log_id, 2);
                }

                $returndata['return_code'] = 'SUCCESS';
            } else {
                $returndata['return_code'] = 'FAIL';
                $returndata['return_msg'] = '签名失败';
            }

            $returnXML=$this->arrayToXml($returndata);
            echo $returnXML;
            exit;
        }
    }


    private function _checkStatus($log_id){
        if(!$log_id) return array("error"=>1,"message"=>"参数错误");
        $sql = "SELECT is_paid,order_type,order_id FROM ".$GLOBALS['ecs']->table('pay_log')." where log_id = '$log_id'";
        $pay_log = $GLOBALS['db']->getRow($sql);
        
        switch ($pay_log['order_type']) {
            case PAY_ORDER:
                $order_sql = "SELECT order_sn FROM " .$GLOBALS['ecs']->table('order_info'). " where order_id='".$pay_log['order_id']."'";
                $order_info = $GLOBALS['db']->getRow($order_sql);
                if(!$order_info){
                    return array("message"=>"通信出错：订单不存在","error"=>2);
                }
                $order_sn = $order_info['order_sn'];
                break;
            case PAY_SURPLUS:
                $account_sql = "SELECT id FROM ".$GLOBALS['ecs']->table('user_account')." WHERE id=".$pay_log['order_id'];
                $account_info = $GLOBALS['db']->getRow($account_sql);
                if(!$account_info){
                    return array("message"=>"通信出错：订单不存在","error"=>2);
                }
                $order_sn = $account_info['id'];
                break;
            
            default:
                return array("message"=>"通信出错：订单不存在","error"=>2);
                break;
        }
        $is_paid = $pay_log['is_paid'];
        if($is_paid>0){
            return array("message"=>"交易成功","error"=>0);
        }
      
        $outTradeNo = $order_sn.$log_id;

        $this->setParameter("out_trade_no",$outTradeNo);
        $data=$this->createXml();
        $url="https://api.mch.weixin.qq.com/pay/orderquery";
        $res=$this->postXmlCurl($data,$url);
        $result=$this->xmlToArray($res);

        $this->logInfo($data);
        $this->logInfo($result);

        if(empty($result)){
            return array("message"=>"通信出错：".$result['return_msg'],"error"=>2);
        }

        if ($result["return_code"] == "FAIL") {
            return array("message"=>"通信出错：".$result['return_msg'],"error"=>2);
        }

        if ($result['trade_state'] == 'SUCCESS') {
            // 获取log_id
            $order_sn = str_replace($result['attach'], '', $result['out_trade_no']);
            order_paid($order_sn, 2);
            $this->logInfo("交易成功");
            return array("message"=>"交易成功","error"=>0);
        }elseif($result['trade_state'] == 'NOTPAY' || $result['trade_state'] == 'USERPAYING'){
            return array("message"=>$result["trade_state_desc"],"error"=>3);
        }else{

            return array("message"=>$result["trade_state_desc"],"error"=>100);
        }

    }

    public function getCodeUrl(){
        $url = "https://api.mch.weixin.qq.com/pay/unifiedorder";

        if ($this->parameters["out_trade_no"] == null) {

            $this->logInfo("缺少统一支付接口必填参数out_trade_no");
        } elseif ($this->parameters["body"] == null) {
            $this->logInfo("缺少统一支付接口必填参数body");
        } elseif ($this->parameters["total_fee"] == null) {
            $this->logInfo("缺少统一支付接口必填参数total_fee");
        } elseif ($this->parameters["notify_url"] == null) {
            $this->logInfo("缺少统一支付接口必填参数notify_url");
        } elseif ($this->parameters["trade_type"] == null) {
            $this->logInfo("缺少统一支付接口必填参数trade_type");
        } elseif ($this->parameters["trade_type"] == "JSAPI" && $this->parameters["openid"] == NULL) {
            $this->logInfo("统一支付接口中，缺少必填参数openid！trade_type为JSAPI时，openid为必填参数！");
        }
        $this->parameters["appid"] = $this->payment['wxpaynative_appid']; // 公众账号ID
        $this->parameters["mch_id"] = $this->payment['wxpaynative_mchid']; // 商户号
        $this->parameters["spbill_create_ip"] = $_SERVER['REMOTE_ADDR']; // 终端ip
        $this->parameters["nonce_str"] = $this->createNoncestr(); // 随机字符串
        $this->parameters["sign"] = $this->getSign($this->parameters); // 签名



        $xml=$this->arrayToXml($this->parameters);
        $this->logInfo("xml::$xml");
        $response =$this->postXmlCurl($xml,$url) ;
        $result = $this->xmlToArray($response);
        $this->logInfo("result:".json_encode($result));
        $code_url = $result["code_url"];
        return $code_url;
    }



    // 产生随机字符串，不长于32位
    public function createNoncestr($length = 32){
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i ++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }

    public function setParameter($parameter, $parameterValue){
        $this->parameters[$this->trimString($parameter)] = $this->trimString($parameterValue);
    }

    public function trimString($value){
        $ret = null;
        if (null != $value)
        {
            $ret = $value;
            if (strlen($ret) == 0)
            {
                $ret = null;
            }
        }
        return $ret;
    }

    public function getSign($Obj){
        foreach ($Obj as $k => $v) {
            $Parameters[$k] = $v;
        }
        // 签名步骤一：按字典序排序参数
        ksort($Parameters);

        $buff = "";
        foreach ($Parameters as $k => $v) {
            $buff .= $k . "=" . $v . "&";
        }

        $this->logInfo("buff: {$buff} ");
        $String="";
        if (strlen($buff) > 0) {
            $String = substr($buff, 0, strlen($buff) - 1);
        }
        
        // 签名步骤二：在string后加入KEY
        $String = $String . "&key=" . $this->payment['wxpaynative_key'];
        $this->logInfo("String: {$String} ");
        // 签名步骤三：MD5加密
        $String = md5($String);
        
        // 签名步骤四：所有字符转为大写
        $result_ = strtoupper($String);

        return $result_;
    }

    // 将xml转为array
    public function xmlToArray($xml){
        //将XML转为array
        $array_data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        return $array_data;
    }

    // 将array转为xml
    public function arrayToXml($arr){
        $xml = "<xml>";
        foreach ($arr as $key=>$val)
        {
            if (is_numeric($val))
            {
                $xml.="<".$key.">".$val."</".$key.">";

            }
            else
                $xml.="<".$key."><![CDATA[".$val."]]></".$key.">";
        }
        $xml.="</xml>";
        return $xml;
    }

    // 生成xml
    public function createXml(){

        //检测必填参数
        if($this->parameters["out_trade_no"] == null &&
            $this->parameters["transaction_id"] == null){
            return false;
        }

        $this->parameters["appid"] = $this->payment["wxpaynative_appid"];//公众账号ID
        $this->parameters["mch_id"] = $this->payment["wxpaynative_mchid"];//商户号
        $this->parameters["nonce_str"] = $this->createNoncestr();//随机字符串
        $this->parameters["sign"] = $this->getSign($this->parameters);//签名
        return  $this->arrayToXml($this->parameters);

    }

    // 提交xml到对应的接口url
    public function postXmlCurl($xml,$url,$second=30)
    {
        //初始化curl
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_TIMEOUT, $second);
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,FALSE);
        //设置header
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        //要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        //post提交方式
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        //运行curl
        $data = curl_exec($ch);
        //返回结果

        if(!$data){
            $error = curl_errno($ch);
            $this->logInfo("error_no:$error error:".curl_error($ch));

        }
        curl_close($ch);
        return $data;
    }

    public function logInfo($data = ''){
        if ( @constant('DEBUG_API') ) {
            error_log(date("c")."\t".print_r($data, 1)."\t\n", 3, LOG_DIR."/wxpaynative_".date("Y-m-d",time()).".log");
        }
    }

}

