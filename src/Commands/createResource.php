<?php

namespace marcusvbda\vstack\Commands;

use Illuminate\Console\Command;

class createResource extends Command
{
    protected $signature = 'vstack:make-resource {resource} {model} {table}';
    public function __construct()
    {
        parent::__construct();
    }
    public function handle()
    {
        $data = $this->arguments();
        $resource = $data["resource"];
        $table = $data["table"];
        $model = $data["model"];
        $totalSteps = 2;
        $bar = $this->output->createProgressBar($totalSteps);
        $this->createModel($bar, $table, $model);
        $this->createResource($bar, $resource, $table, $model);
        $bar->finish();
    }

    private function createResource($bar, $resource, $table, $model)
    {
        $bar->start();
        $dir = app_path("/Http/Resources");
        $resource_path = $dir . "/" . $resource . ".php";
        $content = file_get_contents(base_path("vendor/marcusvbda/vstack/src/Commands/examples/_new_resource_.example"));
        $content = preg_replace('/\_RESOURCE_NAME_\b/', $resource, $content);
        $content = preg_replace('/\_MODEL_\b/', '\App\Http\Models\\' . $model . '::class', $content);
        $this->makeDir($dir);
        file_put_contents($resource_path, $content);
        $bar->advance();
        echo "\ncreated resource $resource_path.php\n";
    }

    private function createModel($bar, $table, $model)
    {
        $bar->start();
        $dir = app_path("/Http/Models");
        $model_path = $dir . "/" . $model . ".php";
        $content = file_get_contents(base_path("vendor/marcusvbda/vstack/src/Commands/examples/_new_model_.example"));
        $content = preg_replace('/\_MODEL_NAME\b/', $model, $content);
        $content = preg_replace('/\_TABLE_NAME__\b/', $table, $content);
        $this->makeDir($dir);
        file_put_contents($model_path, $content);
        $bar->advance();
        echo "\ncreated model $model_path.php\n";
    }

    private function makeDir($dir)
    {
        if (!is_dir($dir)) mkdir($dir, 777, true);
    }
}
