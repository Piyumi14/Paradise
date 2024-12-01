<?php

namespace Modules\User\App\Contracts;
use App\Contracts\MainRepositoryInterface;

interface UserRepositoryInterface extends MainRepositoryInterface
{
    public function createUserDetails(array $requestParams);
    public function createUserCredentialDetails(array $requestParams);

}