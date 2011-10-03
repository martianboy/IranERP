<?php 
namespace IRERP\Basics\Annotations\UI;

/**
 * هدف از این نشانه تعریف پروفایل مورد استفاده  
 * برای خصوصیت است
 */
/** @Annotation */
final class IRUseAsProfile extends IRUIAnnotation
{
 	public $TargetProfile;
	public $PrefixTitle;
	public $PostfixTitle;
	

}
?>