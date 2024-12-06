<?php

namespace BaseEmpds\Model\Utils;

/**
 * Classe de auxílio para funções relacionadas ao Ip 
 * @since 17/08/2022
 * @author Augusto e Gabriel
 */
class IpUtils
{
    /**
     * Get User remote Ip
     * @return string
     */
    public static function getRemoteIp()
    {
        // Check for shared Internet/ISP IP
        if (isset($_SERVER['HTTP_CLIENT_IP']) && !empty($_SERVER['HTTP_CLIENT_IP']) && static::isValidRemoteIp($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        }

        // Check for IP addresses passing through proxies
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && !empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            // Check if multiple IP addresses exist in var
            if (strpos($_SERVER['HTTP_X_FORWARDED_FOR'], ',') !== false) {
                $iplist = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
                foreach ($iplist as $ip) {
                    if (static::isValidRemoteIp($ip)) {
                        return $ip;
                    }
                }
            } else {
                if (static::isValidRemoteIp($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                    return $_SERVER['HTTP_X_FORWARDED_FOR'];
                }
            }
        }

        // Return unreliable IP address since all else failed
        return (isset($_SERVER['REMOTE_ADDR'])) ? $_SERVER['REMOTE_ADDR'] : '';
    }

    /**
     * Is Valid Remote IP - Not 10.*.*.* and 192.*.*.* network
     *
     * @param [type] $ip
     * @return boolean
     */
    private static function isValidRemoteIp($ip)
    {
        if (strtolower($ip) === 'unknown') {
            return false;
        }
        return (bool) filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE);
    }
}
