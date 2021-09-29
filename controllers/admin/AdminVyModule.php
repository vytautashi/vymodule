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

require_once(_PS_MODULE_DIR_ . 'vymodule/classes/VyClient.php');
// You can now access this controller from /your_admin_directory/index.php?controller=AdminVyModule
class AdminVyModuleController extends ModuleAdminController
{
	public function __construct()
	{
		$this->name 		= VyClient::TABLE;
		$this->table 		= VyClient::TABLE;
		$this->className 	= 'VyClient';
		$this->identifier 	= 'id';
		$this->bootstrap 	= true;

		parent::__construct();
	}

	public function renderForm()
	{
		$this->fields_form = [
			'legend' => [
				'title' => 'Client',
				'icon' => 'icon-cog',
			],
			'input' => [
				[
					'type' => 'text',
					'label' => 'First name',
					'name' => 'first_name',
					'required' => true,
				],
				[
					'type' => 'text',
					'label' => 'Last name',
					'name' => 'last_name',
					'required' => true,
				],
				[
					'type' => 'text',
					'label' => 'Email',
					'name' => 'email',
					'required' => true,
				],
			],
			'submit' => [
				'title' => 'Save',
				'class' => 'btn btn-default pull-right'
			],
		];

		return parent::renderForm();
	}

	public function renderList()
	{
		$fields_list = [
			'id' => [
				'title' => 'Id',
				'type' => 'text',
			],
			'first_name' => [
				'title' => 'First Name',
				'type' => 'text',
			],
			'last_name' => [
				'title' => 'Last Name',
				'type' => 'text',
			],
			'email' => [
				'title' => 'Email',
				'type' => 'link',
			],
		];

		$clients = VyClient::getClients();

		$helper = new HelperList();
		$helper->listTotal = count($clients);
		$helper->shopLinkType = '';
		$helper->simple_header = true;
		$helper->identifier = 'id';
		$helper->table = VyClient::TABLE;
		$helper->actions = ['edit', 'delete'];
		$helper->show_toolbar = false;
		$helper->module = $this;
		$helper->title = 'Client list';
		$helper->token = $this->token;
		$helper->currentIndex = AdminController::$currentIndex;

		$htmlButtonAddNewClient = '<a class="btn btn-primary" href="' . AdminController::$currentIndex . '&add' . $this->name . '&token=' . $this->token . '">Add new client</a>';

		return $htmlButtonAddNewClient . $helper->generateList($clients, $fields_list);
	}
}
