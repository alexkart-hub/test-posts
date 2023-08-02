<?php

use Arrilot\BitrixMigrations\BaseMigrations\BitrixMigration;
use Arrilot\BitrixMigrations\Exceptions\MigrationException;
use Bitrix\Main\Loader;

class AddHlPosts20230802084959767303 extends BitrixMigration
{
    const NAME = 'Posts';
    const TABLE = 'posts';
    /**
     * Run the migration.
     *
     * @return mixed
     * @throws \Exception
     */
    public function up()
    {
        Loader::includeModule('highloadblock');
        $result = \Bitrix\Highloadblock\HighloadBlockTable::add([
            'NAME' => self::NAME,
            'TABLE_NAME' => self::TABLE,
        ]);
        if (!$result->isSuccess()) {
            throw new MigrationException('Ошибка при добавлении highload блока' . print_r($result->getErrorMessages(), true));
        }
        $hlId = $result->getId();
        $entityId = 'HLBLOCK_' . $hlId;
        $oUserTypeEntity = new CUserTypeEntity();
        $aUserFields = [
            [
                'ENTITY_ID'         => $entityId,
                'FIELD_NAME'        => 'UF_NAME',
                'USER_TYPE_ID'      => 'string',
                'MULTIPLE'          => 'N',
                'MANDATORY'         => 'Y',
                'SHOW_FILTER'       => 'Y',
                'EDIT_FORM_LABEL'   => [
                    'ru'    => 'Название',
                    'en'    => 'Name',
                ],
                'LIST_COLUMN_LABEL' => array(
                    'ru'    => 'Название',
                    'en'    => 'Name',
                ),
                'LIST_FILTER_LABEL' => array(
                    'ru'    => 'Название',
                    'en'    => 'Name',
                ),
            ]        ];
        foreach ($aUserFields as $aUserField) {
            if (!$oUserTypeEntity->Add($aUserField)) {
                throw new MigrationException('Ошибка при добавлении пользовательского свойства' . $aUserField['EDIT_FORM_LABEL']['ru']);
            }
        }
    }

    /**
     * Reverse the migration.
     *
     * @return mixed
     * @throws \Exception
     */
    public function down()
    {
        Loader::includeModule('highloadblock');

        $hlblock = \Bitrix\Highloadblock\HighloadBlockTable::getList(['filter' => ['=NAME' => self::NAME]])->fetch();
        if ($hlblock !== false) {
            $hlId = $hlblock['ID'];

            $oUserTypeEntity = new CUserTypeEntity();
            $oUserTypeEntity->DropEntity('HLBLOCK_' . $hlId);

            $result = \Bitrix\Highloadblock\HighloadBlockTable::delete($hlblock['ID']);
            if (!$result->isSuccess()) {
                throw new MigrationException('Ошибка при удалении highload блока' . print_r($result->getErrorMessages(), true));
            }
        }
    }
}
