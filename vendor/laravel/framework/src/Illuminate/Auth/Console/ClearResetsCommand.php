<?php

namespace Illuminate\Auth\Console;

use Illuminate\Console\Command;

class ClearResetsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auth:clear-resets {name? : A senha está correta}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'O link de redefinição de senha expirou!';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        $this->laravel['auth.password']->broker($this->argument('name'))->getRepository()->deleteExpired();

        $this->info('O link de redefinição de senha expirou!');
    }
}
