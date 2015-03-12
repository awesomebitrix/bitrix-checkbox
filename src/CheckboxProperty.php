<?php
namespace Devel59\Bitrix\Iblock\Property;

use Bitrix\Main\EventManager;

/**
 * Флаг/переключатель
 */
class CheckboxProperty {
    /**
     * Добавление обработчика к событию
     *
     * @param EventManager $eventManager
     * @return void
     */
    public static function addInEvent(EventManager $eventManager) {
        $calledClass = get_called_class();
        $eventManager->addEventHandler(
            'iblock',
            'OnIBlockPropertyBuildList',
            $calledClass . '::GetUserTypeDescription',
            false,
            100
        );
    }

    /**
     * Описание свойства
     *
     * @return array
     */
    public static function GetUserTypeDescription() {
        $calledClass = get_called_class();

        return [
            'PROPERTY_TYPE' => 'N',
            'USER_TYPE' => 'Checkbox',
            'DESCRIPTION' => 'Флаг/переключатель',
            'CheckFields' => $calledClass . '::CheckFields',
            'ConvertToDB' => $calledClass . '::ConvertToDB',
            'ConvertFromDB' => $calledClass . '::ConvertFromDB',
            'GetPropertyFieldHtml' => $calledClass . '::GetPropertyFieldHtml'
        ];
    }

    /**
     * Отображение в форме редактирования
     *
     * @param array $info
     * @param array $data
     * @param array $htmlInfo
     * @return mixed
     */
    public static function GetPropertyFieldHtml(array $info, array $data, array $htmlInfo) {
        $html = '
            <input type="hidden" value="0" name="#html_name#">
            <input type="checkbox" value="1" name="#html_name#" #checked#>
        ';
        $checked = ((int)$data['VALUE'] === 1);
        $checkedText = ($checked ? 'checked' : '');

        return str_replace(
            ['#html_name#', '#checked#'],
            [$htmlInfo['VALUE'], $checkedText],
            $html
        );
    }

    /**
     * Проверка значения
     *
     * @param array $info
     * @param array $data
     * @return array
     */
    public static function CheckFields(array $info, array $data) {
        $errors = [];

        if ($info['ID'] > 0) {
            $rawVal = $data['VALUE'];
            $validVals = [0, 1];
            if (is_numeric($rawVal)) {
                $val = (int)$rawVal;
                if (!in_array($val, $validVals, true)) {
                    $errors[] = 'Значением можно указать: ' . implode(', ', $validVals);
                }
            } else {
                $errors[] = 'Нужно указать число (возможные значения: ' . implode(', ', $validVals) . ')';
            }
        }

        return $errors;
    }

    /**
     * Сохранение в БД
     *
     * @param array $info
     * @param array $data
     * @return int
     */
    public static function ConvertToDB(array $info, array $data) {
        $data['VALUE'] = (int)((bool)$data['VALUE']);

        return $data;
    }

    /**
     * Извлечение из БД
     *
     * @param array $info
     * @param array $data
     * @return array
     */
    public static function ConvertFromDB(array $info, array $data) {
        $data['VALUE'] = (int)((bool)$data['VALUE']);

        return $data;
    }
}