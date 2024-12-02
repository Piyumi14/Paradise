<?php

namespace Modules\Invitation\App\Repositories;

use Illuminate\Support\Facades\App;
use Illuminate\Contracts\Container\Container;
use App\Repositories\MainRepository;
use App\Models\Invitation;
use Modules\Invitation\App\Contracts\InvitationRepositoryInterface;

class InvitationRepository extends MainRepository implements InvitationRepositoryInterface
{
    protected $app;
    public function __construct(Container $app)
    {
        $this->app = $app; // Store the container instance
    }

    /**
     * Get the model associated with the repository.
     *
     * @return string The fully qualified class name of the model.
     */
    function model()
    {
        return 'App\Models\Invitation';
    }

    public function createInvitation(array $requestParams){
        return Invitation::create($requestParams);
    }

}