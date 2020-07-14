<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class DatabaseBackupCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:backup {--database=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backup database command';

    /**
     * @var process
     */
    protected $process;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $database = $this->option('database');

        switch($database) {
            case 'mysql':
                $this->process = new Process(sprintf(
                    'mysqldump -u%s -p%s %s > %s',
                    config('database.connections.mysql.username'),
                    config('database.connections.mysql.password'),
                    config('database.connections.mysql.database'),
                    storage_path(sprintf('database/backups/mysql/backup_%s.sql', now()->format('Ymd')))
                ));

                break;
            case 'pgsql':
                $this->process = new Process(sprintf(
                    'PGPASSWORD="%s" pg_dump -U %s -p 5432 -h localhost %s >> %s',
                    config('database.connections.pgsql.password'),
                    config('database.connections.pgsql.username'),
                    config('database.connections.pgsql.database'),
                    storage_path(sprintf('database/backups/postgresql/backup_%s.sql', now()->format('Ymd')))
                ));

                break;
            default:
                $this->info('Pilih database (mysql atau pgsql).');
        }

        try {
            $this->info('Backup database segera dimulai.');
            $this->process->mustRun();
            $this->info('Backup database berhasil diproses.');
        } catch (ProcessFailedException $exception) {
            var_dump($exception);
            logger()->error('Backup exception', compact('exception'));
            $this->error('Backup database gagal diproses.');
        }
    }
}
