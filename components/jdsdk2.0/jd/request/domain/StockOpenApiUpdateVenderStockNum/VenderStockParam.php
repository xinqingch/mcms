<?php
namespace StockOpenApiUpdateVenderStockNum;
class VenderStockParam{

    private $params=array();

    function __construct(){
        $this->params["@type"]="com.jd.stock.bk.export.param.VenderStockParam";
    }
        
    private $companyId;
    
    public function setCompanyId($companyId){
        $this->params['companyId'] = $companyId;
    }

    public function getCompanyId(){
        return $this->companyId;
    }
            
    private $venderStockDetailParamList;
                                        
    public function setVenderStockDetailParamList($venderStockDetailParamList){
        $size = count($venderStockDetailParamList);
        for ($i=0; $i<$size; $i++){
            $venderStockDetailParamList [$i] = $venderStockDetailParamList [$i] ->getInstance();
        }
        $this->params['venderStockDetailParamList'] = $venderStockDetailParamList;
    }
                                    
            
    private $venderCode;
    
    public function setVenderCode($venderCode){
        $this->params['venderCode'] = $venderCode;
    }

    public function getVenderCode(){
        return $this->venderCode;
    }
            
    private $billId;
    
    public function setBillId($billId){
        $this->params['billId'] = $billId;
    }

    public function getBillId(){
        return $this->billId;
    }
            
    private $extBillId;
    
    public function setExtBillId($extBillId){
        $this->params['extBillId'] = $extBillId;
    }

    public function getExtBillId(){
        return $this->extBillId;
    }
    
    function getInstance(){
        return $this->params;
    }

}

?>