<?php
class StockOpenApiUpdateVenderStockNumRequest
{


	private $apiParas = array();
	
	public function getApiMethodName(){
	  return "jingdong.stock.open.api.updateVenderStockNum";
	}
	
	public function getApiParas(){
        if(empty($this->apiParas)){
	        return "{}";
	    }
		return json_encode($this->apiParas);
	}
	
	public function check(){
		
	}
	
    public function putOtherTextParam($key, $value){
		$this->apiParas[$key] = $value;
		$this->$key = $value;
	}

    private $version;

    public function setVersion($version){
        $this->version = $version;
    }

    public function getVersion(){
        return $this->version;
    }
    private  $venderStockParam;

    public function setVenderStockParam($venderStockParam){
        $this->apiParas['venderStockParam'] = $venderStockParam;
    }
    public function getVenderStockParam(){
        return $this->apiParas['venderStockParam'];
    }
    private  $callerParam;

    public function setCallerParam($callerParam){
        $this->apiParas['callerParam'] = $callerParam;
    }
    public function getCallerParam(){
        return $this->apiParas['callerParam'];
    }
}

?>