<?php
class KeplerYaoWareStockUpdateRequest
{

    public function __construct()
    {
         $this->version = "1.0";
    }

	private $apiParas = array();
	
	public function getApiMethodName(){
	  return "jd.kepler.yao.ware.stock.update";
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
                                    	                   			private $venderId;
    	                        
	public function setVenderId($venderId){
		$this->venderId = $venderId;
         $this->apiParas["venderId"] = $venderId;
	}

	public function getVenderId(){
	  return $this->venderId;
	}

                                                 	                        	                                                                                                                                                                                                                                                                                        private $venderSku;
                              public function setVenderSku($venderSku ){
                 $this->venderSku=$venderSku;
                 $this->apiParas["venderSku"] = $venderSku;
              }

              public function getVenderSku(){
              	return $this->venderSku;
              }
                                                                                                                                                                                                                                                                                                                       private $skuStock;
                              public function setSkuStock($skuStock ){
                 $this->skuStock=$skuStock;
                 $this->apiParas["skuStock"] = $skuStock;
              }

              public function getSkuStock(){
              	return $this->skuStock;
              }
                                                                                                                                                                                                                                                                                                                       private $skuPrice;
                              public function setSkuPrice($skuPrice ){
                 $this->skuPrice=$skuPrice;
                 $this->apiParas["skuPrice"] = $skuPrice;
              }

              public function getSkuPrice(){
              	return $this->skuPrice;
              }
                                                                                                                }





        
 

