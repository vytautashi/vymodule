<?php
# /modules/vymodule/vymodule.php

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
class VyModule extends Module
{
    const DEFAULT_CONFIGURATION = [
        'VYMODULE_TASK_NAME' => '',
        'VYMODULE_TASK_DIFFICULTY' => 1,
    ];

    const PRODUCT_NAME_SUFFIX = " (Bandomoji užduotis)";
    const DB_CLIENT_TABLE     = _DB_PREFIX_ . VyClient::TABLE;

    public function __construct()
    {
        $this->initializeModule();
    }

    public function install()
    {
        $sqlQuery = ' CREATE TABLE IF NOT EXISTS `' . self::DB_CLIENT_TABLE . '` (
            `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
            `first_name` varchar(255) NOT NULL,
            `last_name` varchar(255) NOT NULL,
            `email` varchar(255) NOT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=UTF8;';

        return
            parent::install()
            && $this->registerHook('actionProductUpdate')
            && $this->installTab()
            && $this->initDefaultConfigurationValues()
            && Db::getInstance()->execute($sqlQuery)
            && $this->seedClientTable();
    }

    public function uninstall()
    {
        return
            parent::uninstall()
            && $this->uninstallTab();
    }

    /** Module configuration page */
    public function getContent()
    {
        if (Tools::isSubmit('submitTaskForm')) {
            Configuration::updateValue('VYMODULE_TASK_NAME', Tools::getValue('VYMODULE_TASK_NAME'));
            Configuration::updateValue('VYMODULE_TASK_DIFFICULTY', Tools::getValue('VYMODULE_TASK_DIFFICULTY'));
        }
        return $this->renderForm();
    }

    /** If client table during installation is empty, seed example rows */
    private function seedClientTable()
    {
        $sql = 'SELECT * FROM ' . self::DB_CLIENT_TABLE;
        $result = Db::getInstance()->ExecuteS($sql);

        if (!empty($result)) {
            return true;
        }


        $sql = 'INSERT INTO ' . self::DB_CLIENT_TABLE . ' ( first_name, last_name, email) VALUES ' .
            '("Tom", "Tom Last", "tom@tom"),("Alice", "Alice Last", "alice@alice")';

        return Db::getInstance()->execute($sql);
    }

    /** Initialize the module declaration */
    private function initializeModule()
    {
        $this->name = 'vymodule';
        $this->tab = 'administration';
        $this->version = '1.0.0';
        $this->author = 'vytautashi';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = [
            'min' => '1.6',
            'max' => _PS_VERSION_,
        ];
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Vy Module');
        $this->description = $this->l('My Module Description');
        $this->confirmUninstall = $this->l('Are you sure you want to uninstall this module ?');
    }

    /** Install module tab, to your admin controller */
    private function installTab()
    {
        $languages = Language::getLanguages();

        $tab = new Tab();
        $tab->class_name = 'AdminVyModule';
        $tab->module = $this->name;
        $tab->id_parent = (int)Tab::getIdFromClassName('DEFAULT');

        foreach ($languages as $lang) {
            $tab->name[$lang['id_lang']] = 'Vy Module';
        }

        try {
            $tab->save();
        } catch (Exception $e) {
            return false;
        }

        return true;
    }

    /** Uninstall module tab */
    private function uninstallTab()
    {
        $tab = (int)Tab::getIdFromClassName('AdminVyModule');

        if ($tab) {
            $mainTab = new Tab($tab);

            try {
                $mainTab->delete();
            } catch (Exception $e) {
                echo $e->getMessage();

                return false;
            }
        }

        return true;
    }

    /** Set module default configuration into database */
    private function initDefaultConfigurationValues()
    {
        foreach (self::DEFAULT_CONFIGURATION as $key => $value) {
            if (!Configuration::get($key)) {
                Configuration::updateValue($key, $value);
            }
        }

        return true;
    }

    /** Generates configuration window form view */
    public function renderForm()
    {
        $form = [
            [
                'form' => [
                    'legend' => [
                        'title' => $this->l('Settings'),
                        'icon' => 'icon-cogs'
                    ],
                    'input' => [
                        [
                            'type' => 'text',
                            'label' => $this->l('Užduoties pavadinimas'),
                            'name' => 'VYMODULE_TASK_NAME',
                        ],
                        [
                            'type' => 'select',
                            'label' => $this->l('Užduoties sunkumas'),
                            'name' => 'VYMODULE_TASK_DIFFICULTY',
                            'options' => [
                                'query' => [
                                    [
                                        'id' => 1,
                                        'label' => 'Lengva',
                                    ],
                                    [
                                        'id' => 2,
                                        'label' => 'Vidutiniškai sunki',
                                    ],
                                    [
                                        'id' => 3,
                                        'label' => 'Sunki',
                                    ],
                                ],
                                'id' => 'id',
                                'name' => 'label',
                            ],
                        ],
                    ],
                    'submit' => [
                        'title' => $this->l('Save'),
                        'class' => 'btn btn-default pull-right'
                    ],
                ],
            ],
        ];

        $helper = new HelperForm();
        $helper->submit_action = 'submitTaskForm';
        $helper->tpl_vars = [
            'fields_value' => [
                'VYMODULE_TASK_NAME' => Tools::getValue('VYMODULE_TASK_NAME', Configuration::get('VYMODULE_TASK_NAME')),
                'VYMODULE_TASK_DIFFICULTY' => Tools::getValue('VYMODULE_TASK_DIFFICULTY', Configuration::get('VYMODULE_TASK_DIFFICULTY')),
            ],
        ];
        return $helper->generateForm($form);
    }

    /** Adds constant of PRODUCT_NAME_SUFFIX at the end of product name after saving product */
    public function hookActionProductUpdate(array $params)
    {
        $product = $params['product'];
        $must_update = false;

        foreach (Language::getLanguages(false) as $lang) {

            $name = $product->name[$lang['id_lang']];

            if (substr($name, -strlen(self::PRODUCT_NAME_SUFFIX)) === self::PRODUCT_NAME_SUFFIX) {
                continue;
            }

            $product->name[$lang['id_lang']] .= self::PRODUCT_NAME_SUFFIX;
            $must_update = true;
        }

        if ($must_update) {
            $product->save();
        }
    }
}
