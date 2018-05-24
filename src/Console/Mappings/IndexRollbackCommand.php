<?php

namespace DesignMyNight\Elasticsearch\Console\Mappings;

use DesignMyNight\Elasticsearch\Console\Mappings\Traits\HasConnection;
use DesignMyNight\Elasticsearch\Console\Mappings\Traits\UpdatesAlias;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

/**
 * Class IndexRollbackCommand
 * @package DesignMyNight\Elasticsearch\Console\Mappings
 */
class IndexRollbackCommand extends Command
{

    use HasConnection;
    use UpdatesAlias;

    /** @var string $description */
    protected $description = 'Rollback to the previous index';

    /** @var string $signature */
    protected $signature = 'index:rollback';

    /** @var Collection $previousMigrations */
    private $previousMigrations;

    /**
     * IndexRollbackCommand constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->connection = $this->getConnection();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $mappingMigrations = $this->connection->orderBy('mapping')->orderBy('batch')->get();

        if ($mappingMigrations->isEmpty()) {
            $this->info('Nothing to rollback.');

            return;
        }

        $latestBatch = $this->connection->max('batch');
        $mappingMigrations = $this->mapAliases($mappingMigrations);
        $latestMigrations = $mappingMigrations->where('batch', $latestBatch);
        $this->setPreviousMigrations($mappingMigrations->where('batch', $latestBatch - 1));

        foreach ($latestMigrations as $migration) {
            $this->rollback($migration);
        }

        $this->connection->where('batch', $latestBatch)->delete();
        $this->info('Successfully rolled back.');
    }

    /**
     * @param Collection $migrations
     */
    public function setPreviousMigrations(Collection $migrations):void
    {
        $this->previousMigrations = $migrations;
    }

    /**
     * @param Collection $migrations
     *
     * @return Collection
     */
    protected function mapAliases(Collection $migrations):Collection
    {
        return $migrations->map(function (array $mapping):array {
            $mapping['alias'] = $this->stripTimestamp($mapping['mapping']);

            return $mapping;
        });
    }

    /**
     * @param array      $migration
     */
    protected function rollback(array $migration):void
    {
        if ($match = $this->previousMigrations->where('alias', $migration['alias'])->first()) {
            $this->info("Rolling back {$migration['mapping']} to {$match['mapping']}");
            $this->updateAlias($match['alias'], null, $migration['alias']);
            $this->info("Rolled back {$migration['mapping']}");

            return;
        }

        $this->warn("No previous migration found for {$migration['mapping']}. Skipping...");
    }

    /**
     * @param string $mapping
     *
     * @return string
     */
    protected function stripTimestamp(string $mapping):string
    {
        return preg_replace('/[0-9_]+/', '', $mapping, 1);
    }
}