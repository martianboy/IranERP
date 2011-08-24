<?php
class RestDataSource
{
	/**
	 *  {    
    *	response:{
    *  	status:0,
    *   	startRow:0,
    *   	endRow:76,
    *  	totalRows:546,
    *   	data:[
    *     	  {field1:"value", field2:"value"},
    *    	   {field1:"value", field2:"value"},
    *     	  ... 75 total records ...
    *   ]
   	*	 }
	* }
	 * @param integer $startRow
	 * @param integer $endRow
	 * @param integer $totalRow
	 * @param datarow[] $data
	 */
	public static function fetchResponse($startRow,$endRow,$totalRow,$data)
	{
		$response= array('response'=> array("status"=>0,
						"startRow"=>$startRow,
						"endRow"=>$endRow,
						"totalRows"=>$totalRow,
						"data"=>$data));
		header('Content-Type: text/html;charset=utf-8');
		echo json_encode($response);
		
	}
	
	public static function RemoveResponse($PKeyRemoved)
	{
		$response= array('response'=> array("status"=>0,
												"data"=>$PKeyRemoved));
		header('application/json; charset=UTF-8');
		echo json_encode($response);
	}
	
	public static function UpdateResponse($UpdatedObject)
	{
		$response= array('response'=> array("status"=>0,
												"data"=>$UpdatedObject));
		header('Content-Type: text/html;charset=utf-8');
		echo json_encode($response);	
		
	}
	
	public static function AddResponse($AddedObject)
	{
		$response= array('response'=> array("status"=>0,
												"data"=>$AddedObject));
		header('Content-Type: text/html;charset=utf-8');
		echo json_encode($response);
		
		
	}
	/**
	 *  {    response:
     * {   status:-4,
     *     errors: 
     *         {   field1:[
     *                 {errorMessage:"First error on field1"},
     *                 {errorMessage:"Second error on field1"}
     *             ],
     *             field2:[{errorMessage:"sxsxx"}]
     *         }
     * }
	*	 }
 
	 * @param integer $ErrorNo
	 * @param Array $Errors
	 */
	public static function SendErrorToClient($ErrorNo=-1,$Errors)
	{

		$response = array('response'=>array("status"=>$ErrorNo,"data"=>$Errors));
		header('Content-Type: text/html;charset=utf-8');
		echo json_encode($response);
	}
}
?>