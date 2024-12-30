<?php

namespace Modules\Invitation\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Proposal;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Modules\Invitation\App\Contracts\InvitationRepositoryInterface;

class InvitationController extends Controller
{
    private $invitationRepo;

    public function __construct(InvitationRepositoryInterface $invitationRepo)
    {
        $this->invitationRepo = $invitationRepo;
    }

    // send invitation
    public function sendInvitation(Request $request)
    {
        $requestParams = ($request->all());
        $invitationData = $this->_setInvitationPostData($requestParams);
        $invitationDetails = $this->invitationRepo->createInvitation($invitationData);
        return $this->apiResponse($invitationDetails, 200, true, 'invitation sent successfully');
    }

    private function _setInvitationPostData($requestParams)
    {
        $senderProposalId = Proposal::select('id')->where('user_id', Auth::user()->id)->first();
        return [
            "sender_id" =>  Auth::user()->id,
            "receiver_id" => $requestParams['user_id'],
            "sender_proposal_id" => $senderProposalId->id,
            "receiver_proposal_id" => $requestParams['proposal_id'],
        ];
    }

    //update snet invitation status
    public function updateSentInvitationStatus(Request $request)
    {
        $requestParams = ($request->all());
        $invitationDetails = $this->invitationRepo->updateSentInvitationStatus($requestParams);
        return $this->apiResponse($invitationDetails, 200, true, 'invitation status updated successfully');
    }

    //update received invitation status
    public function updateReceivedInvitationStatus(Request $request)
    {
        $requestParams = ($request->all());
        $invitationDetails = $this->invitationRepo->updateReceivedInvitationStatus($requestParams);
        return $this->apiResponse($invitationDetails, 200, true, 'invitation status updated successfully');
    }

    //get all sent invitation details
    public function getAllSentInvitations()
    {
        $sentInvitationDetails = $this->invitationRepo->getAllSentInvitations();
        return $this->apiResponse($sentInvitationDetails, 200, true);
    }

    //get all received invitation details
    public function getAllReceivedInvitations()
    {
        $receviedInvitationDetails = $this->invitationRepo->getAllReceivedInvitations();
        return $this->apiResponse($receviedInvitationDetails, 200, true);
    }

    //get send invitation status
    public function getSendInvitationStatus($proposal_id)
    {
        $invitationDetails = $this->invitationRepo->getSendInvitationStatus($proposal_id);
        return $this->apiResponse($invitationDetails, 200, true);
    }
    
    //get received invitation status
    public function getReceivedInvitationStatus($proposal_id)
    {
        $invitationDetails = $this->invitationRepo->getReceivedInvitationStatus($proposal_id);
        return $this->apiResponse($invitationDetails, 200, true);
    }
}
