<?php

if (!check_bitrix_sessid()) {
    return;
}

function delete_IBlock( $iblock_item )
{
    global $DB;
    $DB->StartTransaction();
    if(!CIBlock::Delete($iblock_item['ID']))
    {
        $DB->Rollback();
        echo CAdminMessage::ShowMessage([
            'MESSAGE'=>"Error: Delete iblock {$iblock_item['ID']} {$iblock_item['CODE']} error.",
            'TYPE'=>'ERROR',
        ]);
    } else {
        echo CAdminMessage::ShowNote("Инфоблок \"{$iblock_item['ID']}:{$iblock_item['CODE']}\" удалён");
        $DB->Commit();
    }
}

if($USER->IsAdmin())
{
    
    $res = CIBlock::GetList([],['CODE'=>gpn_do::IBLOCK_DISPATCHERS],false);
    while($iblock_item = $res->Fetch())
    {
        delete_IBlock($iblock_item);
    }
    $res = CIBlock::GetList([],['CODE'=>gpn_do::IBLOCK_OBJECTS],false);
    while($iblock_item = $res->Fetch())
    {
        delete_IBlock($iblock_item);
    }

    $DB->StartTransaction();
    if(!CIBlockType::Delete(gpn_do::IBLOCK_TYPE))
    {
        $DB->Rollback();
        echo CAdminMessage::ShowMessage(['MESSAGE'=>'Error: Delete iblock_type '.gpn_do::IBLOCK_TYPE.' error.', 'TYPE'=>'ERROR']);
    } else {
        echo CAdminMessage::ShowNote('Тип инфоблока "'.gpn_do::IBLOCK_TYPE.'" удалён');
        $DB->Commit();
    }

} else {
    $e = new CAdminException('Только администратор может удалить данные из '.gpn_do::IBLOCK_TYPE.'');
    echo CAdminMessage::ShowNote('Error:', $e);
}

echo CAdminMessage::ShowNote(GetMessage('GP_DISPATCHERS_UNINSTALL_OK'));

?>