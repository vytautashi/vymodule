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

class VyModule extends Module
{
    const DEFAULT_CONFIGURATION = [
        'VYMODULE_TASK_NAME' => '',
        'VYMODULE_TASK_DIFFICULTY' => 1,
    ];

    public function __construct()
    {
        $this->initializeModule();
    }

    public function install()
    {
        return
            parent::install()
            && $this->initDefaultConfigurationValues();
    }

    public function uninstall()
    {
        return
            parent::uninstall();
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
}
