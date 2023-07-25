<?php

namespace App\Console\Commands;

use App\MyCrms\CRM;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class generateCommand extends Command implements CRM
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:view {viewName} {--subFolder=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $crmPath = $this->basePath();
        $viewPath = resource_path('views');

        $viewName = $this->argument('viewName');
        $subFolder = $this->option('subFolder');

        if ($subFolder) {
            $viewPath .= '/' . $subFolder;
            if (!File::exists($viewPath)) {
                File::makeDirectory($viewPath, 0755, true);
            }
        }
        $absolutePath = $viewPath . '/' . $viewName .'.blade.php';
        if (File::exists($absolutePath)) {
            $this->info("file already existed in {$absolutePath}");
            exit();
        }
        $crmFileContent = File::get($crmPath);
        File::put($absolutePath, $crmFileContent);
        $this->info("file created successfully");
    }

    public function basePath(): string
    {
        return app_path('MyCrms/baseView.stub');
    }
}
