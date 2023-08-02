<?php
/**
 * @var array $arResult
 * @var array $arParams
 * @var CUser $USER
 */
$admin = $USER->IsAdmin();
?>
<div class="news-list">
    <?php foreach($arResult["ITEMS"] as $arItem):?>
	<p class="news-item">
        <b><?php echo $arItem["NAME"]?></b><br>
	</p>
    <?php endforeach;?>
</div>
