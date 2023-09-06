<?php

if (!check_bitrix_sessid()) {
    return;
}

## -- Add CIBlockType 

$arFields = [
	'ID' => gpn_do::IBLOCK_TYPE,
	'SECTIONS' => 'N',
	'IN_RSS' => 'N',
	'SORT' => 100,
	'LANG' => [
		'en'=> [
			'NAME'=>'GPN Dispatchers-Objects',
			'ELEMENT_NAME'=>'GPN Dispatchers/Objects',
        ],
        'ru'=>[
			'NAME'=>'ГПН Диспетчеры-Объекты',
			'ELEMENT_NAME'=>'ГПН Диспетчер/Объект',
        ],
    ],
];

$obBlocktype = new CIBlockType;
$DB->StartTransaction();
$res = $obBlocktype->Add($arFields);
if(!$res)
{
    $DB->Rollback();
    echo CAdminMessage::ShowNote('Error:', $obBlocktype->LAST_ERROR);
} else {
    $DB->Commit();
    echo CAdminMessage::ShowNote('Тип инфоблока "'.gpn_do::IBLOCK_TYPE.'" создан');
}


## -- Add CIBlock

$LID = false;
$rsSites = CSite::GetList($by="active", $order="asc", ["ACTIVE" => "Y"]);
while ($arSite = $rsSites->Fetch())
{
    $LID = $arSite['LID'];
    break;
}

if ( $LID ) {

    $ib = new CIBlock;
    $arFields = [
        "ACTIVE" => 'Y',
        "NAME" => 'Диспетчеры',
        "CODE" => gpn_do::IBLOCK_DISPATCHERS,
        "LIST_PAGE_URL" => '/..list.d../',
        "DETAIL_PAGE_URL" => '/..detail.d../',
        "IBLOCK_TYPE_ID" => gpn_do::IBLOCK_TYPE,
        "SITE_ID" => [$LID],
        "SORT" => 100,
        "DESCRIPTION" => '',
        "DESCRIPTION_TYPE" => 'text',
        "GROUP_ID" => [ "1" => "X" ],
    ];
    $ib->Add($arFields);
    echo CAdminMessage::ShowNote('Инфоблок "'.gpn_do::IBLOCK_DISPATCHERS.'" создан');

    $ib = new CIBlock;
    $arFields = [
        "ACTIVE" => 'Y',
        "NAME" => 'Объекты',
        "CODE" => gpn_do::IBLOCK_OBJECTS,
        "LIST_PAGE_URL" => '/..list.o../',
        "DETAIL_PAGE_URL" => '/..detail.o../',
        "IBLOCK_TYPE_ID" => gpn_do::IBLOCK_TYPE,
        "SITE_ID" => [$LID],
        "SORT" => 200,
        "DESCRIPTION" => '',
        "DESCRIPTION_TYPE" => 'text',
        "GROUP_ID" => [ "1" => "X" ],
    ];
    $ib->Add($arFields);
    echo CAdminMessage::ShowNote('Инфоблок "'.gpn_do::IBLOCK_OBJECTS.'" создан');

}

echo CAdminMessage::ShowNote(GetMessage('GP_DISPATCHERS_INSTALL_OK'));

?>