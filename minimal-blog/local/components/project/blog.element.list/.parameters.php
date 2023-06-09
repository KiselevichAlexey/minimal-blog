<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use App\Helpers\ParametersComponent;
use Bitrix\Main;
use Bitrix\Main\Localization\Loc as Loc;

/** @var array $arCurrentValues */

Loc::loadMessages(__FILE__);

try {
    if (!Main\Loader::includeModule('iblock')) {
        throw new Main\LoaderException(Loc::getMessage('BLOG_LIST_PARAMETERS_IBLOCK_MODULE_NOT_INSTALLED'));
    }

    $iblockTypes = CIBlockParameters::GetIBlockTypes(["-" => " "]);
    $iblocks = ParametersComponent::getIblocks($arCurrentValues['IBLOCK_TYPE']);
    $sections = ParametersComponent::getSections($arCurrentValues['IBLOCK_TYPE'], $arCurrentValues['IBLOCK_CODE']);

    $arComponentParameters = [
        'GROUPS' => [
        ],
        'PARAMETERS' => [
            'CACHE_TIME' => [
                'DEFAULT' => 3600,
            ],
        ],
    ];

    ParametersComponent::insertIblockTypeInParameters($arComponentParameters, $iblockTypes);
    ParametersComponent::insertIblockCodeInParameters($arComponentParameters, $iblocks['CODES']);
    ParametersComponent::insertIblocSectionInParameters($arComponentParameters, $sections);
    ParametersComponent::insertShowNavInParameters($arComponentParameters);
    ParametersComponent::insertCountInParameters($arComponentParameters);
    ParametersComponent::insertSortInParameters($arComponentParameters);
    CIBlockParameters::AddPagerSettings($arComponentParameters,'Навигация');
} catch (Main\LoaderException $e) {
    ShowError($e->getMessage());
}
