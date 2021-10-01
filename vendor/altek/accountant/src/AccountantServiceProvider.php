<?php

declare(strict_types=1);

namespace Altek\Accountant;

use Altek\Accountant\Console\AccountantCipherCommand;
use Altek\Accountant\Console\AccountantContextResolverCommand;
use Altek\Accountant\Console\AccountantIpAddressResolverCommand;
use Altek\Accountant\Console\AccountantLedgerDriverCommand;
use Altek\Accountant\Console\AccountantNotaryCommand;
use Altek\Accountant\Console\AccountantUrlResolverCommand;
use Altek\Accountant\Console\AccountantUserAgentResolverCommand;
use Altek\Accountant\Console\AccountantUserResolverCommand;
use Altek\Accountant\Contracts\Accountant;
use Illuminate\Support\ServiceProvider;

class AccountantServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the service provider.
     *
     * @return void
     */
    public function boot(): void
    {
        $config = __DIR__.'/../config/accountant.php';

        $this->mergeConfigFrom($config, 'accountant');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                $config => base_path('config/accountant.php'),
            ], 'accountant-configuration');

            $migrations = __DIR__.'/../database/migrations/';

            $this->publishes([
                $migrations => database_path('migrations'),
            ], 'accountant-migrations');
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register(): void
    {
        $this->commands([
            AccountantCipherCommand::class,
            AccountantContextResolverCommand::class,
            AccountantIpAddressResolverCommand::class,
            AccountantLedgerDriverCommand::class,
            AccountantNotaryCommand::class,
            AccountantUrlResolverCommand::class,
            AccountantUserAgentResolverCommand::class,
            AccountantUserResolverCommand::class,
        ]);

        $this->app->singleton(Accountant::class, static function ($app) {
            return new \Altek\Accountant\Accountant($app);
        });
    }
}
