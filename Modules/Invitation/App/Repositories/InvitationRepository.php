<?php

namespace Modules\Invitation\App\Repositories;

use Illuminate\Support\Facades\App;
use Illuminate\Contracts\Container\Container;
use App\Repositories\MainRepository;
use App\Models\Invitation;
use Illuminate\Support\Facades\Auth;
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

    public function createInvitation(array $requestParams)
    {
        return Invitation::create($requestParams);
    }

    public function updateSentInvitationStatus($requestParams)
    {
        return Invitation::where('sender_id', Auth::user()->id)->where('receiver_id', $requestParams['user_id'])->update(['status' => $requestParams['status']]);
    }

    public function updateReceivedInvitationStatus($requestParams)
    {
        return Invitation::where('receiver_id', Auth::user()->id)->where('sender_id', $requestParams['user_id'])->update(['status' => $requestParams['status']]);
    }

    public function getAllSentInvitations()
    {
        return Invitation::where('sender_id', Auth::user()->id)
            ->with(['receiverProposal' => function ($query) {
                $query->with(['professionalEducational', 'gallery']);
            }])
            ->get()
            ->toArray();
    }

    public function getAllReceivedInvitations()
    {
        return Invitation::where('receiver_id', Auth::user()->id)
            ->with(['senderProposal' => function ($query) {
                $query->with(['professionalEducational', 'gallery']);
            }])
            ->get()
            ->toArray();
    }

    public function getSendInvitationStatus($proposalId)
    {
        return Invitation::select('status')
        ->where('receiver_proposal_id', $proposalId)
        ->where('sender_id', Auth::user()->id)
        ->first();
    }

    public function getReceivedInvitationStatus($proposalId)
    {
        return Invitation::select('status')
        ->where('sender_proposal_id', $proposalId)
        ->where('receiver_id', Auth::user()->id)
        ->first();
    }
}
