<?php

namespace Modules\Proposal\App\Repositories;

use App\Models\Gallery;
use App\Models\Horoscope;
use App\Models\Parents;
use App\Models\Payments;
use App\Models\Photo;
use App\Models\ProfessionalEducational;
use Modules\Proposal\App\Contracts\ProposalRepositoryInterface;
use App\Models\Proposal;
use App\Models\Qualification;
use App\Models\Sibling;
use App\Models\User;
use Illuminate\Support\Facades\App;
use Illuminate\Contracts\Container\Container;
use App\Repositories\MainRepository;

class ProposalRepository extends MainRepository implements ProposalRepositoryInterface
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
        return 'App\Models\Proposal';
    }

    public function getAllProposals($options, $pluck = '')
    {
        $proposals = Proposal::query()->select("*");

        if (!empty($options['sortBy'])) {
            if ($options['sortBy']['column'] == '') {
                $proposals = $proposals->orderBy('created_at', $options['sortBy']['type']);
            }
        }

        if ($pluck != '') {
            $proposals = $proposals->pluck($pluck);
        } else if (!empty($options['paginate'])) {
            $proposals = $proposals->paginate($options['paginate']);
        } else {
            $proposals = $proposals->get();
        }

        return $proposals;
    }

    public function createMainProposalDetails(array $requestParams)
    {
        return Proposal::create($requestParams);
    }

    public function createProfessionalAndEducationalDetails(array $requestParams)
    {
        return Qualification::create($requestParams);
    }

    public function createParentsDetails(array $requestParams)
    {
        return Parents::create($requestParams);
    }

    public function createSiblingsDetails(array $requestParams)
    {
        return Sibling::create($requestParams);
    }

    public function createHoroscopeDetails(array $requestParams)
    {
        return Horoscope::create($requestParams);
    }

    public function createGalleryDetails(array $requestParams)
    {
        return Photo::create($requestParams);
    }
    public function createPayamentDetails(array $requestParams)
    {
        return Payments::create($requestParams);
    }

    public function getProposalById($proposalId)
    {
        return Proposal::select('*')
            ->where('id', $proposalId)
            ->with('professionalEducational', 'parents', 'siblings', 'horoscope', 'gallery', 'payment')
            ->first();
    }

    public function approveProposalById($proposalId)
    {
        // update proposal status into active
        $proposalUpdated = Proposal::where('id', $proposalId)->update(['status' => 1]);

        if ($proposalUpdated) {
            $proposal = Proposal::select('id', 'user_id', 'reference_number')->where('id', $proposalId)->first();

            // update user status into active
            $userUpdated = User::where('id', $proposal['user_id'])->update(['status' => 1]);

            return $proposal ? $proposal : false;
        }

        return false;
    }

    //get latest reference 
    public function getLatestReference()
    {
        return Proposal::select('reference_number')
            ->latest('id')
            ->value('reference_number');
    }
}
