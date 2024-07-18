<?php
namespace StockOpenApiUpdateVenderStockNum;
class VenderStockDetailParam{

    private $params=array();

    function __construct(){
        $this->params["@type"]="com.jd.stock.bk.export.param.VenderStockDetailParam";
    }
        
    private $num;
    
    public function setNum($num){
        $this->params['num'] = $num;
    }

    public function getNum(){
        return $this->num;
    }
            
    private $skuId;
    
    public function setSkuId($skuId){
        $this->params['skuId'] = $skuId;
    }

    public function getSkuId(){
        return $this->skuId;
    }
            
    private $sid;
    
    public function setSid($sid){
        $this->params['sid'] = $sid;
    }

    public function getSid(){
        return $this->sid;
    }
    
    function getInstance(){
        return $this->params;
    }

}

?>