<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateModules extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'modules:update-composer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Modules Composer Update';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get the modules configuration
        $modules = config('module.modules');
        $mainComposerJson = base_path('composer.json');
        $mainComposerData = json_decode(file_get_contents($mainComposerJson), true);

        // Iterate over the modules and check if they are enabled
        foreach ($modules as $module => $enabled) {
            if ($enabled) {  // Only process if the module is enabled
                $moduleComposerJson = base_path("Modules/{$module}/composer.json");
                if (file_exists($moduleComposerJson)) {
                    $moduleComposerData = json_decode(file_get_contents($moduleComposerJson), true);
                    
                    // Merge module's require section into the main composer.json require section
                    if (isset($moduleComposerData['require'])) {
                        $mainComposerData['require'] = array_merge(
                            $mainComposerData['require'],
                            $moduleComposerData['require']
                        );
                    }
                }
            }
        }

        // Save the updated composer.json back to the main composer.json file
        file_put_contents($mainComposerJson, json_encode($mainComposerData, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        // Output a message to the console and run composer update
        $this->info('Composer updated with enabled modules dependencies.');
        shell_exec('composer update');
    }
}
