<?php
require_once 'DBEntity.php';

/**
 * @Entity @Table(name="Menu")
 */
class MenuItem extends DbEntity
{
	/**
	 * @Column(type="string",length=50)
	 */
	protected $MenuItemTitle;
	
	/**
	 * @Column(type="string",length="1500")
	 * Enter description here ...
	 * @var unknown_type
	 */
	protected $MenuItemIcon;
	
	/**
	 * @ManyToOne(targetEntity="MenuItem",inversedBy="MenuItemChildren")
	 */
	protected $MenuItemParent;
	
	/**
	 * @OneToMany(targetEntity="MenuItem",mappedBy="MenuItemParent")
	 */
	protected  $MenuItemChildren;
	
	/**
	 * @Column(type="string",length=500)
	 */
	protected $MenuItemCommand;
	
	/**
	 * 
	 * BL Functions
	 * @scField(name="MenuTitle",DoctrineField="MenuItemTitle",
	 * 			type="string",length="100",title="عنوان منو")
	 */
	public function getMenuItemTitle(){return $this->MenuItemTitle;}
	public function setMenuItemTitle($value){$this->MenuItemTitle=$value;}
	/**
	 * 
	 * @scField(name="IconPath",DoctrineField="MenuItemIcon",
	 * 			type="string",length="500",title="مسیر آیکون")
	 */
	public function getMenuItemIcon(){return $this->MenuItemIcon;}
	public function setMenuItemIcon($value){$this->MenuItemIcon=$value;}
	/**
	 * @scField(name="MenuItemCommand",DoctrineField="MenuItemCommand",type="string",length=200,title="دستور منو") 
	 */
	public function getMenuItemCommand(){return $this->MenuItemCommand;}
	public function setMenuItemCommand($value){$this->MenuItemCommand=$value;}
	
	
	/**
	 * 
	 * @scField(name="ParentTitle",DoctrineField="MenuItemParent.MenuItemTitle",type="string",length=100,title="منوی پدر")
	 */
	public function getMenuItemParentTitle(){
		if ($this->getMenuItemParent()==null) return '';
		return $this->getMenuItemParent()->getMenuItemTitle();
	}
	public function setMenuItemParentTitle($v){}
	/**
	 * @scField(name="MenuItemParentID",DoctrineField="MenuItemParent.id",foreignKey="id",hidden=true)
	 * Enter description here ...
	 */	
	public function getMenuItemParentID(){
		if ($this->getMenuItemParent() == null) return NULL;
		return $this->getMenuItemParent()->getID();}
	public function setMenuItemParentID($value){
		//Check That there is an object with this ID
		$parent = $this->GetByID($value);
		if($parent!=NULL) $this->setMenuItemParent($parent);
		else $this->setMenuItemParent(NULL);
	}
	
	public function getMenuItemChildren(){return $this->MenuItemChildren;}
	public function setMenuItemChildren($value){$this->MenuItemChildren=$value;}
	
	public function getMenuItemParent(){return $this->MenuItemParent;}
	public function setMenuItemParent($value){$this->MenuItemParent=$value;}
	
}
?>