<?php

namespace Modules\Invitation\App\Contracts;
use App\Contracts\MainRepositoryInterface;

interface InvitationRepositoryInterface extends MainRepositoryInterface
{
    public function createInvitation(array $requestParams);
    public function updateSentInvitationStatus($requestParams);
    public function updateReceivedInvitationStatus($requestParams);
}