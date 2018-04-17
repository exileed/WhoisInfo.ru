<?php


namespace App;

class Whois
{

    /**
     * @var array
     */
    private $domain_list;

    private $whois_servers = [
        //"whois.afrinic.net", // Africa - returns timeout error :-(
        "whois.lacnic.net", // Latin America and Caribbean - returns data for ALL locations worldwide :-)
        "whois.apnic.net", // Asia/Pacific only
        "whois.arin.net", // North America only
        "whois.ripe.net" // Europe, Middle East and Central Asia only
    ];

    public function __construct(array $domain_list = null)
    {

        $this->domain_list = $domain_list;

    }

    /**
     * @param $domain
     *
     * @return string
     */
    public function domain($domain)
    {
        $domain_parts = explode(".", $domain);
        $tld          = strtolower(array_pop($domain_parts));
        $whois_server = $this->domain_list[ $tld ];
        if ( ! $whois_server) {
            return "У домена $domain - не существует Whois-сервера! Запрос отклонён.";
        }
        $result = $this->request($whois_server, $domain);
        if ( ! $result) {
            return "Не было получено результатов из $whois_server для домена: $domain!";
        }

        while (strpos($result, "Whois Server:") !== false) {
            preg_match("/Whois Server: (.*)/", $result, $matches);
            $secondary = $matches[ 1 ];
            if ($secondary) {
                $result       = $this->request($secondary, $domain);
                $whois_server = $secondary;
            }
        }

        return "Результаты проверки Whois-сервера ($whois_server):\n\n" . $result;

    }

    /**
     * @param $whois_server
     * @param $domain
     *
     * @return string
     */
    private function request($whois_server, $domain)
    {

        $port    = 43;
        $timeout = 10;
        $fp = @fsockopen($whois_server, $port, $errno, $errstr,
            $timeout) or die("Socket Error " . $errno . " - " . $errstr);
        //if($whoisserver == "whois.verisign-grs.com") $domain = "=".$domain; // whois.verisign-grs.com requires the equals sign ("=") or it returns any result containing the searched string.
        fputs($fp, $domain . "\r\n");
        $out = "";
        while ( ! feof($fp)) {
            $out .= fgets($fp);
        }
        fclose($fp);

        $res = "";
        if ((strpos(strtolower($out), "error") === false) && (strpos(strtolower($out), "not allocated") === false)) {
            $rows = explode("\n", $out);
            foreach ($rows as $row) {
                $row = trim($row);
                if (($row != '') && ($row{0} != '#') && ($row{0} != '%')) {
                    $res .= $row . "\n";
                }
            }
        }

        return $res;
    }

    /**
     * @param $ip
     *
     * @return string
     */
    public function ip($ip)
    {

        $results = [];
        foreach ($this->whois_servers as $whois_server) {
            $result = $this->request($whois_server, $ip);
            if ($result && ! in_array($result, $results)) {
                $results[ $whois_server ] = $result;
            }
        }
        $res = "Найдено результатов: " . count($results);
        foreach ($results as $whois_server => $result) {
            $res .= "\n\n-------------\nРезультаты для " . $ip . " из " . $whois_server . ":\n\n" . $result;
        }

        return $res;
    }

}