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
	 * @Column(type="blob",length="15000")
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
}
?>