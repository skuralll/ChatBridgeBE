<?php

namespace chatbridge\provider;

class SettingProvider extends Provider
{

    const PROVIDER_ID = "setting";
    /*ファイル名(拡張子はなし)*/
    const FILE_NAME = "setting";
    /*セーブデータのバージョン*/
    const VERSION = 1;
    /*デフォルトデータ*/
    const DATA_DEFAULT = [
    						"URL" => "",
                            "Sync_Interval" => 20
    					];

    public function getURL()
    {
        return $this->data["URL"];
    }

    public function getSyncInterval()
    {
        return $this->data["Sync_Interval"];
    }

}