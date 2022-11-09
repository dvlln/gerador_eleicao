<?php

namespace App\Services;

use App\Models\{Eleicao, User};

class EleicaoService{
    public static function userSubscribedOnEleicao(User $users, Eleicao $eleicao){
        return $eleicao->users()->where('user_id', $users->id)->exists();
    }

    public static function eleicaoStartDateHasPassed(Eleicao $eleicao){
        return $eleicao->start_date_eleicao < now();
    }

    public static function eleicaoEndDateHasPassed(Eleicao $eleicao){
        return $eleicao->end_date_eleicao < now();
    }

    public static function inscricaoStartDateHasPassed(Eleicao $eleicao){
        return $eleicao->start_date_inscricao < now();
    }

    public static function inscricaoEndDateHasPassed(Eleicao $eleicao){
        return $eleicao->end_date_inscricao < now();
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
