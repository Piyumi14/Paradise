<?php

namespace Modules\Invitation\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Invitation\App\Contracts\InvitationRepositoryInterface;

class InvitationController extends Controller
{
    private $invitationRepo;

    public function __construct(InvitationRepositoryInterface $invitationRepo){
        $this->invitationRepo = $invitationRepo;
    }

    // send invitation
    public function sendInvitation(Request $request){
        $requestParams = ($request->all());
        $invitationData = $this->_setInvitationPostData($requestParams);
        $invitationDetails = $this->invitationRepo->createInvitation($invitationData);
        return $this->apiResponse($invitationDetails, 200, true, 'invitation sent successfully');
    }

    private function _setInvitationPostData($requestParams){
        return [
            "sender_id" =>  1, // logged in user id must be set
            "receiver_id" => $requestParams['user_id'],
        ];
    }
}
