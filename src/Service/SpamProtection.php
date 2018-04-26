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

        //@todo Validate post limit

        // Validate message

        // Validate Email

        return true;
    }

    protected function validateIp(string $ip)
    {
        if(!filter_var($ip, FILTER_VALIDATE_IP)) {
            return false;
        }

        if(strpos($ip, '192') !== false) {
            return false;
        }

        // Europe
        if(!$this->isIpFromDe($ip)) {
            return false;
        }

        return true;

    }

    protected function isIpFromDe(string $ip) {
        $url = 'https://ipinfo.io/' . $ip;

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $data = json_decode(curl_exec($curl), true);
        curl_close($curl);

        return $data['country'] === 'DE';
    }

}