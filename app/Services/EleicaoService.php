<?php

namespace App\Services;

use App\Models\{Eleicao, User};

class EleicaoService{
    public static function userSubscribedOnEleicao($users, Eleicao $eleicao){
        return $eleicao->users()->where('user_id', $users)->exists();
    }

    //--------------------------------------------------------------------------------

    public static function beforeInscricao(Eleicao $eleicao){
        return $eleicao->start_date_inscricao > now();
    }

    public static function duringInscricao(Eleicao $eleicao){
        return ($eleicao->start_date_inscricao < now()) && ($eleicao->end_date_inscricao > now());
    }

    public static function afterInscricao(Eleicao $eleicao){
        return $eleicao->end_date_inscricao < now();
    }

    public static function beforeDepuracao(Eleicao $eleicao){
        return $eleicao->start_date_depuracao > now();
    }

    public static function duringDepuracao(Eleicao $eleicao){
        return ($eleicao->start_date_depuracao < now()) && ($eleicao->end_date_depuracao > now());
    }

    public static function afterDepuracao(Eleicao $eleicao){
        return $eleicao->end_date_depuracao < now();
    }

    public static function beforeEleicao(Eleicao $eleicao){
        return $eleicao->start_date_eleicao > now();
    }

    public static function duringEleicao(Eleicao $eleicao){
        return ($eleicao->start_date_eleicao < now()) && ($eleicao->end_date_eleicao > now());
    }

    public static function afterEleicao(Eleicao $eleicao){
        return $eleicao->end_date_eleicao < now();
    }
}
?>
