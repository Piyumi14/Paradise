<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Proposal\App\Contracts\ProposalRepositoryInterface;
use Modules\Proposal\App\Repositories\ProposalRepository;
use Modules\User\App\Contracts\UserRepositoryInterface;
use Modules\User\App\Repositories\UserRepository;
use Modules\Invitation\App\Contracts\InvitationRepositoryInterface;
use Modules\Invitation\App\Repositories\InvitationRepository;
use Modules\Location\App\Contracts\LocationRepositoryInterface;
use Modules\Location\App\Repositories\LocationRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ProposalRepositoryInterface::class, ProposalRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(InvitationRepositoryInterface::class, InvitationRepository::class);
        $this->app->bind(LocationRepositoryInterface::class, LocationRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
