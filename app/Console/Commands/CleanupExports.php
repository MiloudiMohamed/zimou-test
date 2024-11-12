<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class CleanupExports extends Command
{
    protected $signature = 'app:cleanup-exports';

    protected $description = 'Delete export files directory';

    public function handle()
    {
        $files = Storage::files('exports');

        foreach ($files as $file) {
            if (basename($file)[0] === '.') {
                continue;
            }

            Storage::delete($file);
        }
    }
}
