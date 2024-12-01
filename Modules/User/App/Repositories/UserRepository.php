<?php

namespace Modules\User\App\Repositories;

use Illuminate\Support\Facades\App;
use Illuminate\Contracts\Container\Container;
use App\Repositories\MainRepository;
use App\Models\User;
use App\Models\UserCredential;
use Modules\User\App\Contracts\UserRepositoryInterface;

class UserRepository extends MainRepository implements UserRepositoryInterface
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
        return 'App\Models\User';
    }

    public function createUserDetails(array $requestParams){
        return User::create($requestParams);
    }

    public function createUserCredentialDetails(array $requestParams){
        return UserCredential::create($requestParams);
    }

}