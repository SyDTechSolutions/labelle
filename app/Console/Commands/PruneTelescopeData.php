<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PruneTelescopeData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'telescope:prune-custom {--hours=168 : The number of hours to retain Telescope data}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Prune stale Telescope entries, keeping exceptions and 500+ errors indefinitely';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $hours = (int) $this->option('hours');
        $this->info("Pruning Telescope entries older than {$hours} hours...");

        $cutoff = Carbon::now()->subHours($hours);

        // Primero, obtener los UUIDs que queremos MANTENER (excepciones y errores 500+)
        $keepUuids = DB::table('telescope_entries')
            ->where('created_at', '<', $cutoff)
            ->where(function ($query) {
                $query->where('type', 'exception')
                    ->orWhere(function ($subQuery) {
                        $subQuery->where('type', 'request')
                            ->whereRaw("JSON_EXTRACT(content, '$.response_status') >= 500");
                    });
            })
            ->pluck('uuid')
            ->toArray();

        $this->info('Keeping ' . count($keepUuids) . ' entries (exceptions and 500+ errors)...');

        // Ahora eliminar entradas antiguas que NO estén en la lista de mantener
        $query = DB::table('telescope_entries')
            ->where('created_at', '<', $cutoff);

        if (!empty($keepUuids)) {
            $query->whereNotIn('uuid', $keepUuids);
        }

        $deleted = $query->delete();

        // Eliminar entradas relacionadas huérfanas de otras tablas
        $this->pruneOrphanedEntries();

        $this->info("Pruned {$deleted} Telescope entries.");
        $this->info('Exceptions and 500+ errors have been preserved indefinitely.');

        return 0;
    }

    /**
     * Eliminar entradas huérfanas de las tablas relacionadas
     */
    protected function pruneOrphanedEntries()
    {
        $tables = [
            'telescope_entries_tags' => 'entry_uuid',
            'telescope_monitoring' => 'tag',
        ];

        foreach ($tables as $table => $column) {
            if (DB::getSchemaBuilder()->hasTable($table)) {
                // Obtener UUIDs válidos
                $validUuids = DB::table('telescope_entries')->pluck('uuid')->toArray();
                
                if (!empty($validUuids)) {
                    DB::table($table)
                        ->whereNotIn($column, $validUuids)
                        ->delete();
                }
            }
        }
    }
}
