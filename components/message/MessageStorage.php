<?php
namespace app\components\message;

use Yii;
use yii\web\HttpException;
/**
 * 发送验证码
 * @author morven
 *
 */
class MessageStorage {

	public $title ;

	public $body ;
	
	public $type = 'phone';

	private $instance;

	public function __construct($body,$title=null) {
			$this->title = $title;
			$this->body = $body;
	}
	/**
	 * 创建实例类
	 * @param string $type 调用实例类型
	 * @throws CHttpException
	 */
	public function create() {
		$className = 'app\\components\\message\\'.ucfirst($this->type) . 'Code';
		if( class_exists($className,true) ) {
			$f = new \ReflectionClass( $className );
			$this->instance = $f->newInstance();
			return;
		}		
		throw new HttpException(500,'No Class Instance');
	}

	/**
	 * 发送信息
	 * @param string $account 账号
	 * @return true/false
	 *
	 */
	public function send($account){
		$data = array();
		$data['title'] = $this->title;
		$data['body']  = $this->body;		
		$this->create();
		$result = $this->instance->send($account,$data);
		return $result;
	}

	
	
	/**
	 * 查询消息
	 * @param string $condition　条件
	 * @return unknown
	 */
	public function findAll( $condition=null ){
		$this->create();
		$result = $this->instance->findAll($condition);
		return $result;
	}
	
	
	/**
	 * 查询一条消息
	 * @param int $id 消息ID
	 * @param string $condition　条件
	 * @return unknown
	 */
	public function findOne( $id ,$condition=null ){
		$this->create();
		$result = $this->instance->findOne( $id , $condition );
		return $result;
	}
	
	/**
	 * 删除消息
	 * @param int/array $id 消息ID
	 * @param string $condition　条件
	 * @return unknown
	 */
	public function delete( $id ,$condition=null ){
		$this->create();
		$result = $this->instance->delete( $id , $condition );
		return $result;
	}
	
	/**
	 * 发送模板
	 * @param unknown $type
	 * @param unknown $data
	 */
	public function sendTemplate($type,$data){
		$str = '';
		switch( $type ){
				case 'reg'://注册信息内容
					$str = '您好!您的注册验证码为:'.$data['captcha'].',打死都不要告诉别人哦.';
					break;
				case 'forget'://忘记密码内容
					$str = '您好!您的找回密码验证码为:'.$data['captcha'].',打死都不要告诉别人哦.';;
					break;
				default:
					$str = '您好!您的验证码为:'.$data['captcha'].',打死都不要告诉别人哦.';;
					break;
		}
		return $str;
	}

}
