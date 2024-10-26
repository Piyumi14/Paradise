<?php

namespace Modules\Proposal\App\Repositories;

use Modules\Proposal\App\Contracts\ProposalRepositoryInterface;
use App\Models\Proposal;
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

    public function createProposal(array $requestParams){
        return Proposal::create($requestParams);
    }
}