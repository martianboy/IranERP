<?php

function setwhere($a)
{
$change=array(
	'lessThan'=>' < :p',
	'greaterThan'=>' > :p',
	'lessThanOrEqual'=>' <= :p',
	'greaterThanOrEqual'=>' >= :p',
	'betweenInclusive'=>' between :1p and :2p',
	'notEqual'=>' != :p',
	'startsWith'=>' like :p',
	'endsWith'=>' like :p',
	'notStartsWith'=>' not like :p',
	'notEndsWith'=>' not like :p',
	'iContains'=>' like :p',
	'notContains'=>' not like :p',
	'inSet'=>' in :p',
	'notInSet'=>' not in :p',
	'isNull'=>' IS NULL',
	'isNotNull'=>' IS NOT NULL ',
	'exact match'=>' = :p',
	'equals'=>' = :p '
);


$reval=array();
$ret='';
$tmp1=0;
foreach ($a as &$s) 
{
	$tmp1++;
	switch ($s['operator']){
		case 'startsWith':
		case 'notStartsWith': $tmp=$s['value'].'%'; break;
		case 'endsWith': 
		case 'notEndsWith': $tmp='%'.$s['value']; break;
		case 'iContains': 
		case 'notContains': $tmp='%'.$s['value'].'%'; break;
		default: $tmp=$s['value'];break;
	}
	if($s['operator']=='betweenInclusive')
	{
		$reval['1'.$s['fieldName'].$tmp1]=$s['value'][0];
		$reval['2'.$s['fieldName'].$tmp1]=$s['value'][1];
	}
	else 
  {
		$reval[$s['fieldName'].$tmp1]=$tmp;
		
	}	
	if($tmp1!=1)
	{


		$ret=$ret.' and tmp.'. $s['fieldName'].str_replace('p',$s['fieldName'].$tmp1,$change[$s['operator']]);
	}
	else
	{
		
		$ret='tmp.'.$s['fieldName'].str_replace('p',$s['fieldName'].$tmp1,$change[$s['operator']]);
	}
}
return array($ret,$reval);
}
?>
