<?php

    namespace App\Console\Commands\Common;

    use Illuminate\Console\Command;

    class MakeOperation extends Command
    {
        /**
         * The name and signature of the console command.
         *
         * @var string
         */
        protected $signature = 'make:operation {name}';

        /**
         * The console command description.
         *
         * @var string
         */
        protected $description = 'Create a new Operation trait';

        /**
         * Create a new command instance.
         *
         * @return void
         */
        public function __construct()
        {
            parent::__construct();
        }

        protected function getStub($type): string
        {
            return file_get_contents(base_path(sprintf('stubs/%s.stub', $type)));
        }

        protected function generate(string $name, string $type, string $typeFolder)
        {
            $typeCap = ucfirst($type);
            $explode = explode('/', $name);
            $directory = implode('\\', array_slice($explode, 0, -1));
            $className = end($explode);

            $namespace = sprintf('%s%s', $typeFolder, $directory ? sprintf('\%s', $directory) : '');
            $namespaceClass = sprintf('%s\%s', 'App', $namespace);

            $fullDirectory = app_path($namespace);
            $fileName = sprintf('%s.php', $className);
            $fullPath = sprintf('%s/%s', $fullDirectory, $fileName);

            $template = str_replace(
                ['{{name}}', '{{namespace}}'],
                [$className, $namespaceClass],
                $this->getStub($type)
            );

            $fullDirectory = str_replace('\\', '/', $fullDirectory);
            $fullPath = str_replace('\\', '/', $fullPath);

            if (!file_exists($fullDirectory)) {
                mkdir($fullDirectory, 0777, true);
            }

            if (!file_exists($fullPath)) {
                file_put_contents($fullPath, $template);
                $this->info(sprintf('%s created successfully.', $typeCap));
            }
            else {
                $this->error(sprintf('The given %s already exists', $typeCap));
            }
        }

        public function handle()
        {
            $name = $this->argument('name');

            $this->generate($name, 'operation', 'Traits\Operation');
        }
    }
