<?php

namespace App\Console\Commands;

use Cache;
use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;
use Storage;

/**
 * Pulls Tor exit node information.
 *
 * @category   Command
 *
 * @author     Joshua Moon <josh@jaw.sh>
 * @copyright  2016 Infinity Next Development Group
 * @license    http://www.gnu.org/licenses/agpl-3.0.en.html AGPL3
 *
 * @since  0.6.1
 */
class TorPull extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'tor:pull';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pull Tor exit node records.';

    /**
     * The URL we use for looksups.
     *
     * @static
     * @var string
     */
    const LOOKUP_URL = "https://check.torproject.org/cgi-bin/TorBulkExitList.py";

    /**
     * The ports we use for looksups.
     *
     * @var array
     */
    private $ports = ['80', '443', '8080', '8443'];

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Query string parameters
        $query = [
            'ip' => getHostByName(php_uname('n')),
        ];

        $ips = collect();
        foreach ($this->ports as $port)
        {
            $portIps = $this->getPortIps($query, $port);
            if (empty($portIps))
            {
                // Something went wrong, we don't want to update the list.
                return;
            }
            $ips = $ips->merge($portIps);
        }
        $ips = $ips->unique();

        Storage::put('TorExitNodes.ser', $ips);
        Cache::forever('tor-exit-nodes', $ips);
        $this->info("Tor Pull: Recorded the existence of {$ips->count()} Tor exit nodes.");
    }

    /**
     * Gets remote API data for Tor exit nodes.
     *
     * @param array $query
     * @param int $port
     *
     * @return array
     */
    public function getPortIps($query, $port = 80)
    {
        // Pull API response.
        $response = file_get_contents(
            static::LOOKUP_URL
            .'?'
            .http_build_query(
                $query + [
                    'port' => $port,
                ]
            )
        );

        if ($response === false)
        {
            return array();
        }

        $lines = explode("\n", $response);

        // Remove comment rows.
        return array_filter($lines, function($item)
        {
            return strpos($item, '#') === false && strlen($item) > 0;
        });
    }
}
