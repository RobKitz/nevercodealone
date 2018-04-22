<?php
/**
 * Created by PhpStorm.
 * User: rocket
 * Date: 22.04.18
 * Time: 01:28
 */

namespace App\Service;


class SpamProtection
{
    public function validateUserInputs(array $data) {
        // Validate IP
        if(!$this->validateIp($data['ip'])) {
            return false;
        }

        // Validate post limit

        // Validate message

        // Validate Email

        return true;
    }

    private function validateIp(string $ip)
    {
        if(!filter_var($ip, FILTER_VALIDATE_IP)) {
            return false;
        }

        // Europe
        return true;

    }

}