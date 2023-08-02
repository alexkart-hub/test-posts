<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

global $APPLICATION;

$APPLICATION->SetPageProperty("title", "Посты");
$APPLICATION->SetTitle("Посты");

$APPLICATION->IncludeComponent('tp:posts', '');

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");