<?php
namespace app\components\message;

use Yii;
/**
 * 发送邮件验证码
 * @author morven
 * @package SendCode
 */
class MailCode extends SendCode {

	
	
	/**
	 *  发送
	 * @param string $account 账号
	 * @param array $data 发送数据
	 * @param int $type 类型0:邮件1:手机
	 */
	public function send($account,$data=null,$state=1){		
		//发送邮件
		$return = $this->mail($account, $data);
		//保存数据
		if(is_array($data)){
			$str = $data['body'];
		}else{
			$str = $data;
		}
		$this->save( $account, $str,$state );			
		return 	$return;
	}
	
	/**
	 * @param $email 接收邮件
	 * @param $data 发送数据
	 */
	public function mail($email,$data){
		//发送激活邮件....
		//$mailer = Yii::$app->mailer;
        $mail= Yii::$app->mailer->compose();
        $mail->setTo($email);
        $mail->setSubject($data['title']);
        $mail->setHtmlBody($data['body']);    //发布可以带html标签的文本
		if($mail->Send()){
			return true;
		}else{
			
			return false;
		}
	
	}
}
