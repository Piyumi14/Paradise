<?php

namespace Modules\Invitation\App\Contracts;
use App\Contracts\MainRepositoryInterface;

interface InvitationRepositoryInterface extends MainRepositoryInterface
{
    public function createInvitation(array $requestParams);
}