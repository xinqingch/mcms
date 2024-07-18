<?php
namespace app\components\point;
use app\models\Helper;
use app\models\MemberPointLog;
use app\models\User;
use Yii;

abstract class Point {
	
	//积分比例 1:100
	public $proportion = 100;
	
	/**
	 * 添加/减少积分记录
	 * @param integer $zm_id 会员ID
	 * @param integer $zpl_type 类型:1增加2减少'
	 * @param integer $zpl_action 操作类型0后台,1订单,2评论3.验证,4联盟,5注册推荐6关注7分享
	 * @param integer $zpl_points 积分
	 * @param string $zo_id 订单号
     * @param string $note 备注
	 * @throws CException
	 * @return PointLog
	 */
	public function create( $zm_id,$zpl_type=1,$zpl_action=1,$zpl_points=0,$zo_id=null,$note=null){
        $member = User::find()->where(['memberid'=>$zm_id],)->one();

		$attributes['memberId'] = $zm_id;
		$attributes['type'] = $zpl_type;
		$attributes['action'] = $zpl_action;
        $attributes['total'] = $member->points;
		$attributes['score'] = $zpl_points;
		$attributes['note'] = $zo_id.$note;
		$attributes['zpl_ip'] = Helper::GetIP();
		$attributes['inputtime'] = time();
		
		$model = new MemberPointLog();
		$transaction= Yii::$app->db->beginTransaction();
		try
		{
			//写入订单数据
			$model->attributes = $attributes;
			if($model->validate() && $model->save()){
				if($zpl_type==1){
					$member->points = $member->points + $zpl_points;
					$member->update();
				}else{
                    $member->points = $member->points - $zpl_points;
                    $member->update();
                }
			}
			else{
				$error = $model->getErrors();
				$error = array_shift( $error  );
				throw new CException($error[0]);
			}			
			$transaction->commit();
			return $model;
		}
		catch(CException $e)
		{
			$transaction->rollBack();
			return $e->getMessage();
		}
		return $model;
	}
	
	
	/**
	 * 查询指定条件信息
	 * @param string $attributes 查询条件
	 * @return unknown|boolean
	 */
	public function findAll( $attributes='' ){
		$model = MemberPointLog::model()->where($attributes)->all();
		if($model){
			return $model;
		}else{
			return false;
		}
	}
	
	public function search( $condition = array() , $pageSize=10 ) {
		$criteria=new CDbCriteria;
		if(!empty($condition)){
			foreach ($condition as $key=>$val){
				switch( $key ){
					case 'createTime1':
						$criteria->addCondition('t.inputtime > \''.$val.'\'');
						break;
					case 'createTime2':
						$criteria->addCondition('t.inputtime < \''.$val.'\'');
						break;
					default:
						$criteria->compare('t.'.$key,$val);
						break;
				}
	
			}
		}
	
		$criteria->order = "t.inputtime DESC,t.zpl_id ASC";//默认为时间倒序
	
		$model = new CActiveDataProvider('MemberPointLog', array(
				'criteria'=>$criteria,
				'pagination'=>array('pageSize'=>$pageSize),
		));
	
		$data = $model->getData();
	
		$result['list'] = $data;
		$result['pages'] = $model->getPagination();
		return $result;
	}
		/**
	 * 取指定时间内的积分记录数
	 * @param integer $memberId 会员ID
	 * @param string $companyId 商家ID
	 * @param number $type 类型:1增加2减少
	 * @param string $zpl_action 操作类型1订单,2评论3.验证,4联盟,5注册推荐6关注7分享
	 * @param int $day  天数
	 * @return integer
	 */
	public function checkPoint($memberId ,$companyId=null,$type=1 ,$zpl_action=null,$day=null ,$zo_id=null){
		$criteria=new CDbCriteria;
		$criteria->compare('zm_id',$memberId);
		if($companyId){
			$criteria->compare('zm_id_cmp',$companyId);
		}
		if($zpl_action){
			$criteria->compare('zpl_action',$zpl_action);
		}
		if($zo_id){
			$criteria->compare('zo_id',$zo_id);
		}
		if($day){
			$nowtime = time();
			$time = $nowtime - (3600*24*$day);
			$criteria->compare('inputtime','>='.$time);
		}
		$criteria->compare('zpl_type',$type);
		$criteria->order = 'inputtime DESC';
		//dump($criteria);
		$model = MemberPointLog::model()->count($criteria);
		return $model;
	}

	/**
	 * 查询会员积分记录
	 * @param integer $memberId 会员ID
	 * @param integer $companyId 商家ID
	 * @param integer $type 类型:1增加2减少
	 * @param integer $zpl_action 操作类型1订单,2评论3.验证,4联盟,5注册推荐6关注7分享
	 */
	public function MemberPoint( $memberId ,$companyId=null , $type=1 ,$zpl_action=null){
		$criteria=new CDbCriteria;
		$criteria->compare('zm_id',$memberId);
		if($companyId){
			$criteria->compare('zm_id_cmp',$companyId);
		}
		if($zpl_action){
			$criteria->compare('zpl_action',$zpl_action);
		}
		$criteria->compare('zpl_type',$type);
		$criteria->order = 'inputtime DESC';
		$model = MemberPointLog::model()->findAll($criteria);
		return $model;
	}
	
	/**
	 * 统计会员积分
	 * @param integer $memberId 会员ID
	 * @param integer $companyId 商家ID
	 * @param integer $type 类型:1增加2减少
	 * @param integer $zpl_action 操作类型1订单,2评论3.验证,4联盟,5注册推荐6关注7分享
	 */
	public function MemberPointcount( $memberId ,$companyId=null , $type=null , $zpl_action=null ){
		$amount =0;
		$criteria=new CDbCriteria;
		$criteria->select = 'SUM(zpl_points) as zpl_points';
		$criteria->compare('zm_id',$memberId);
		if($companyId){
			$criteria->compare('zm_id_cmp',$companyId);
		}
		if($zpl_action){
			$criteria->compare('zpl_action',$zpl_action);
		}
		if($type){
		$criteria->compare('zpl_type',$type);
		}		
		$model = MemberPointLog::model()->find($criteria);
		
		$amount = $model->zpl_points;		
		return $amount;
	}
	/**
	 * 会员总积分
	 * @param integer $memberId 会员ID
	 * @param integer $companyId 商家ID
	 */
	public function MemberAmount($memberId,$companyId=null) {
		$amount =0;
		//订单积分
		$addpoint = $this->MemberPointcount($memberId,$companyId,1);//增加积分和
		$reducepoint = $this->MemberPointcount($memberId,$companyId,2);//减少积分和
		//总积分= 增加的积分总和-减少积分的总和
		$amount = $addpoint - $reducepoint;		
		return $amount;
	}
	

}
