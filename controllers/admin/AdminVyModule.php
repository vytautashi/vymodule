<?php
# /modules/vymodule/controllers/admin/AdminVyModule.php

/**
 * Vy Module - A Prestashop Module
 * 
 * My Module Description
 * 
 * @author vytautashi <vytautashi>
 * @version 1.0.0
 */

if (!defined('_PS_VERSION_')) exit;

// You can now access this controller from /your_admin_directory/index.php?controller=AdminVyModule
class AdminVyModuleController extends ModuleAdminController
{
	public function __construct()
	{
		parent::__construct();
		// Do your stuff here
	}

	public function renderList()
	{
		$fields_list = [
			'id' => [
				'title' => $this->l('Id'),
				'type' => 'text',
			],
			'first_name' => [
				'title' => $this->l('First Name'),
				'type' => 'text',
			],
			'last_name' => [
				'title' => $this->l('Last Name'),
				'type' => 'text',
			],
			'email' => [
				'title' => $this->l('Email'),
				'type' => 'link',
			],
		];

		$helper = new HelperList();
		$helper->shopLinkType = '';
		$helper->simple_header = true;
		$helper->identifier = 'id';
		$helper->table = 'vymodule_client';
		$helper->actions = ['edit'];
		$helper->show_toolbar = false;
		$helper->module = $this;
		$helper->title = 'Client list';
		$helper->token = Tools::getAdminTokenLite('AdminModules');
		$helper->currentIndex = AdminController::$currentIndex . '&configure=' . $this->name;


		$sql = 'SELECT * FROM ' . VyModule::DB_CLIENT_TABLE;
		$clients = Db::getInstance()->ExecuteS($sql);

		return $helper->generateList($clients, $fields_list);
	}
}
