<?php
namespace app\components\message;

use Yii;
use yii\validators\EmailValidator;
use app\models\MessageLog;
/**
 * 发送消息
 * @author morven
 *
 */
abstract class SendCode {

	
	/**
	 *  发送
	 * @param string $account 账号
	 * @param string $data 发送数据
	 * @param int $type 类型0:邮件1:手机
	 */
	public function send($account,$data=null,$type=0){
		return true;
	}
	
	/**
	 *  保存数据
	 * @param string $account 账号
	 * @param string $data 发送数据
	 * @param int $state 状态0:失败1:成功
	 */
	public function save($account,$data=null,$state=1){		
		$model = new MessageLog();
		$model->account = $account;
        $type = self::checkName($account);
        if($type=='mail'){
            $model->type = 3;
        }elseif ($type=='phone'){
            $model->type = 4;
        }else{
            $model->type = 1;
        }
		$model->content = $data;		
		$model->state = $state;
		$model->inputtime =time();
		$model->save();		
		return true;
	}
	
	/**
	 * 检查账号类型
	 * @param string $account 账号
	 * @return string
	 */
	public function checkName($account) {
		$pattern = '/^[a-zA-Z0-9!#$%&\'*+\\/=?^_`{|}~-]+(?:\.[a-zA-Z0-9!#$%&\'*+\\/=?^_`{|}~-]+)*@(?:[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?$/';
		if ( preg_match($pattern, $account) ){
			$type = 'mail';
		}elseif(preg_match("/^1[34578]\d{9}$/", $account)){
			$type = 'phone';
		}else{
            $type = 'system';
        }
	
		return $type;
	}
	/**
	 * 查询消息
	 * @return boolean
	 */
	public function findAll( $condition=null ){
		$model = MessageLog::find()->where($condition)->orderBy('inputtime DESC')->all();
		return $model;
	}
	
	/**
	 * 查询单条消息
	 * @return boolean
	 */
	public function findOne($id, $condition=null ){
		return true;
	}
	
	/**
	 * 删除消息
	 * @return boolean
	 */
	public function delete( $id ,$condition=null ){
		return true;
	}
}
