<?php

use Bitrix\Highloadblock\HighloadBlockTable;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\SystemException;

class PostsComponent extends \CBitrixComponent
{
    const CACHE_TIME_DEFAULT = 3600;

    public function executeComponent()
    {
        try{
            $this->checkModules();
            $this->getResult();
        } catch (SystemException $exception) {
            ShowError($exception->getMessage());
        }
        $this->includeComponentTemplate();
    }

    public function onPrepareComponentParams($arParams)
    {
        if (!isset($arParams['CACHE_TIME'])) {
            $arParams['CACHE_TIME'] = self::CACHE_TIME_DEFAULT;
        } else {
            $arParams['CACHE_TIME'] = intval($arParams['CACHE_TIME']);
        }
        return $arParams;
    }

    protected function checkModules()
    {
        if (!\Bitrix\Main\Loader::includeModule('highloadblock')) {
            throw new SystemException(Loc::getMessage('HIGHLOAD_MODULE_NOT_INSTALL'));
        }
    }

    protected function getResult()
    {
        if ($this->startResultCache()) {
            $hlId = HighloadBlockTable::getList([
                'select' => ["ID"],
                'filter' => ["=NAME" => 'Posts'],
            ])->fetch()['ID'];
            $hlBlock = HighloadBlockTable::getById($hlId)->fetch();
            $hlEntity = HighloadBlockTable::compileEntity($hlBlock);
            $hlClass = $hlEntity->getDataClass();

            $pageCount = $this->arParams['PAGE_COUNT'] ?? 5;
            $offset = isset($this->arParams['PAGE_NUM']) ? $pageCount * (intval($this->arParams['PAGE_NUM']) - 1) : 0;
            $dbData = $hlClass::getList([
                'limit' => $pageCount,
                'offset' => $offset
            ]);
            while ($res = $dbData->fetch()) {
                $this->arResult['ITEMS'][] = $res;
            }
            if (!empty($this->arResult)) {
                $this->setResultCacheKeys([]);
            }
        }
    }
}