<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Proposal\App\Contracts\ProposalRepositoryInterface;
use Modules\Proposal\App\Repositories\ProposalRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ProposalRepositoryInterface::class, ProposalRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
