<?php

Config::write('db.host', '127.0.0.11');
Config::write('db.sqlite', 'db.sqlite');
Config::write('db.port', '5432');
Config::write('db.basename', 'UHSd83djs');
Config::write('db.user', 'UHSd83djs');
Config::write('db.password', 'UHSd83djs');
Config::write('db.table', 'translate');
Config::write('words.input', 'ENG_words.txt');
Config::write('translate.key', 'trnsl.1.1.20140725T045620Z.4b0ba6038be6185f.f217e8285f349aa5eb4adbf0a60d8943785e8179');

class Config
{
    static $confArray;

    public static function read($name)
    {
        return self::$confArray[$name];
    }

    public static function write($name, $value)
    {
        self::$confArray[$name] = $value;
    }

}