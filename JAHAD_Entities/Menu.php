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
	 */
	public function getMenuItemTitle(){return $this->MenuItemTitle;}
	public function setMenuItemTitle($value){$this->MenuItemTitle=$value;}
	
	public function getMenuItemIcon(){return $this->MenuItemIcon;}
	public function setMenuItemIcon($value){$this->MenuItemIcon=$value;}
	
	public function getMenuItemChildren(){return $this->MenuItemChildren;}
	public function setMenuItemChildren($value){$this->MenuItemChildren=$value;}
	
	public function getMenuItemParent(){return $this->MenuItemParent;}
	public function setMenuItemParent($value){$this->MenuItemParent=$value;}
	
	public function getMenuItemCommand(){return $this->MenuItemCommand;}
	public function setMenuItemCommand($value){$this->MenuItemCommand=$value;}
	
	/**
	 * SC Functions
	 * Enter description here ...
	 * 
	 * 
	 */
	public function scgetMenuItemTitle(){return $this->getMenuItemTitle();}
	public function scsetMenuItemTitle($value){$this->setMenuItemTitle($value);}
	
	public function scgetMenuItemIcon(){return $this->getMenuItemIcon();}
	public function scsetMenuItemIcon($value){$this->setMenuItemIcon($value);}
	
	public function scgetMenuItemParentTitle(){return $this->getMenuItemParent()->getMenuItemTitle();}
	/**
	 * @scField(name="MenuItemParentID",DoctrineField="Parent.id")
	 * Enter description here ...
	 */	
	public function scgetMenuItemParentID(){return $this->getMenuItemParent()->getID();}
	public function scsetMenuItemParentID($value){$this->setMenuItemParent()->setID($value);}
	
	
	public function scgetMenuItemCommand(){return $this->getMenuItemCommand();}
	public function scsetMenuItemCommand($value){$this->setMenuItemCommand($value);}
}
?>