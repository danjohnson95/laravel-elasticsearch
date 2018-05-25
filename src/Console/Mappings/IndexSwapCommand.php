<?php

namespace DesignMyNight\Elasticsearch\Console\Mappings;

use DesignMyNight\Elasticsearch\Console\Mappings\Traits\HasHost;
use DesignMyNight\Elasticsearch\Console\Mappings\Traits\UpdatesAlias;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

/**
 * Class IndexSwapCommand
 *
 * @package DesignMyNight\Elasticsearch\Console\Mappings
 */
class IndexSwapCommand extends Command
{

    use HasHost;
    use UpdatesAlias;

    /** @var Client $client */
    protected $client;

    /** @var string $description */
    protected $description = 'Swap Elasticsearch alias';

    /** @var string $signature */
    protected $signature = 'index:swap {alias : Name of alias to be updated.} {index : Name of index to be updated to.} {old-index? : Name of current index.} {--R|remove-old-index : Deletes the old index.}';

    /**
     * IndexSwapCommand constructor.
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        parent::__construct();

        $this->client = $client;
        $this->host = $this->getHost();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        ['alias' => $alias, 'index' => $index, 'old-index' => $oldIndex] = $this->arguments();

        $this->updateAlias($index, $alias, $oldIndex, $this->option('remove-old-index'));
    }
}