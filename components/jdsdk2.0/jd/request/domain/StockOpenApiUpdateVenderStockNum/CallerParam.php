<?php
namespace StockOpenApiUpdateVenderStockNum;
class CallerParam{

    private $params=array();

    function __construct(){
        $this->params["@type"]="com.jd.stock.base.CallerParam";
    }
        
    private $systemName;
    
    public function setSystemName($systemName){
        $this->params['systemName'] = $systemName;
    }

    public function getSystemName(){
        return $this->systemName;
    }
            
    private $language;
    
    public function setLanguage($language){
        $this->params['language'] = $language;
    }

    public function getLanguage(){
        return $this->language;
    }
            
    private $nationId;
    
    public function setNationId($nationId){
        $this->params['nationId'] = $nationId;
    }

    public function getNationId(){
        return $this->nationId;
    }
            
    private $timezone;
    
    public function setTimezone($timezone){
        $this->params['timezone'] = $timezone;
    }

    public function getTimezone(){
        return $this->timezone;
    }
            
    private $sysIp;
    
    public function setSysIp($sysIp){
        $this->params['sysIp'] = $sysIp;
    }

    public function getSysIp(){
        return $this->sysIp;
    }
    
    function getInstance(){
        return $this->params;
    }

}

?>