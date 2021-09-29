<?php


class VyClient extends ObjectModel
{
    const TABLE = 'vymodule_client';

    public $id;
    public $first_name;
    public $last_name;
    public $email;


    public static $definition = [
        'table' => self::TABLE,
        'primary' => 'id',
        'multilang' => false,
        'multilang_shop' => true,
        'fields' => [
            'first_name' => [
                'type' => self::TYPE_STRING,
                'required' => true,
                'validate' => 'isCleanHtml',
                'size' => 255
            ],
            'last_name' => [
                'type' => self::TYPE_STRING,
                'required' => true,
                'validate' => 'isCleanHtml',
                'size' => 255
            ],
            'email' => [
                'type' => self::TYPE_STRING,
                'required' => true,
                'validate' => 'isCleanHtml',
                'size' => 255
            ],
        ],
    ];

    public static function getClients()
    {
        $sql = 'SELECT * FROM ' . _DB_PREFIX_ . self::TABLE;

        return Db::getInstance()->ExecuteS($sql);
    }
}
