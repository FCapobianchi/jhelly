<?php

declare(strict_types=1);

namespace App\Core;

use Nette\Utils\ArrayHash;

/**
 * mDNSDiscoveryService
 * Scopre tutti i dispositivi mDNS sulla rete usando Avahi
 * Richiede: avahi-daemon e avahi-utils installati
 * Comando base: avahi-browse -a -r -p
 */

class mDNSDiscoveryService {
    
    public function getDevices():ArrayHash {
        $command = 'timeout 5 avahi-browse -a -r -p 2>/dev/null'; // formato parsabile (-p)
        $output = shell_exec($command);

        // Ogni riga è un record Avahi nel formato 'flag;iface;proto;name;type;domain;host;ip;port;txt'
        $lines = explode("\n", trim($output));
        $devices = [];
        foreach ($lines as $line) {
            // Salta righe vuote o non valide
            if (empty($line) || strpos($line, ';') === false) {continue;}
            $parts = explode(';', $line);
            // Formato previsto: flag;iface;proto;name;type;domain;host;address;port;txt
            // =;eth0;IPv4;shellyswitch25-349454793BA5;Sito Web;local;shellyswitch25-349454793BA5.local;192.168.1.109;80;"discoverable=false" "fw_id=20230913-112234/v1.14.0-gcb84623" "fw_version=1.0" "app=switch25" "arch=esp8266" "id=shellyswitch25-349454793BA5"

            if (count($parts) >= 9) {
                $devices[] = [
                    'interface' => $parts[1]??'',
                    'protocol'  => $parts[2]??'',
                    'name'      => $parts[3]??'',
                    'service'   => $parts[4]??'',
                    'domain'    => $parts[5]??'',
                    'host'      => $parts[6]??'',
                    'ip'        => $parts[7]??'',
                    'port'      => $parts[8]??'',
                    'part9'     => $parts[9]??'',
                    'part10'     => $parts[10]??'',
                    'part11'     => $parts[11]??'',
                    'part12'     => $parts[12]??'',
                    'part13'     => $parts[13]??'',
                    'part14'     => $parts[14]??'',
                    'part15'     => $parts[15]??'',
                ];
            }
        }

        return ArrayHash::from($devices);
    }
    
}