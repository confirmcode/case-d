<?php

IncludeModuleLangFile(__FILE__);

class gpn_do extends CModule
{

    public $MODULE_ID = "gpn_do";
    public $MODULE_NAME;
    public $MODULE_DESCRIPTION;
    public $MODULE_VERSION;
    public $MODULE_VERSION_DATE;

    private $MODULE_PATH;

    const IBLOCK_TYPE = 'gpn_do';
    const IBLOCK_DISPATCHERS = 'gpn_dispatchers';
    const IBLOCK_OBJECTS = 'gpn_objects';

    public function __construct()
    {
        $this->MODULE_PATH = $_SERVER["DOCUMENT_ROOT"]."/local/modules/".$this->MODULE_ID;

		$this->MODULE_NAME = GetMessage("GP_DISPATCHERS_MODULE_NAME");
		$this->MODULE_DESCRIPTION = GetMessage("GP_DISPATCHERS_MODULE_DESC");

        include(__DIR__.'/version.php');

		$this->MODULE_VERSION = $arModuleVersion["VERSION"];
		$this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
    }

    public function InstallDB()
    {
        RegisterModule($this->MODULE_ID);
        return true;
    }

    public function UnInstallDB()
    {
        UnRegisterModule($this->MODULE_ID);
        return true;
    }

    public function InstallEvents()
    {
        return true;
    }

    public function UnInstallEvents()
    {
        return true;
    }

    public function InstallFiles()
    {
        return true;
    }

    public function UnInstallFiles()
    {
        return true;
    }

    public function DoInstall()
    {
        global $DOCUMENT_ROOT, $APPLICATION;
        if (!IsModuleInstalled($this->MODULE_ID))
        {
            $this->InstallFiles();
            $this->InstallDB();
            $this->InstallEvents();
            $APPLICATION->IncludeAdminFile(
                GetMessage("GP_DISPATCHERS_INSTALL_TITLE"), 
                $this->MODULE_PATH."/install/step.php"
            );
        }
    }

    public function DoUninstall()
    {
        global $DOCUMENT_ROOT, $APPLICATION;
        if (IsModuleInstalled($this->MODULE_ID))
        {
            $this->UnInstallFiles();
            $this->UnInstallDB();
            $this->UnInstallEvents();
            $APPLICATION->IncludeAdminFile(
                GetMessage("GP_DISPATCHERS_UNINSTALL_TITLE"), 
                $this->MODULE_PATH."/install/unstep.php"
            );
        }
    }

}
