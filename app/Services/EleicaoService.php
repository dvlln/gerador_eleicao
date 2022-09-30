<?php

namespace App\Services;

use App\Models\{Eleicao, User};

class EleicaoService{
    public static function userSubscribedOnEleicao(User $user, Eleicao $eleicao){
        return $eleicao->users()->where('id', $user->id)->exists();
    }
    
    public static function eleicaoStartDateHasPassed(Eleicao $eleicao){
        return $eleicao->startDate < now();
    }

    public static function eleicaoEndDateHasPassed(Eleicao $eleicao){
        return $eleicao->endDate < now();
    }
}
?>