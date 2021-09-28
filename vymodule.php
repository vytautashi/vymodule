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
        // Put your default configuration here, e.g :
        // 'VYMODULE_BACKGROUND_COLOR' => '#eee',
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
        return 'Vy Module configuration page !';
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
}
