<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MakeRepositoryCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository {repository} {--model=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try
        {
            if(!is_dir('app/Repositories'))
                mkdir('app/Repositories');

            $content = $this->templateConcret(
                $this->argument('repository'),
                $this->option('model')
            );

            if(file_put_contents("app/Repositories/{$this->argument('repository')}.php", $content)) {
                $this->info('Repository created ' . $this->argument('repository'));
            }

            $content = $this->templateInterface(
                $this->argument('repository'),
                $this->option('model')
            );

            if(file_put_contents("app/Repositories/{$this->argument('repository')}Interface.php", $content)) {
                $this->info('Interface Repository created ' . $this->argument('repository') . 'Interface');
                return;
            }

            $this->error('Error on create repository file');
        } catch (\Exception $e)
        {
            $this->error($e->getMessage());
        }
    }

    private function templateConcret(?string $repositoryName, ?string $modelName): string
    {
        $interface = $repositoryName . 'Interface';

        // if($modelName) 
            return <<<PHP
            <?php

            namespace App\Repositories;

            use App\Models\\$modelName;

            class $repositoryName implements $interface
            {
                public function __construct(
                   private $modelName  \$$modelName
                ){}
            }
            PHP;

    }

    private function templateInterface(?string $repositoryName, ?string $modelName): string
    {
        $interface = $repositoryName . 'Interface';

        // if($modelName) 
            return <<<PHP
            <?php

            namespace App\Repositories;

            interface $interface {}

            PHP;

    }
}
