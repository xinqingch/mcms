<?php
namespace app\components\point;
/**
 * 积分工厂类
 * @author morven
 *
 */
class PointStorage {

	private $instance;
	
	/**
	 * 类
	 * @var string
	 */	
	public $type;
	
	/**
	 * 开关
	 * @var integer
	 */
	public $disjunctor = 1;

	public function __construct($type='one') {
		$this->type = $type;
	}


	/**
	 * 创建实例类
	 * @param string $type 调用实例类型
	 * @throws CHttpException
	 */
	public function create() {
		$className = 'app\\components\\point\\'.ucfirst($this->type) . 'Point';
		if( class_exists($className,true) ) {
			$f = new \ReflectionClass( $className );
			$this->instance = $f->newInstance();
			return;
		}
		throw new CHttpException(500,'No Class Instance');
	}



	/**
	 * 查询所有信息
	 * @param array/string $condition 查询条件
	 * @return array
	 */
	public function findAll( $condition=array() ){
		$this->create();
		$result = $this->instance->findAll($condition);
		return $result;
	}
	
	public function search( $condition=array(), $pageSize=10  ){
		$this->create();
		$result = $this->instance->search($condition,$pageSize);
		return $result;
	}

	/**
	 * 添加/减少积分记录
	 * @param integer $zm_id 会员ID
	 * @param integer $zpl_type 类型:1增加2减少'
	 * @param integer $zpl_action 操作类型1订单,2评论3.验证,4联盟,5注册推荐6关注7分享
	 * @param integer $zpl_points 积分
	 * @param string $zo_id 订单号
	 * @param string $zpl_content 说明
	 * @throws CException
	 * @return PointLog
	 */
	public function add( $zm_id,$zpl_type=1,$zpl_action=1,$zpl_points=0,$zo_id=null,$zpl_content=null ){
		if($this->disjunctor==0){
			$result = true;
		}
		else{
		$this->create();
		$result = $this->instance->create( $zm_id,$zpl_type,$zpl_action,$zpl_points,$zo_id,$zpl_content );
		}
		return $result;
	}
	
	/**
	 * 统计会员积分
	 * @param integer $memberid 会员ID
	 * @param integer $companyId 商家ID
	 * @param integer $type 类型:1增加2减少
	 * @param integer $zpl_action 操作类型1订单,2评论3.验证,4联盟,5注册推荐6关注7分享
	 */	
	public function count( $memberid ,$companyId=null, $type=null , $zpl_action=null ){
		$this->create();
		if($type==null){
			$count = $this->instance->MemberPointcount( $memberid ,$companyId, 1 , $zpl_action );//增加的积分
			$Subtraction = $this->instance->MemberPointcount( $memberid ,$companyId, 2 , $zpl_action );//减少的积分
			$result = $count - $Subtraction;//总积分
		}
		else{
		$result = $this->instance->MemberPointcount( $memberid ,$companyId, $type , $zpl_action );
		}
		return $result;
	}
	
	/**
	 * 查询会员积分记录
	 * @param integer $memberid 会员ID
	 * @param integer $companyId 商家ID
	 * @param integer $type 类型:1增加2减少
	 * @param integer $zpl_action 操作类型1订单,2评论3.验证,4联盟,5注册推荐6关注7分享
	 */
	public function getMemberPoint( $memberid ,$companyId=null, $type=1 ,$zpl_action=null){
		$this->create();
		$result = $this->instance->MemberPoint( $memberid , $type ,$zpl_action);
		return $result;
	}
	
	/**
	 * 读取用户类型的积分
	 * @param integer $type 类型1订单,2评论3.验证,4联盟,5注册推荐6关注7分享
	 * @param string $price 订单价格
	 * @return unknown
	 */
	public function getUserPoint($type='1',$price=null){
		$this->create();
		$result = $this->instance->getUserPoint( $type , $price );
		return $result;
	}
	
	/**
	 * 写入关注积分
	 * @param array $options 接口调用参数
	 * @param string $openid OPENID
	 * @param integer $memberid 会员ID
	 */
	public function SubscribePoint($options,$openid,$memberid,$companyId=1){
		$wechat = new Wechat($options);
		$userinfo = $wechat->getUserInfo($openid);
		if($userinfo['subscribe']==1){//已关注
			$count = $this->count($memberid,$companyId,1,6);
			if($count == 0){				
				$zpl_points = $this->getUserPoint(6);				
				$this->add( $memberid,$companyId,1,6,$zpl_points );				
				$unions = new CommissionStorage();			
				$pid = 	$unions->getParentid($memberid,2,$companyId);//二级用户
				//发送关注短信
				if(!empty($pid)){//发送给二级用户短信
					if($pid != $memberid){
						PhoneLog::model()->sendPhone($pid,$companyId,F::setting('wxmall').url('/member/index',array('id'=>$companyId)),'subscribe',array('name'=>$userinfo['nickname']));
					}
				}
				
				//提醒上家有新用户关注成功
				/*$weixin = new Weixin($options);
				$pidopenid = $weixin->getParentid($memberid);
				$first='您的好友['.$userinfo['nickname'].']通过分享链接成功关注商城';
				$keyword1 = $userinfo['nickname'];
				$keyword1 = date('Y-m-d H:i:s',time());
				$remak='您的好友通过您的链接成功关注,恭喜您获得了'.$zpl_points.'积分';
				$Messagedata = $weixin->getMessage(1, $first, $remak,$keyword1,$keyword2);
				$tempid = 'yDIh0RpvV1YgF-0nztIaMHvh898P7vG-4kYaK26L-w8';
				$url = '#';
				$weixin->setTempMessage($pidopenid, $tempid, $url, $Messagedata);*/
				
			}
		}
		return true;
	}
	/**
	 * 计算分享积分
	 * @param integer $memberid 分享用户ID
	 * @param integer $shareid 来源用户ID
	 * @param integer $shareid 来源商家ID
	 */
	public function SharePoint($memberid,$shareid,$zm_id_cmp=1){
		$share = OneShare::model()->count('zm_id=:zm_id AND parentid=:parentid AND zm_id_cmp=:zm_id_cmp',array(':zm_id'=>$shareid,':parentid'=>$memberid,':zm_id_cmp'=>$zm_id_cmp));
		if( $share==0 ){
			$zpl_points = $this->getUserPoint(7);
			$this->add( $memberid,$zm_id_cmp,1,7,$zpl_points);
			
			//提醒上家有分享成功
			/*$company = CmpWeixin::model()->findByAttributes(array('zm_id'=>$shareid));			
			$options = $company->attributes;
			$weixin = new Weixin($options);
			$member = MemWeixin::model()->find('zm_id=:zm_id AND zm_id_cmp=:zm_id_cmp',array(':zm_id'=>$memberid,':zm_id_cmp'=>$shareid));
			$pidopenid = $member->zm_open_id;
			$first='您的好友通过您的分享链接成功访问';
			$keyword1 = '匿名好友';
			$keyword1 = date('Y-m-d H:i:s',time());
			$remak='您的好友通过您的链接成功关注,恭喜您获得了'.$zpl_points.'积分';
			$Messagedata = $weixin->getMessage(1, $first, $remak,$keyword1,$keyword2);
			$tempid = 'yDIh0RpvV1YgF-0nztIaMHvh898P7vG-4kYaK26L-w8';
			$url = app()->homeUrl.url('/home/shop/index',array('id'=>$company->zm_id));
			$weixin->setTempMessage($pidopenid, $tempid, $url, $Messagedata);*/
		}
		return true;
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
	public function checkPoint($memberId ,$companyId=null,$type=1 ,$zpl_action=null,$day=null,$zo_id=null ){
		$this->create();
		$result = $this->instance->checkPoint($memberId ,$companyId,$type ,$zpl_action,$day,$zo_id);
		return $result;
	}
	/**
	 * 积分类型
	 * @param integer $type 类型
	 * @return Ambigous <string>
	 */
	public function getAction($type){
		$action = array(
				1=>'订单',
				2=>'评论',
				3=>'验证',
				4=>'联盟',
				5=>'注册推荐',
				6=>'关注公众号',
				7=>'产品分享',
		);
		return $action[$type];
	}
	
}

