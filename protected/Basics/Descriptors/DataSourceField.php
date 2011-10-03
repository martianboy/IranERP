<?php
namespace IRERP\Basics\Descriptors;

use Doctrine\DBAL\Types\BooleanType;
use IRERP\Basics\ClientFrameWork;


class DataSourceField extends DescriptorBase
{
	
	protected $title='';
	/**
	 * Indicates to FieldName
	 * @var string
	 */
	protected $FieldName='';
	/**
	 * 
	 * Indicates to field type that can be string or integer or double
	 * @var string (string or integer or double)
	 */
	protected $FieldType='string';
	/**
	 * 
	 * Inicates that this Field is Hidden
	 * @var Boolean
	 */
	protected $Hidden=false;
	/**
	 * 
	 * Indicates that this field is Primary Key
	 * @var Boolean
	 */
	protected $PrimaryKey=false;
	public function setFieldName($v){$this->FieldName=$v;}
	public function getFieldName(){return $this->FieldName;}
	
	public function setFieldType($v){$this->FieldType=$v;}
	public function getFieldType(){return $this->FieldType;}

	public function setHidden($v){$this->Hidden=$v;}
	public function getHidden(){return $this->Hidden;}

	public function setPrimaryKey($v){$this->PrimaryKey=$v;}
	public function getPrimaryKey(){return $this->PrimaryKey;}
	
	public function getTitle(){return $this->title;}
	public function setTitle($d){$this->title=$d;}
	
	
	public function GenerateClientCode($ClientFrameWork)
	{
		$fname =$this->getFieldName();
		$type=$this->getFieldType();
		if($this->getHidden()) $hidden='true'; else $hidden='false';
		if($this->getPrimaryKey()) $pk='true'; else $pk='false';
		$tit = $this->getTitle();
		$str='';
		switch($ClientFrameWork){
			case ClientFrameWork::SmartClient:
				$str="{hidden:\"$hidden\",name:\"$fname\",primaryKey:\"$pk\",type:\"$type\",title:\"$tit\"}";
			break;
		}
		return $str;	
	}
}
	
	
	
	
	
	
	
	

?>