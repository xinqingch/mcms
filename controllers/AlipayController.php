<?php
namespace app\controllers;
use Yii;
use yii\web\Controller;
use app\models\Helper;

class AlipayController extends Controller
{

	// 支付宝服务器异步通知页面路径
	public function actionNotify() {

		$handle = fopen(Yii::$app->basePath.'../../alipay.txt', "wb");
		$info = empty($_POST)?$_POST:$_GET;
   		fwrite($handle,"<?php \n return array(\n\t'" . implode("',\n\t'", $info) . "'\n);\n?>");
   		fclose($handle);
   		//print_r($_GET);
   		//exit;
   		
		$orderid = $_POST['out_trade_no'];//订单号
		$order_id = substr($orderid, 0, 14);
		$memacount = new MemAccount();
		$time = time();
		$n=strpos($orderid,'-');//寻找位置
		if($n)
		{
			$str=substr($orderid,$n+1);
		}
		$orders = $this->loadModel($order_id);
		$ordp = $orders['orderProduct'];//关联订单产品表
		foreach ($ordp as $val){
			$zp_id = $val->zp_id;//产品id
		}
		if($str == 1){
			$orders = Cash::model()->findByPk($order_id);
			$meminfo = Member::model()->findByPk($orders->zm_id);
		}elseif($str == 3){
			$orders = PaimaiApply::model()->findByAttributes(array('zpai_orderid'=>$order_id));
			$company = Comapny::model()->findByPk($orders->zm_id);
		}else{
			$orders = $this->loadModel($order_id);
			$ordp = $orders['orderProduct'];//关联订单产品表
			foreach ($ordp as $val){
				$zp_id = $val->zp_id;//产品id
			}
			$product = $orders->orderProduct['0']->attributes;//取订单产品
			$receivables = Receivables::model()->getReceinfo($order_id);//收款单信息（线上支付）
			$meminfo = Member::model()->findByPk($receivables->zm_id);
		}		
		//判断是否多店铺
		if( F::sitetype()==2 ){
			//实例化支付类
		$alipay = new $orders->cmppayment->class_name();
		//配置
		$alipay->pay_config = $orders->cmppayment->zpy_config;

		}else{
			//实例化支付类
		$alipay = new $orders->payment->class_name();
		//配置
		$alipay->pay_config = $orders->payment->zpy_config;

		}

		if ($alipay->verifyNotify()) {
			$order_id = $_POST['out_trade_no'];//商户订单号
			$trade_no = $_POST['trade_no'];//支付宝交易号
			$total_fee = $_POST['total_fee'];//
			//交易状态
			$trade_status = $_POST['trade_status'];
			if($orders->zo_status==3){
				echo 'success';
				exit;
			}
			if($alipay->pay_config['class_name']=='AlipayEscow'){
				if($trade_status == 'WAIT_SELLER_SEND_GOODS') {
					//该判断表示买家已在支付宝交易管理中产生了交易记录且付款成功，但卖家没有发货
					//更新收款单状态并保存交易号
					$receivables->zre_tradenum = $trade_no;
					$receivables->zre_status = 2;
					$receivables->save();
					//减去支付余额
					$receivables1 = Receivables::model()->getReceinfof($order_id);
					if($receivables1){
					foreach ($receivables1 as $val){
						if($val->zpy_id == 0){
							$meminfo->zm_balance = 0;//剩余余额
						}elseif ($val->zpy_id == -1){
							$meminfo->zm_card_balance = 0;//剩余购物卡余额
						}
					}
					$meminfo->save();
					}
					
					$this->updateOrderStatusOne($order_id,$trade_no,2,NULL,NULL,$total_fee);
					OrdMsg::model()->setOrdMsg($product['zm_id'],$order_id,2);
					echo 'success';
				}else if($trade_status == 'WAIT_BUYER_CONFIRM_GOODS') {

					//该判断表示卖家已经发了货，但买家还没有做确认收货的操作
					$orders->UpOrderStatus($order_id,4);
					OrdMsg::model()->setOrdMsg($product['zm_id'],$order_id,3);
					dump($alipay);exit;
				}else if($trade_status == 'TRADE_FINISHED') {
					//该判断表示买家已经确认收货，这笔交易完成
					$orders->UpOrderStatus($order_id,5);
					OrdMsg::model()->setOrdMsg($product['zm_id'],$order_id,4);
					echo 'success';
				}else {
					$this->updateOrderStatusOne($order_id,$trade_no,2,NULL,NULL,$total_fee);
					OrdMsg::model()->setOrdMsg($product['zm_id'],$order_id,2);
					echo 'success';
				}
			}else{
				if($trade_status == 'TRADE_FINISHED' || $trade_status == 'TRADE_SUCCESS'|| $trade_status == 'WAIT_SELLER_SEND_GOODS') {	//判断即时到帐
					//该判断表示买家已在支付宝交易管理中产生了交易记录且付款成功
					if($str==1){
						$orders->zch_back_no = $trade_no;
						$orders->zch_status = 4;
						$orders->save();
						//dump($meminfo->zm_balance);exit;
						$meminfo->zm_balance = $meminfo->zm_balance + $total_fee;
						$meminfo->save();
					
						$memacount->zm_id = $orders->zm_id;
						$memacount->zm_type = 1;
						$memacount->zmc_type = 1;
						$memacount->zmc_event = 2;
						$memacount->zmc_orderid = $order_id;
						$memacount->zmc_amount = $total_fee;
						$memacount->zmc_amount_log = $meminfo->zm_balance;
						$memacount->zmc_note = '充值';
						$memacount->inputtime = $time;
					
						$memacount->save();
					
						header301('/member/balance/rechlist');
					}elseif($str==3){//拍卖保证金
						
						$paimaiprice = $orders->zpai_deposti+$orders->zpai_paimai_ser;
						if($total_fee!=$paimaiprice){
							echo "fail";
            				exit();
						}
						$orders->zpai_trade_no = $trade_no;
						$orders->zpai_deposit_status = 2;
						$orders->zpai_deposit_time = $time;
						$orders->save();
						//dump($meminfo->zm_balance);exit;
						$company->zc_paimai = $orders->zpai_deposti;
						$company->zc_paimai_ser = $orders->zpai_paimai_ser;
						$company->save();
					
						$memacount->zm_id = $orders->zm_id;
						$memacount->zm_type = 1;
						$memacount->zmc_type = 1;
						$memacount->zmc_event = 2;
						$memacount->zmc_orderid = $order_id;
						$memacount->zmc_amount = $total_fee;
						$memacount->zmc_amount_log = $company->zc_paimai;
						$memacount->zmc_note = '拍卖保证金';
						$memacount->inputtime = $time;
					
						$memacount->save();
					
						header301('/company/applypaimai/');
					}else{
					//更新收款单状态并保存交易号
					$receivables->zre_tradenum = $trade_no;
					$receivables->zre_status = 2;
					$receivables->save();
					//减去支付余额
					$receivables1 = Receivables::model()->getReceinfof($order_id);
					if($receivables1){
					foreach ($receivables1 as $val){
						if($val->zpy_id == 0){
							$meminfo->zm_balance = 0;//剩余余额
						}elseif ($val->zpy_id == -1){
							$this->saveCardInfoToOrdd($order_id, $zp_id, $meminfo->zm_card_balance);
							$meminfo->zm_card_balance = 0;//剩余购物卡余额
							
						}
					}
					$meminfo->save();
					}
					
					$this->updateOrderStatusOne($order_id,$trade_no,2,NULL,NULL,$total_fee);
					OrdMsg::model()->setOrdMsg($product['zm_id'],$order_id,2);
					echo 'success';
					}
				}else {
					$this->updateOrderStatusOne($order_id,$trade_no,2,NULL,NULL,$total_fee);
					OrdMsg::model()->setOrdMsg($product['zm_id'],$order_id,2);
					echo 'success';
				}
			}
		} else {
			echo "fail";
            exit();
		}
	}

	//支付宝页面跳转同步通知页面路径
	public function actionReturn() {
		$orderid = $_GET['out_trade_no'];//订单号
		$order_id = substr($orderid, 0, 14);
		$memacount = new MemAccount();
		$n=strpos($orderid,'-');//寻找位置
		$time = time();
		if($n)
		{
			$str=substr($orderid,$n+1);
		}

		if($str == 1){
			$orders = Cash::model()->findByPk($order_id);
			//$meminfo = Member::model()->findByPk($orders->zm_id);
		}elseif($str == 3){
			$orders = PaimaiApply::model()->findByAttributes(array('zpai_orderid'=>$orderid));			
			$company = Company::model()->findByPk($orders->zm_id);			
		}else{
			$orders = $this->loadModel($order_id);
			$ordp = $orders['orderProduct'];//关联订单产品表
			foreach ($ordp as $val){
				$zp_id = $val->zp_id;//产品id
			}
			$product = $orders->orderProduct['0']->attributes;//取订单产品
			$receivables = Receivables::model()->getReceinfo($order_id);//收款单信息（线上支付）
			$meminfo = Member::model()->findByPk($receivables->zm_id);		
		}

		//判断是否多店铺
		if( F::sitetype()==2 ){
			//实例化支付类
		$alipay = new $orders->cmppayment->class_name();
		//配置
		$alipay->pay_config = $orders->cmppayment->zpy_config;

		}else{
			//实例化支付类
		$alipay = new $orders->payment->class_name();
		//配置
		$alipay->pay_config = $orders->payment->zpy_config;

		}

		if ($alipay->verifyReturn()) {			
			$trade_no = $_GET['trade_no'];//交易号
			$total_fee = $_GET['total_fee'];//返回金额
			$trade_status = $_GET['trade_status'];//返回状态
			//担保支付接口
			if($str==1){

			}elseif($str==3){

			}else{
				$orders->zo_trade_no = $trade_no;
				$orders->save();
			}
			if($alipay->pay_config['class_name']=='AlipayEscow'){//担保支付
				if($trade_status == 'WAIT_SELLER_SEND_GOODS') {
					//更新收款单状态并保存交易号
					$receivables->zre_tradenum = $trade_no;
					$receivables->zre_status = 2;
					$receivables->save();
					//减去支付余额
					$receivables1 = Receivables::model()->getReceinfof($order_id);
					if($receivables1){
					foreach ($receivables1 as $val){
						if($val->zpy_id == 0){
							$meminfo->zm_balance = 0;//剩余余额
						}elseif ($val->zpy_id == -1){
							$meminfo->zm_card_balance = 0;//剩余购物卡余额
						}
					}
					$meminfo->save();
					}
					
					$this->updateOrderStatusOne($order_id,$trade_no,2,NULL,NULL,$total_fee);
					OrdMsg::model()->setOrdMsg($product['zm_id'],$order_id,2);
					header301('/member/index/orders/vieworder/orderid/'.$order_id);
				}else if($trade_status == 'WAIT_BUYER_CONFIRM_GOODS') {
					//该判断表示卖家已经发了货，但买家还没有做确认收货的操作
					$orders->UpOrderStatus($order_id,4);
					OrdMsg::model()->setOrdMsg($product['zm_id'],$order_id,3);
					header301('/member/index/orders/vieworder/orderid/'.$order_id);
				}else if($trade_status == 'TRADE_FINISHED') {
					//该判断表示买家已经确认收货，这笔交易完成
					$orders->UpOrderStatus($order_id,5);
					OrdMsg::model()->setOrdMsg($product['zm_id'],$order_id,4);
					header301('/member/index/orders/vieworder/orderid/'.$order_id);
					echo 'success';
				}else {
					$this->updateOrderStatusOne($order_id,$trade_no,2,NULL,NULL,$total_fee);
					OrdMsg::model()->setOrdMsg($product['zm_id'],$order_id,2);
					header301('/member/index/orders/vieworder/orderid/'.$order_id);
				}
			}else{
				if($_GET['trade_status'] == 'TRADE_FINISHED' || $_GET['trade_status'] == 'TRADE_SUCCESS') {
					if($str==1){
						$orders->zch_back_no = $trade_no;
						$orders->zch_status = 4;
						$orders->save();
						
						$meminfo1 = Member::model()->findByPk($orders->zm_id);						
						$meminfo1->zm_balance = $meminfo1->zm_balance + $total_fee;
						$meminfo1->save(false);
						$memacount->zm_id = $orders->zm_id;
						$memacount->zm_type = 1;
						$memacount->zmc_type = 1;
						$memacount->zmc_event = 2;
						$memacount->zmc_orderid = $order_id;
						$memacount->zmc_amount = $total_fee;
						$memacount->zmc_amount_log = $meminfo1->zm_balance;
						$memacount->zmc_note = '充值';
						$memacount->inputtime = time();
						
						$memacount->save();
						
						header301(url('/member/balance/rechlist'));
						exit;
					}elseif($str==3){//拍卖保证金
						
						$paimaiprice = $orders->zpai_deposti+$orders->zpai_paimai_ser;
						if($total_fee!=$paimaiprice){
							Message('交易失败！您交易的金额与订单金额匹配!');
            				exit();
						}
						$orders->zpai_trade_no = $trade_no;
						$orders->zpai_deposit_status = 2;
						$orders->zpai_deposit_time = $time;
						$orders->save();
						//dump($meminfo->zm_balance);exit;
						$company->zc_paimai = $orders->zpai_deposti;
						$company->zc_paimai_ser = $orders->zpai_paimai_ser;
						$company->save();
					
						$memacount->zm_id = $orders->zm_id;
						$memacount->zm_type = 1;
						$memacount->zmc_type = 1;
						$memacount->zmc_event = 2;
						$memacount->zmc_orderid = $orderid;
						$memacount->zmc_amount = $total_fee;
						$memacount->zmc_amount_log = $company->zc_paimai;
						$memacount->zmc_note = '拍卖保证金';
						$memacount->inputtime = $time;
					
						$memacount->save();
					
						header301(url('/company/applypaimai/index'));
					}else{
						//更新收款单状态并保存交易号
						$receivables->zre_tradenum = $trade_no;
						$receivables->zre_status = 2;
						$receivables->save();			
						//减去支付余额
						$receivables1 = Receivables::model()->getReceinfof($order_id);
						if($receivables1){
						foreach ($receivables1 as $val){
							if($val->zpy_id == 0){
								$meminfo->zm_balance = 0;//剩余余额
							}elseif ($val->zpy_id == -1){
								$this->saveCardInfoToOrdd($order_id, $zp_id, $meminfo->zm_card_balance);							
								$meminfo->zm_card_balance = 0;//剩余购物卡余额
								
							}
						}
						if($orders->zo_type==6){
							$zpn_point = Product::model()->findByPk($zp_id)->propoint[0]->zpn_point;
							$meminfo->zm_value = $meminfo->zm_value - $zpn_point;
						}
						$meminfo->save();
						}		
						
						$this->updateOrderStatusOne($order_id,$trade_no,2,NULL,NULL,$total_fee);
						OrdMsg::model()->setOrdMsg($product['zm_id'],$order_id,2);
						header301('/member/index/orders/vieworder/orderid/'.$order_id);
					}
				}
				else {
					$this->updateOrderStatusOne($order_id,$trade_no,2,NULL,NULL,$total_fee);
					OrdMsg::model()->setOrdMsg($product['zm_id'],$order_id,2);
					header301('/member/index/orders/vieworder/orderid/'.$order_id);
				}
			}
		} else {
			//echo "fail";
			throw new CHttpException(404,'交易失败！请联系客服');
            exit();
		}
	}

	///////////页面功能说明///////////////
	// 支付宝无线快捷支付异步通知接口
	// 创建该页面文件时，请留心该页面文件中无任何HTML代码和空格
	// 该页面不能在本机电脑测试，请到服务器上做测试。请确保外部可以访问该页面
	// TRADE_FINISHED(表示交易已经成功结束)
	/////////////////////////////////////
	public function actionApkNotify(){
		//获取notify_data
		//不需要解密，是明文的格式
		$notify_data = "notify_data=" . $_POST["notify_data"];
	//	$notify_data = 'notify_data=<notify><partner>2088901555002542</partner><discount>0.00</discount><payment_type>1</payment_type><subject>指易达商城购物支付款</subject><trade_no>2013081729489980</trade_no><buyer_email>zhangmenglin5@tom.com</buyer_email><gmt_create>2013-08-17 16:09:43</gmt_create><quantity>1</quantity><out_trade_no>20130817088579</out_trade_no><seller_id>2088901555002542</seller_id><trade_status>TRADE_FINISHED</trade_status><is_total_fee_adjust>N</is_total_fee_adjust><total_fee>0.01</total_fee><gmt_payment>2013-08-17 16:09:44</gmt_payment><seller_email>service@zeeeda.com</seller_email><gmt_close>2013-08-17 16:09:44</gmt_close><price>0.01</price><buyer_id>2088102015378801</buyer_id><use_coupon>N</use_coupon></notify>';
	
		//获取sign签名
		$sign = $_POST["sign"];
	//	$sign = 'NSPDgljMcRZBRMadEv8DcbmynZh6yoXHt/BQ7zrWWa7hKjxmwwLggpJXuRZgO00CL/Z00zgUAegzqgvfXrDYahUwotzuefCLc3BbpXOQuYRcCUELYyt3o8tJUC830XDy+Mo9fhxE/BjKvIcRsaqDn0L3QzxBAedqyLz5YoMCUGk=';
		echo '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">';
		
		//实例化接口类
		$apkPay = new AlipayApk();

		//验证签名
		$isVerify = $apkPay->verify($notify_data, $sign);
	
		//如果验签没有通过,验证解密不通过，暂不执行
		if(!$isVerify){
			echo "fail";
			return;
		}
		else{echo "true";}

		//获取交易状态
		$trade_status = $apkPay->getDataForXML($_POST["notify_data"] , '/notify/trade_status');
	
		//判断交易是否完成
		if($trade_status == "TRADE_FINISHED"){
			echo "success";
			//取订单号
			$order_id = $apkPay->getDataForXML($_POST["notify_data"] , '/notify/out_trade_no');

			//支付宝交易号
			$trade_no = $apkPay->getDataForXML($_POST["notify_data"] , '/notify/trade_no');
//			echo $order_id."<br>".$trade_no;exit;
			//在此处添加您的业务逻辑，作为收到支付宝交易完成的依据
			$this->updateOrderStatus($order_id,$trade_no,2);
		}
		else{
			echo "fail";
		}
	}

	/*
     * 财付通异步通知     
     */
	public function actionpayNotify() 
	{
		$order_id = Yii::app()->request->getParam('out_trade_no');//订单号
		$orders = $this->loadModel($order_id);
		$product = $orders->orderProduct['0']->attributes;//取订单产品
		//判断是否多店铺
		if( F::sitetype()==2 ){				
		//配置
		$pay_config = $orders->cmppayment->zpy_config;

		}else{
		
		//配置
		$pay_config = $orders->payment->zpy_config;

		}
		
		if($pay_config['class_name']!='TenpayEscow'){
			echo "fail";
		}
		//dump($pay_config['zpy_payment_id']);exit;

	/* 创建支付应答对象 */
		$resHandler = new ResponseHandler();
		$resHandler->setKey($pay_config['zpy_payment_key']);

	//判断签名
		if($resHandler->isTenpaySign()) {
			
	//通知id
		$notify_id = $resHandler->getParameter("notify_id");
	
	//通过通知ID查询，确保通知来至财付通
	//创建查询请求
		$queryReq = new RequestHandler();
		$queryReq->init();
		$queryReq->setKey($pay_config['zpy_payment_key']);
		$queryReq->setGateUrl("https://gw.tenpay.com/gateway/simpleverifynotifyid.xml");
		$queryReq->setParameter("partner", $pay_config['zpy_payment_id']);
		$queryReq->setParameter("notify_id", $notify_id);
		
	//通信对象
		$httpClient = new TenpayHttpClient();
		$httpClient->setTimeOut(5);
	//设置请求内容
		$httpClient->setReqContent($queryReq->getRequestURL());
	
	//后台调用
		if($httpClient->call()) {
	//设置结果参数
			$queryRes = new ClientResponseHandler();
			$queryRes->setContent($httpClient->getResContent());
			$queryRes->setKey($pay_config['zpy_payment_key']);
		
		if($resHandler->getParameter("trade_mode") == "1"){

	//判断签名及结果（即时到帐）
	//只有签名正确,retcode为0，trade_state为0才是支付成功
		if($queryRes->isTenpaySign() && $queryRes->getParameter("retcode") == "0" && $resHandler->getParameter("trade_state") == "0") {
				log_result("即时到帐验签ID成功");
	//取结果参数做业务处理
				$out_trade_no = $resHandler->getParameter("out_trade_no");
	//财付通订单号
				$transaction_id = $resHandler->getParameter("transaction_id");
	//金额,以分为单位
				$total_fee = $resHandler->getParameter("total_fee");
	//订单号
				$trade_no = $resHandler->getParameter('trade_no');//交易号
	//如果有使用折扣券，discount有值，total_fee+discount=原请求的total_fee
				$discount = $resHandler->getParameter("discount");
				
				//------------------------------
				//处理业务开始
				//------------------------------
				
				//处理数据库逻辑
				//注意交易单不要重复处理
				//注意判断返回金额
				if( $total_fee == $orders->zo_amount*100){	//判断订单金额是否相等			
					$orders->zo_trade_no = $transaction_id;//写入财付通订单号
					$orders->save();

					$this->updateOrderStatus($order_id,$trade_no,2);
					OrdMsg::model()->setOrdMsg($product['zm_id'],$order_id,2);
					echo 'success';
					exit;
				}else{
					echo "fail";
					exit;
				}
				//------------------------------
				//处理业务完毕
				//------------------------------
				log_result("即时到帐后台回调成功");
				echo "success";
				
			} else {
	//错误时，返回结果可能没有签名，写日志trade_state、retcode、retmsg看失败详情。
	//echo "验证签名失败 或 业务错误信息:trade_state=" . $resHandler->getParameter("trade_state") . ",retcode=" . $queryRes->                         getParameter("retcode"). ",retmsg=" . $queryRes->getParameter("retmsg") . "<br/>" ;
			   log_result("即时到帐后台回调失败");
			   echo "fail";
			}
		}elseif ($resHandler->getParameter("trade_mode") == "2")
		
	    {
    //判断签名及结果（中介担保）
	//只有签名正确,retcode为0，trade_state为0才是支付成功
		if($queryRes->isTenpaySign() && $queryRes->getParameter("retcode") == "0" ) 
		{
				log_result("中介担保验签ID成功");
	//取结果参数做业务处理
				$out_trade_no = $resHandler->getParameter("out_trade_no");
	//财付通订单号
				$transaction_id = $resHandler->getParameter("transaction_id");

				//金额,以分为单位
				$total_fee = $resHandler->getParameter("total_fee");
				//------------------------------
				//处理业务开始
				//------------------------------
				$orders->zo_trade_no = $transaction_id;//写入财付通订单号
				$orders->save();
				if( $total_fee != $orders->zo_amount*100){	//判断订单金额是否相等						
					echo "fail";					
					exit;
				}
				//处理数据库逻辑
				//注意交易单不要重复处理
				//注意判断返回金额
	
			log_result("中介担保后台回调，trade_state=".$resHandler->getParameter("trade_state"));
				switch ($resHandler->getParameter("trade_state")) {
						case "0":	//付款成功							
						//该判断表示买家已在支付宝交易管理中产生了交易记录且付款成功，但卖家没有发货
						$this->updateOrderStatus($order_id,$trade_no,2);
						OrdMsg::model()->setOrdMsg($product['zm_id'],$order_id,2);					
							break;
						case "1":	//交易创建						

							break;
						case "2":	//收获地址填写完毕
						
							break;
						case "4":	//卖家发货成功
							//该判断表示卖家已经发了货，但买家还没有做确认收货的操作
							$orders->UpOrderStatus($order_id,4);
							OrdMsg::model()->setOrdMsg($product['zm_id'],$order_id,3);
							break;
						case "5":	//买家收货确认，交易成功
							//该判断表示买家已经确认收货，这笔交易完成
							$orders->UpOrderStatus($order_id,5);
							OrdMsg::model()->setOrdMsg($product['zm_id'],$order_id,4);							
							break;
						case "6":	//交易关闭，未完成超时关闭
							
							break;
						case "7":	//修改交易价格成功
						
							break;
						case "8":	//买家发起退款
						
							break;
						case "9":	//退款成功
						
							break;
						case "10":	//退款关闭			
							
							break;
						default:
							//nothing to do
							break;
					}
					
				
				//------------------------------
				//处理业务完毕
				//------------------------------
				echo "success";
			} else
			
		     {
	//错误时，返回结果可能没有签名，写日志trade_state、retcode、retmsg看失败详情。
	//echo "验证签名失败 或 业务错误信息:trade_state=" . $resHandler->getParameter("trade_state") . ",retcode=" . $queryRes->             										       getParameter("retcode"). ",retmsg=" . $queryRes->getParameter("retmsg") . "<br/>" ;
			   log_result("中介担保后台回调失败");
				echo "fail";
			 }
		  }
		
		
		
	//获取查询的debug信息,建议把请求、应答内容、debug信息，通信返回码写入日志，方便定位问题
	/*
		echo "<br>------------------------------------------------------<br>";
		echo "http res:" . $httpClient->getResponseCode() . "," . $httpClient->getErrInfo() . "<br>";
		echo "query req:" . htmlentities($queryReq->getRequestURL(), ENT_NOQUOTES, "GB2312") . "<br><br>";
		echo "query res:" . htmlentities($queryRes->getContent(), ENT_NOQUOTES, "GB2312") . "<br><br>";
		echo "query reqdebug:" . $queryReq->getDebugInfo() . "<br><br>" ;
		echo "query resdebug:" . $queryRes->getDebugInfo() . "<br><br>";
		*/
	}else
	 {
	//通信失败
		echo "fail";
	//后台调用通信失败,写日志，方便定位问题
	echo "<br>call err:" . $httpClient->getResponseCode() ."," . $httpClient->getErrInfo() . "<br>";
	 } 
	
	
   } else 
     {
    echo "<br/>" . "认证签名失败" . "<br/>";
    echo $resHandler->getDebugInfo() . "<br>";
	}

	}

	/*
     * 财付通同步通知     
     */
	public function actionpayReturn() 
	{
		
		$order_id = $_GET['out_trade_no'];//订单号

		$orders = $this->loadModel($order_id);

		$product = $orders->orderProduct['0']->attributes;//取订单产品
		
		//判断是否多店铺
		if( F::sitetype()==2 ){
			//实例化支付类
			$alipay = new $orders->cmppayment->class_name();
			//配置
			$alipay->pay_config = $orders->cmppayment->zpy_config;

		}else{
			//实例化支付类
			$alipay = new $orders->payment->class_name();
			//配置
			$alipay->pay_config = $orders->payment->zpy_config;

		}
		
		//判断签名
		if($alipay->verifyReturn()->isTenpaySign()) {
			
			//通知id
			$notify_id = $alipay->verifyReturn()->getParameter("notify_id");
			//商户订单号
			$out_trade_no = $alipay->verifyReturn()->getParameter("out_trade_no");
			//财付通订单号
			$transaction_id = $alipay->verifyReturn()->getParameter("transaction_id");
			//金额,以分为单位
			$total_fee = $alipay->verifyReturn()->getParameter("total_fee");
			//订单号
			$trade_no = $resHandler->getParameter('trade_no');//交易号
			//如果有使用折扣券，discount有值，total_fee+discount=原请求的total_fee
			$discount = $alipay->verifyReturn()->getParameter("discount");
			//支付结果
			$trade_state = $alipay->verifyReturn()->getParameter("trade_state");
			//交易模式,1即时到账
			$trade_mode = $alipay->verifyReturn()->getParameter("trade_mode");
						
			if("1" == $trade_mode ) {//即时支付
				if( "0" == $trade_state){
					if( $total_fee == $orders->zo_amount*100){	//判断订单金额是否相等			
						$orders->zo_trade_no = $transaction_id;//写入财付通订单号
						$orders->save();

						$this->updateOrderStatus($order_id,$trade_no,2);
						OrdMsg::model()->setOrdMsg($product['zm_id'],$order_id,2);
						header301( url('/member/index/orders/vieworder/',array('orderid'=>$out_trade_no)) );						
					}else{
						Message('交易金额与订单金额不相同！交易失败');
						exit;
					} 
				} else {
					//当做不成功处理
					Message('交易失败！');
            		exit();
				}
			}elseif( "2" == $trade_mode  ) {//担保支付
				if( "0" == $trade_state) {		
					if( $total_fee == $orders->zo_amount*100){	//判断订单金额是否相等	
						$this->updateOrderStatus($out_trade_no,$transaction_id,2);
						OrdMsg::model()->setOrdMsg($product['zm_id'],$out_trade_no,2);
						header301( url('/member/index/orders/vieworder/',array('orderid'=>$out_trade_no)) );					
					}else{
						Message('交易金额与订单金额不相同！交易失败');
						exit;
					} 
				} else {
					//当做不成功处理
					Message('交易失败！');
            		exit();
				}
			}
			
		} else {
			Message('认证签名失败！');
            exit();			
		}
	}

	/*
     * 更新订单支付状态
     * @param $order_id 订单ID
     * @param $payid 支付方式
     * @param $paystatus 支付状态
     * @param $amount 支付金额
     */
    public function updateOrderStatus($orderid,$trade_no,$paystatus=null,$status=null,$expstatus=null)
    {
    	$model=$this->loadModel($orderid);
    	// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		$order['zo_id'] = $orderid ;
		if($paystatus!=null){
		$order['zo_pay_status'] = $paystatus;
		$order['zo_trade_no'] = $trade_no;
		$order['zo_pay_time'] = time();
		}
		if($status!=null){
		$order['zo_status'] = $status;
		}
		if($expstatus!=null){
		$order['zo_exp_status'] = $expstatus;
		}

		//添加收支明细
		$account = new  MemAccount();
		$account->zm_id = $model->zm_id_cmp;//会员ID
		$account->zmc_type = 1;//类型:1增加2.减少
		$account->zmc_event = 1;//'操作类型:1订单2充值3提现4现金券5退款
		$account->zmc_orderid = $orderid;//订单ID/流水号
		$account->zmc_amount = $model->zo_amount;//金额
		$account->zmc_note = "";//备注
		$account->save();

		if(isset($order))
		{
			$model->attributes = $order;
			if($model->save())
				return true;
		}
    }

    /*
     * 更新订单支付状态
    * @param $order_id 订单ID
    * @param $payid 支付方式
    * @param $paystatus 支付状态
    * @param $amount 支付金额
    */
    public function updateOrderStatusOne($orderid,$trade_no,$paystatus=null,$status=null,$expstatus=null,$amount)
    {
    	$model=$this->loadModel($orderid);
    	// Uncomment the following line if AJAX validation is needed
    	// $this->performAjaxValidation($model);
    	$order['zo_id'] = $orderid ;
    	if($paystatus!=null){
    		$order['zo_pay_status'] = $paystatus;
    		$order['zo_trade_no'] = $trade_no;
    		$order['zo_pay_time'] = time();
    	}
    	if($status!=null){
    		$order['zo_status'] = $status;
    	}
    	if($expstatus!=null){
    		$order['zo_exp_status'] = $expstatus;
    	}
    
    	//添加收支明细
    	$account = new  MemAccount();
    	$account->zm_id = $model->zm_id_cmp;//会员ID
    	$account->zmc_type = 1;//类型:1增加2.减少
    	$account->zmc_event = 1;//'操作类型:1订单2充值3提现4现金券5退款
    	$account->zmc_orderid = $orderid;//订单ID/流水号
    	$account->zmc_amount = $amount;//金额
    	$account->zmc_note = "";//备注
    	$account->save();
    
    	if(isset($order))
    	{
    		$model->attributes = $order;
    		if($model->save())
    			return true;
    	}
    }
    
    /**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Order::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'订单不存在!');
		return $model;
	}
	
	/**
	 * 购物卡消费保存在优惠表中
	 * @param $zo_id	订单id
	 * @param $zp_id 	产品id
	 * @param $zod_price 购物卡消费金额
	 * @param $zop_id 产品id
	 */
	public function saveCardInfoToOrdd($zo_id,$zp_id,$zod_price)
	{
		$orddis = new OrdDiscount();
	
		$orddis->zo_id = $zo_id;
		$orddis->zp_id = $zp_id;
		$orddis->zod_price = $zod_price;
		$orddis->zod_type = 7;
		$orddis->zop_id = $zp_id;
	
		if($orddis->save()){
			return true;
		}
	}
	
}