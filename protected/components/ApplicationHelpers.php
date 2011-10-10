<?php 
use IRERP\Basics\Annotations\UI\IRParentGridMember;
use IRERP\Basics\Annotations\UI\IRUseAsProfile;
use Doctrine\ORM\Mapping\ManyToOne;
use IRERP\Basics\Annotations\UI\IRTitle;
use IRERP\Basics\Annotations\UI\IRPropertyType;
use IRERP\Basics\Annotations\UI\IRUseInClientDS;
use IRERP\Basics\Models\IRDataModel;
use IRERP\Basics\Descriptors;
use 
    Doctrine\Common\Annotations\AnnotationReader,
    Doctrine\Common\Annotations\AnnotationRegistry,
    Doctrine\ORM\Mapping\ClassMetadataInfo,
    Doctrine\ORM\Mapping\MappingException;
 


class ApplicationHelpers
{
	protected static function GetValidAnnotationUsingProfile($annots , $an,$Profile='General')
	{
		if($annots==NULL) return NULL;
		$specificAnnots =array();
		foreach ($annots as $a)
			if(is_a($a,get_class($an)))	
				$specificAnnots[]=$a;

		$rtnval=NULL;
		foreach ($specificAnnots as $spca)
		{
			if($spca->Profile==NULL){
				//Check That NotForProfile
				if($spca->NotForProfile==NULL) $rtnval=$spca;
				else 
				{
				$notfor = split(',', $spca->NotForProfile);
				if(array_search($Profile, $notfor)) $rtnval=NULL;
				else $rtnval=$spca;
				}
			}
			
			if($rtnval!=NULL) break;
		}
		
		return $rtnval;
		
	}
	
	
	public static function GetDataSourceDescriptor(IRDataModel $Cls,$Profile='General',IRDataModel $ParentClass=NULL,$ParentProperty='')
	{
		$ManyToOne=2;
		$OneToOne=1;
		$ManyToMany=8;
		$OneToMany=4;
		//Check That is There GetDataSourceDescriptor Method in $Cls
		$clsref = new \ReflectionClass($Cls);
		$clsmethod=NULL;
		try{
		$clsmethod= $clsref->getMethod('GetDataSourceDescriptor');
		}catch(Exception $ex)
		{
			$clsmethod=NULL;
		}
		if($clsmethod != NULL) 
			return $clsmethod->invoke($Cls,$Profile,$ParentClass);
		$DS = new \IRERP\Basics\Descriptors\DataSource();
		//Get All Properties
		$allprops = $clsref->getProperties();
		$reader=new AnnotationReader();
		$reader->setIgnoreNotImportedAnnotations(true);
		foreach ($allprops as $p) {
			print_r('Prop:'.$p->name.'*** <br/>');
			$dsfield = new \IRERP\Basics\Descriptors\DataSourceField();
			$annots = $reader->getPropertyAnnotations($p);
			//Check That Field Can Use To ClientSide or Not
				$IRUSEINCLIENT= \ApplicationHelpers::GetValidAnnotationUsingProfile($annots, new IRUseInClientDS(array()),$Profile);
				if($IRUSEINCLIENT==NULL) continue;
				$IRParentGridMember= \ApplicationHelpers::GetValidAnnotationUsingProfile($annots, new IRParentGridMember(array()),$Profile);
				if($IRParentGridMember==NULL) continue;
				//Get Field Type
				$FieldType = \ApplicationHelpers::GetValidAnnotationUsingProfile($annots, new IRPropertyType(array()),$Profile);
				print_r($annots);
				if($FieldType==NULL){
					//Complex Field 
					//Check That Relation is *ToOne?
					$meta = $Cls->getEntityManager()->getClassMetadata(get_class($Cls));
					if($meta->associationMappings[$p->name]['type']==$ManyToOne 
												||
					   $meta->associationMappings[$p->name]['type']==$OneToOne)
						{
							//Check That Can We Use this Property
							//Is Defined IRUseAsProfile
							$isuseasprofile = \ApplicationHelpers::GetValidAnnotationUsingProfile($annots,new IRUseAsProfile(array()),$Profile);
							if($isuseasprofile==NULL) continue;
							$trgcls = new \ReflectionClass($meta->associationMappings[$p->name]['targetEntity']);
							$trgcls= $trgcls->newInstance();
							$tmprtns=\ApplicationHelpers::GetDataSourceDescriptor($trgcls,$isuseasprofile->TargetProfile,$Cls,$p->name);
							if($tmprtns!=NULL)
							{
								if($tmprtns['Fields']!=NULL)
									foreach ($tmprtns['Fields'] as $tmpa)
									{
										if($isuseasprofile->PrefixTitle!=NULL) $tmpa->setTitle($isuseasprofile->PrefixTitle.$tmpa->getTitle());
										if($isuseasprofile->PostfixTitle!=NULL) $tmpa->setTitle($tmpa->getTitle().$isuseasprofile->PostfixTitle);
										$DS->addField($tmpa);
									}
								if($tmprtns['DataSource']!=NULL)
									$DS->addDetail($tmprtns['DataSource']);
							}
						}
						//Check That Relation is *ToMany
					if($meta->associationMappings[$p->name]['type']==$ManyToMany 
												||
					   $meta->associationMappings[$p->name]['type']==$OneToMany)
						{
							$trgcls = new \ReflectionClass($meta->associationMappings[$p->name]['targetEntity']);
							$trgcls= $trgcls->newInstance();
							$tmprtns=\ApplicationHelpers::GetDataSourceDescriptor($trgcls,$isuseasprofile->TargetProfile,$Cls,$p->name);
							if($tmprtns!=NULL)
							{
								if($tmprtns['Fields']!=NULL)
									foreach ($tmprtns['Fields'] as $tmpa)
										$DS->addField($tmpa);
								if($tmprtns['DataSource']!=NULL)
									$DS->addDetail($tmprtns['DataSource']);
							}
						}
				}else{
					//Simple Field
					$FieldType=\ApplicationHelpers::GetValidAnnotationUsingProfile($annots, new IRPropertyType(array()),$Profile);
					$FieldTitle=\ApplicationHelpers::GetValidAnnotationUsingProfile($annots, new IRTitle(array()),$Profile);
					if($ParentClass==NULL)
						$FieldName = $p->name;
					else 
						$FieldName=str_replace('\\', '_5c', get_class($ParentClass)).$ParentProperty.'_2E'.$p->name;
					
					$dsfield->setFieldName($FieldName);
					$dsfield->setFieldType($FieldType->Type);
					$dsfield->setTitle($FieldTitle->GetTitle($Cls,$ParentClass));
					if($FieldName=='id') {$dsfield->setHidden(true);$dsfield->setPrimaryKey(true);}
				}
				$DS->addField($dsfield);
		}
		$ID = str_replace('\\', '_', get_class($Cls));
		$DS->setID($ID);
		$Address = str_replace('\\IRERP\\modules\\', '', get_class($Cls));
		$Address=str_replace('\\models', '', $Address);
		$Address=str_replace('\\', '/', $Address);
		$Address=\Yii::app()->baseUrl.'/'.$Address;
		$DS->setdataURL($Address);
		return array('Fields'=>NULL,'DataSource'=>$DS);
	} 
	
	public static function 
	GetPropertyInTargetFor1nRelation(IRDataModel $sourceClass,
										$propname,
									 IRDataModel $targetclass)
	{
		$trgmeta = $targetclass->getEntityManager()->getClassMetadata(get_class($targetclass));
		$trgasso=$trgmeta->associationMappings;
		foreach ($trgasso as $FiledName=>$Dscriptor)
			if($Dscriptor['targetEntity']==get_class($sourceClass) &&
			$Dscriptor['inversedBy']==$propname

			) return $FiledName;
		return NULL
		;
	}
	/**
	 * 
	 * Convert Object To Array 
	 * 
	 * @param Object $object
	 */
public static function parseObjectToArray($object) {
    $array = array();
    if (is_object($object)) {
        $array = get_object_vars($object);
    }
    return $array;
}

/**
 * 
 * Translate $VarName To Doctrine Fields Using 
 * scField Annotation Defined in $ClassName
 * for scget or scset methods
 * @param string $VarName
 * @param string $ClassName
 * @param string $namespace
 */
public static function TranslateSCVarsToDoctrine($VarName,$ClassName)
{
	$reader= new AnnotationReader();
	$methods = get_class_methods($ClassName);
	foreach ($methods as $methodName)
	{
		if
		(
			substr($methodName,0,3)=='get' || 
			substr($methodName,0,3)=='set'
		)
		{
			$reflmethod = new ReflectionMethod($ClassName, $methodName);
			$MethodAnns = $reader->getMethodAnnotations($reflmethod);
			
			foreach($MethodAnns as $annots) {
				if(is_a($annots,'\IRERP\Basics\Annotations\scField')) {
					//Check That VarName Defined in $annots
					if($annots->name==$VarName)
						return $annots->DoctrineField;
				}
			}
		}
	}
	return $VarName;
}



/**
 * A function for easily uploading files. This function will automatically generate a new 
 *        file name so that files are not overwritten.
 * Taken From: http://www.bin-co.com/php/scripts/upload_function/
 * Arguments:    $file_id- The name of the input field contianing the file.
 *                $folder    - The folder to which the file should be uploaded to - it must be writable. OPTIONAL
 *                $types    - A list of comma(,) seperated extensions that can be uploaded. If it is empty, anything goes OPTIONAL
 * Returns  : This is somewhat complicated - this function returns an array with two values...
 *                The first element is randomly generated filename to which the file was uploaded to.
 *                The second element is the status - if the upload failed, it will be 'Error : Cannot upload the file 'name.txt'.' or something like that
 */
public static function upload($file_id, $folder="", $types="") {
    if(!$_FILES[$file_id]['name']) return array('','No file specified');

    $file_title = $_FILES[$file_id]['name'];
    //Get file extension
    $ext_arr = split("\.",basename($file_title));
    $ext = strtolower($ext_arr[count($ext_arr)-1]); //Get the last extension

    //Not really uniqe - but for all practical reasons, it is
    $uniqer = substr(md5(uniqid(rand(),1)),0,5);
    $file_name = $uniqer . '_' . $file_title;//Get Unique Name

    $all_types = explode(",",strtolower($types));
    if($types) {
        if(in_array($ext,$all_types));
        else {
            $result = "'".$_FILES[$file_id]['name']."' is not a valid file."; //Show error if any.
            return array('',$result);
        }
    }

    //Where the file must be uploaded to
    if($folder) $folder .= '/';//Add a '/' at the end of the folder
    $uploadfile = $folder . $file_name;

    $result = '';
    //Move the file from the stored location to the new location
    if (!move_uploaded_file($_FILES[$file_id]['tmp_name'], $uploadfile)) {
        $result = "Cannot upload the file '".$_FILES[$file_id]['name']."'"; //Show error if any.
        if(!file_exists($folder)) {
            $result .= " : Folder don't exist.";
        } elseif(!is_writable($folder)) {
            $result .= " : Folder not writable.";
        } elseif(!is_writable($uploadfile)) {
            $result .= " : File not writable.";
        }
        $file_name = '';
        
    } else {
        if(!$_FILES[$file_id]['size']) { //Check if the file is made
            @unlink($uploadfile);//Delete the Empty file
            $file_name = '';
            $result = "Empty file found - please use a valid file."; //Show the error message
        } else {
            chmod($uploadfile,0777);//Make it universally writable.
        }
    }

    return array($file_name,$result);
}


public static function mime_content_type($filename) {

        $mime_types = array(

            'txt' => 'text/plain',
            'htm' => 'text/html',
            'html' => 'text/html',
            'php' => 'text/html',
            'css' => 'text/css',
            'js' => 'application/javascript',
            'json' => 'application/json',
            'xml' => 'application/xml',
            'swf' => 'application/x-shockwave-flash',
            'flv' => 'video/x-flv',

            // images
            'png' => 'image/png',
            'jpe' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'jpg' => 'image/jpeg',
            'gif' => 'image/gif',
            'bmp' => 'image/bmp',
            'ico' => 'image/vnd.microsoft.icon',
            'tiff' => 'image/tiff',
            'tif' => 'image/tiff',
            'svg' => 'image/svg+xml',
            'svgz' => 'image/svg+xml',

            // archives
            'zip' => 'application/zip',
            'rar' => 'application/x-rar-compressed',
            'exe' => 'application/x-msdownload',
            'msi' => 'application/x-msdownload',
            'cab' => 'application/vnd.ms-cab-compressed',

            // audio/video
            'mp3' => 'audio/mpeg',
            'qt' => 'video/quicktime',
            'mov' => 'video/quicktime',

            // adobe
            'pdf' => 'application/pdf',
            'psd' => 'image/vnd.adobe.photoshop',
            'ai' => 'application/postscript',
            'eps' => 'application/postscript',
            'ps' => 'application/postscript',

            // ms office
            'doc' => 'application/msword',
            'rtf' => 'application/rtf',
            'xls' => 'application/vnd.ms-excel',
            'ppt' => 'application/vnd.ms-powerpoint',

            // open office
            'odt' => 'application/vnd.oasis.opendocument.text',
            'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
        );

        $ext = strtolower(array_pop(explode('.',$filename)));
        if (array_key_exists($ext, $mime_types)) {
            return $mime_types[$ext];
        }
        elseif (function_exists('finfo_open')) {
            $finfo = finfo_open(FILEINFO_MIME);
            $mimetype = finfo_file($finfo, $filename);
            finfo_close($finfo);
            return $mimetype;
        }
        else {
            return 'application/octet-stream';
        }
    }
}



?>
