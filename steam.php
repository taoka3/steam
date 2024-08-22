<?php
require 'config.php';

class steam
{

    public $result;

    public function getOwnedGames($urls = 'http://api.steampowered.com/IPlayerService/GetOwnedGames/v1/?')
    {
        $params = http_build_query([
            'key'=>APIKEY,
            'steamid'=>STEAMID,
            'include_appinfo'=>1,
            'include_played_free_games'=>0,
            //'appids_filter'=>''
        ]);
         $this->result = file_get_contents($urls.$params,true);
         return $this;
    }

    public function viewOwnedGames()
    {
        $data = json_decode($this->result);
        
        foreach($data->response->games as $val){
            $tumiGames = (int)$val->playtime_forever === 0?' [積みゲー]':'';
            printf('ゲーム名：%s プレイ時間：%02d時%02d分%s<br>',$val->name,(int)($val->playtime_forever / 60),(int)($val->playtime_forever % 60),$tumiGames);
        }
        return $this;
    }
}

(new steam)->getOwnedGames()->viewOwnedGames();

    
