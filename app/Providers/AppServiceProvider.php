<?php

namespace App\Providers;

use App\Contracts\ProposalRepositoryInterface;
use App\Repositories\ProposalRepository;
use Illuminate\Support\ServiceProvider;

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
