<?php

namespace App\Repositories\Contracts;

interface PromoCodeRepositoryInterface
{
    public function getAllPromoCode();

    public function findByCode($code);
}
