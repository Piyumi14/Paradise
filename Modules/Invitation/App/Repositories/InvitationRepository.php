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

    public function updateSentInvitationStatus($requestParams){
        // 1 should be logged in user
        return Invitation::where('sender_id', 1)->where('receiver_id', $requestParams['user_id'])->update(['status' => $requestParams['status']]);
    }

    public function updateReceivedInvitationStatus($requestParams){
        // 1 should be logged in user
        return Invitation::where('receiver_id', 1)->where('sender_id', $requestParams['user_id'])->update(['status' => $requestParams['status']]);
    }

    public function getAllSentInvitations(){
        // 1 should be logged in user
        return Invitation::where('sender_id', 1)->get()->toArray();
    }

    public function getAllReceivedInvitations(){
        // 1 should be logged in user
        return Invitation::where('receiver_id', 1)->get()->toArray();
    }

}