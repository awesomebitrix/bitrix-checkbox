# Установка #

В компоновщик **composer.json** нужно добавить

```
#!json
{
// ...
    "require": {
        "devel59/bitrix-checkbox": "dev-master"
    }
// ...
}
```
В файл **bitrix/php_interface/init.php** нужно добавить

```
#!php
<?php
use Bitrix\Main\EventManager;
use Devel59\Bitrix\Iblock\Property\CheckboxProperty;

require_once __DIR__ . '<путь до корня проекта>/vendor/autoload.php';

$eventMgr = EventManager::getInstance();
CheckboxProperty::subscribeToBuildList($eventMgr);
```

# Использование #

Значением свойства можно указывать 0, 1, true, false, '0', '1', например:

```
#!php
<?php
use Bitrix\Main\Loader;

Loader::includeModule('iblock');

$ibElemMgr = new CIBlockElement();
$ibElemMgr->Add(
    [
        // ...
        'PROPERTY_VALUES' => [
            'checkbox' => '1' // или 1, или true
        ]
        // ...
    ]
);
```