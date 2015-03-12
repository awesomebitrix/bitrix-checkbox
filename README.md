# Установка #

В компоновщик нужно добавить

```
#!json
    "repositories": [
        {
            "type": "vcs",
            "url": "https://devel59@bitbucket.org/devel59/bitrix-checkbox.git"
        }
    ],
    "require": {
        "devel59/bitrix-checkbox": "*"
    }
```
В файл **bitrix/php_interface/init.php** нужно добавить

```
#!php
<?php
use Bitrix\Main\EventManager;
use Devel59\Bitrix\Iblock\Property\CheckboxProperty;

require_once __DIR__ . '<путь до корня компоновщика>/vendor/autoload.php';

$eventMgr = EventManager::getInstance();
CheckboxProperty::addInEvent($eventMgr);
```