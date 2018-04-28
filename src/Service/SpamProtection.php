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
    public $spamWords = [
        'viagra',
        'script',
        'href'
    ];
    public function validateUserInputs(array $data) {
        // Validate ip
        if(!$this->validateIp($data['ip'])) {
            return false;
        }

        // Validate email
        if(!$this->validateEmail($data['email'])) {
            return false;
        }

        // Validate message
        if(!$this->validateMessage($data['message'])) {
            return false;
        }

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

    protected function validateEmail(string $email) {
        if($email === '') {
            return false;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
           return false;
        }

        return true;
    }

    protected function validateMessage(string $message) {
        if($message === '') {
            return false;
        }

        $message = strtolower($message);
        foreach ($this->spamWords as $spamWord) {
            if (strpos($message, $spamWord) !== false) {
                return false;
            }
        }

        return true;
    }


}