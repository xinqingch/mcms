<?php
namespace UnionOpenStatisticsPromotionQuery;
class PromotionEffectDataReq{

    private $params=array();

    function __construct(){
        $this->params["@type"]="com.jd.union.open.gateway.api.dto.statistics.PromotionEffectDataReq";
    }
        
    private $skuId;
    
    public function setSkuId($skuId){
        $this->params['skuId'] = $skuId;
    }

    public function getSkuId(){
        return $this->skuId;
    }
            
    private $activityUrl;
    
    public function setActivityUrl($activityUrl){
        $this->params['activityUrl'] = $activityUrl;
    }

    public function getActivityUrl(){
        return $this->activityUrl;
    }
            
    private $timeType;
    
    public function setTimeType($timeType){
        $this->params['timeType'] = $timeType;
    }

    public function getTimeType(){
        return $this->timeType;
    }
            
    private $dataType;
    
    public function setDataType($dataType){
        $this->params['dataType'] = $dataType;
    }

    public function getDataType(){
        return $this->dataType;
    }
            
    private $fields;
    
    public function setFields($fields){
        $this->params['fields'] = $fields;
    }

    public function getFields(){
        return $this->fields;
    }
    
    function getInstance(){
        return $this->params;
    }

}

?>