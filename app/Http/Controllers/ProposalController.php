<?php

namespace App\Http\Controllers;

use App\Contracts\ProposalRepositoryInterface;
use App\Http\Resources\ProposalResourcesCollection;
use Illuminate\Http\Request;

class ProposalController extends Controller
{
    private $proposalRepo;

    public function __construct(ProposalRepositoryInterface $proposalRepo)
    {
        $this->proposalRepo = $proposalRepo;
    }

    /**
     * Retrieves all proposals based on the provided request parameters.
     * @param Request $request The incoming request object containing search, sorting, and pagination parameters.
     * @return \Illuminate\Http\JsonResponse A JSON response containing the paginated and sorted proposal data.
     */
    public function getAllProposals(Request $request)
    {
        $requestParams = ($request->all());
        $option = $this->_prepareSearchDataArray($requestParams);
        $proposals = $this->proposalRepo->getAllProposals($option);
        $proposalData = new ProposalResourcesCollection($proposals);
        return $this->apiResponse($proposalData, $this->response_status_code, true);
    }


    private function _prepareSearchDataArray($requestParams)
    {
        return [
            'sortBy' => [
                'column' => !empty($requestParams['sortColumn']) ? $this->_sortColumn($requestParams['sortColumn']) : '',
                'type' => !empty($requestParams['sortDirection']) ? $requestParams['sortDirection'] : 'desc',
            ],
            'search' => !empty($requestParams['search']) ? $requestParams['search'] : '',
            'paginate' => !empty($requestParams['count_per_page']) ? $requestParams['count_per_page'] : 20,

        ];
    }

    private function _sortColumn($sortColumn)
    {
        $sortColumnName = '';
        switch ($sortColumn) {
            case '':
                $sortColumnName = 'created_at';
                break;

            default;
        }

        return $sortColumnName;
    }
}
