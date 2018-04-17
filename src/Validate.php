<?php

namespace App;


class Validate
{


    /**
     * @param $ip
     *
     * @return mixed
     */
    public function isIP($ip)
    {
        return filter_var($ip, FILTER_VALIDATE_IP);
    }


    /**
     * @param $domain
     *
     * @return bool
     */
    public function isDomain($domain)
    {
        if ( ! preg_match("/^([-a-z0-9]{2,100})\.([a-z\.]{2,8})$/i", $domain)) {
            return false;
        }

        return true;
    }


}