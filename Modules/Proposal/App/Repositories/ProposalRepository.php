<?php

namespace Modules\Proposal\App\Repositories;

use App\Models\Gallery;
use App\Models\Horoscope;
use App\Models\Parents;
use App\Models\ProfessionalEducational;
use Modules\Proposal\App\Contracts\ProposalRepositoryInterface;
use App\Models\Proposal;
use App\Models\Sibling;
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

    public function createMainProposalDetails(array $requestParams){
        return Proposal::create($requestParams);
    }

    public function createProfessionalAndEducationalDetails(array $requestParams){
        return ProfessionalEducational::create($requestParams);
    }

    public function createParentsDetails(array $requestParams){
        return Parents::create($requestParams);
    }

    public function createSiblingsDetails(array $requestParams){
        return Sibling::create($requestParams);
    }

    public function createHoroscopeDetails(array $requestParams){
        return Horoscope::create($requestParams);
    }

    public function createGalleryDetails(array $requestParams){
        return Gallery::create($requestParams);
    }

    public function getProposalById($proposalId){
        return Proposal::select('*')
        ->where('id', $proposalId)
        ->with('country','province', 'district', 'professionalEducational', 'parents', 'siblings', 'horoscope', 'gallery', 'interests')
        ->first();
    }
}