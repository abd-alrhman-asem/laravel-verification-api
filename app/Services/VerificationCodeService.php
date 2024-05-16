<?php

namespace App\Services;

use Illuminate\Support\Str;

class VerificationCodeService
{
    public function generate(): string
    {
        $numbers = '0123456789';
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $numberLength = strlen($numbers);
        $randomChar = '';
        $randomNumber = '';
        for ($i = 0; $i < 6; $i++) {
            if ($i == 1 || $i == 5)
                $randomNumber .= $numbers[rand(0, $numberLength - 1)];
            else
            $randomChar .= $characters[rand(0, $charactersLength - 1)];
        }
        return str_shuffle($randomChar. $randomNumber  );
    }
}
