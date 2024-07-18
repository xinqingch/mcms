<?php
namespace app\components\message;

use Yii;
/**
 * 发送系统消息
 * @author morven
 * @package SendCode
 */
class SysmsgCode extends SendCode {

	
	
	/**
	 *  发送
	 * @param string $account 账号
	 * @param array $data 发送数据
	 * @param int $type 类型0:邮件1:手机3:系统消息
	 */
	public function send($account,$data=null,$state=1){		
		//发送邮件		
		$return = $this->systemMsg($account, $data);
		//保存数据
		$this->save($account, $data, $state );			
		return 	$return;
	}
	
	/**
	 * 写入系统消息
	 * @param $account 接收账号
	 * @param $data 发送数据
	 */
	public function systemMsg($account,$data){		
		$model = new Message();
		$model->memberId = $account;
		$model->title = $data['title'];
		$model->content = $data['body'];
		$model->state = 1;//状态:0::未查看1:已查看2:删除
		$model->inputtime = time();
		if($model->save()){
			return true;
		}else{
			return false;
		}
	
	}
	
	/**
	 * 查询系统消息
	 * @see SendCode::findAll()
	 */
	public function findAll( $condition =null ){
		$model = Message::model()->findAll($condition);
		return $model;
	}
	
	public function  findOne($id,$condition=null){
		$model = Message::model()->findByPk($id,$condition);
		return $model;
		
	}
	
	public function delete($id,$condition=null){
		$criteria=new CDbCriteria;
		$criteria->compare('memberId',Yii::app()->user->id);
		$criteria->compare('messageId',$id);
		if($condition){
		$criteria->addCondition($condition); 
		}
		$model = Message::model()->deleteAll($criteria);
		return $model;
	
	}
}
