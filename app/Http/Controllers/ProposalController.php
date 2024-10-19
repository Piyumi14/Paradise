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

    /*function - get all proposals
    * parameters - request parameters
    * returns - json response with all proposals
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

    public function createProposal(Request $request){
        $requestParams = ($request->all());
        $proposalData = $this->_setProposalPostData($requestParams);
        $proposalDetails = $this->proposalRepo->createProposal($proposalData);
        return $this->apiResponse($proposalDetails, $this->response_status_code, true);
    }

    private function _setProposalPostData($request)
    {
        return  [
            "user_id" => $request['user_id'],
            "reference_number" => $request['reference_number'],
            "first_name" => $request['first_name'],
            "middle_name" => $request['middle_name'],
            "last_name" => $request['last_name'],
            "preferred_name" => $request['preferred_name'],
            "age" => $request['age'],
            "height" => $request['height'],
            "civil_status" => $request['civil_status'],
            "country_id" => $request['country_id'],
            "province_id" => $request['province_id'],
            "district_id" => $request['district_id'],
            "area" => $request['area'],
            "nationality" => $request['nationality'],
            "religion" => $request['religion'],
            "cast" => $request['cast'],
            "profile_description" => $request['profile_description'],
        ];  
    }
}
