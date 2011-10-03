<?php
namespace IRERP\Basics\Descriptors;
use IRERP\Basics\ClientFrameWork;
class DataSource extends DescriptorBase
{
	const DataFormat_JSON='json';
	const DataFormat_XML='xml';
	
	
	
	/**
	 * 
	 * Fields
	 * @var array of DataSourceField
	 */
	protected $fields=array();
	protected $dataFormat=DataSource::DataFormat_JSON;
	protected $fetchurl='';
	protected $addurl='';
	protected $removeurl='';
	protected $updateurl='';
	protected $id='__';
	protected $DetailDS=array();
	
	public function getDetails(){return $this->DetailDS;}
	public function addDetail(DataSource $ds){
		for($i=0;$i<count($this->DetailDS);$i++)
		if($this->DetailDS[i]->getID()==$ds->getID) {
			$this->DetailDS[i]=$ds;
			return ;
		}
		$this->DetailDS[]=$ds;
	}
	
	public function getFields() {return $this->fields;}
	public function addField(DataSourceField $dsf){
		//Check That Field Exists
		for($i=0;$i<count($this->fields);$i++)
			if($this->fields[$i]->getFieldName()==$dsf->getFieldName()) {
				$this->fields[$i]=$dsf;
				return;
			}
		$this->fields[]=$dsf;
	}
	public function removeField(DataSourceField $dsf){
		for($i=0;$i<count($this->fields);$i++)
		if($this->fields[$i]->getFieldName()==$dsf->getFieldName())
		{
			//TODO: Remove $i index from fields
		}
	}
	
	public function setDataFormat($DataFormat){$this->dataFormat=$DataFormat;}
	public function getDataFormat(){return $this->dataFormat;}
	
	public function getfetchURL(){return $this->fetchurl;}
	public function setfetchURL($d){$this->fetchurl=$d;}
	
	public function setaddURL($d){$this->addurl=$d;}
	public function getaddURL(){return $this->addurl;}
	
	public function setupdateURL($d){$this->updateurl=$d;}
	public function getupdateURL(){return $this->updateurl;}
	
	public function setremoveURL($d){$this->removeurl=$d;}
	public function getremoveURL(){return $this->removeurl;}
	
	public function setdataURL($d){
		$this->fetchurl=$d;
		$this->removeurl=$d;
		$this->addurl=$d;
		$this->updateurl=$d;
	}
	
	public function setID($d){$this->id=$d;}
	public function getID(){return $this->id;}
	protected function GetFieldCodes(){
		$str=$this->fields[0]->GenerateClientCode(ClientFrameWork::SmartClient);
		for($i=1;$i<count($this->fields);$i++)
			$str.=','.$this->fields[$i]->GenerateClientCode(ClientFrameWork::SmartClient);
		return $str;
	}
	public function GenerateClientCode($ClientFrameWork)
	{
		switch ($ClientFrameWork)
		{
			case ClientFrameWork::SmartClient:
				$str='';
				$str='isc.RestDataSource.create({';
				$str.='ID:"'.$this->getID().'",';
				$str.='fields:[';
				$str.=$this->GetFieldCodes();
				$str.='],';
				$str.='dataFormat:'.$this->getDataFormat().',';
				$str.='operationBindings:[
     									{operationType:"fetch", dataProtocol:"getParams"},
     									{operationType:"add", dataProtocol:"postParams"},
     									{operationType:"remove",dataProtocol:"postParams",requestProperties:{httpMethod:"DELETE"}},
     									{operationType:"update", dataProtocol:"postParams", requestProperties:{httpMethod:"PUT"}}
									    ],';
				$str.='fetchDataURL :"'.$this->getfetchURL().'",
    					addDataURL   :"'.$this->getaddURL().'",
    					updateDataURL:"'.$this->getupdateURL().'",
    					removeDataURL:"'.$this->getremoveURL().'"';
				$str.=' });';
				return $str;
				break;
		}
	}
	
}
?>
