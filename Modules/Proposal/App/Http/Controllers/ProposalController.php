<?php

namespace Modules\Proposal\App\Http\Controllers;

use Modules\Proposal\App\Contracts\ProposalRepositoryInterface;
use Modules\User\App\Contracts\UserRepositoryInterface;
use Modules\Proposal\App\Http\Resources\ProposalResourcesCollection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use Ramsey\Uuid\Uuid;
use App\Services\SMSService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProposalController extends Controller
{
    private $proposalRepo;
    private $userRepo;
    protected $smsService;

    public function __construct(
        ProposalRepositoryInterface $proposalRepo,
        UserRepositoryInterface $userRepo,
        SMSService $smsService
    ) {
        $this->proposalRepo = $proposalRepo;
        $this->userRepo = $userRepo;
        $this->smsService = $smsService;
    }

    //get all proposals
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

    //create new proposal
    public function createProposal(Request $request)
    {
        try {
            $requestParams = $request->all();

            // begin a transaction
            DB::beginTransaction();

            // 01. create user details
            $userData = $this->_setUserPostData($requestParams['main_details']);
            $userDetails = $this->userRepo->createUserDetails($userData);

            // 02. create user credential details
            $latestReference = $this->proposalRepo->getLatestReference();
            $newReference = $this->_createNewReference($latestReference); // create a new reference number
            $userCredData = $this->_setUserCredentialPostData($userDetails['id'], $newReference);
            $this->userRepo->createUserCredentialDetails($userCredData);

            // 03. create main proposal details
            $proposalData = $this->_setMainProposalPostData($userDetails['id'], $newReference, $requestParams['main_details']);
            $proposalDetails = $this->proposalRepo->createMainProposalDetails($proposalData);
            $requestParams['proposal_id'] = $proposalDetails['id'];

            // 04. create professional and educational details
            $professionalAndEducationalData = $this->_setProfessionalAndEducationalPostData($requestParams['proposal_id'], $requestParams['professional_and_educational']);
            $this->proposalRepo->createProfessionalAndEducationalDetails($professionalAndEducationalData);

            // 05. create parents details
            $parentsData = $this->_setParentsPostData($requestParams['proposal_id'], $requestParams['parents']);
            $this->proposalRepo->createParentsDetails($parentsData);

            // 06. create siblings details
            foreach ($requestParams['siblings'] as $sibling) {
                $siblingsData = $this->_setSiblingsPostData($requestParams['proposal_id'], $sibling);
                $this->proposalRepo->createSiblingsDetails($siblingsData);
            }

            // 07. create horoscope details
            $horoscopeData = $this->_setHoroscopePostData($requestParams['proposal_id'], $requestParams['horoscope']);
            $this->proposalRepo->createHoroscopeDetails($horoscopeData);

            // 08. create gallery details
            $image = $this->_saveImage($requestParams['gallery']);

            foreach ($image as $gallery) {
                $galleryData = $this->_setGalleryPostData($requestParams['proposal_id'], $gallery);
                $this->proposalRepo->createGalleryDetails($galleryData);
            }

            // commit the transaction
            DB::commit();

            // return success response
            $returnData = [];
            $returnData['proposal_id'] = $requestParams['proposal_id'];
            $returnData['reference_number'] = $newReference;
            return $this->apiResponse($returnData, 200, true, 'proposal created successfully');
        } catch (Exception $e) {
            // rollback the transaction on error
            DB::rollBack();
            return $this->apiResponse([], 400, false, $e->getMessage());
        }
    }

    private function _setUserPostData($mainDetails)
    {
        return [
            "user_uuid" =>  Uuid::uuid4()->toString(),
            "first_name" => $mainDetails['first_name'],
            "last_name" => $mainDetails['last_name'],
            "email" => $mainDetails['email'],
            "phone_number" => $mainDetails['phone_number'],
            "status" => 0
        ];
    }

    //create new reference number
    private function _createNewReference($latestReference)
    {
        if (!$latestReference) {
            return 'PREF000001';
        }

        $numericPart = (int) filter_var($latestReference, FILTER_SANITIZE_NUMBER_INT);
        $newNumericPart = $numericPart + 1;
        $newReference = 'PREF' . str_pad($newNumericPart, 6, '0', STR_PAD_LEFT);
        return $newReference;
    }


    private function _setUserCredentialPostData($userId, $referenceNumber)
    {

        return [
            "user_id" => $userId,
            "username" => $referenceNumber,
            "password" => $this->_generateRandomPassword()
        ];
    }

    private function _generateRandomPassword($length = 12)
    {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-_=+';
        $password = '';
        for ($i = 0; $i < $length; $i++) {
            $password .= $characters[random_int(0, strlen($characters) - 1)];
        }
        return $password;
    }

    private function _setMainProposalPostData($userId, $reference, $mainDetails)
    {
        return  [
            "user_id" => $userId,
            "reference_number" => $reference,
            "first_name" => $mainDetails['first_name'],
            "middle_name" => $mainDetails['middle_name'],
            "last_name" => $mainDetails['last_name'],
            "preferred_name" => $mainDetails['preferred_name'],
            "age" => $mainDetails['age'],
            "gender" => $mainDetails['gender'],
            "phone_number" => $mainDetails['phone_number'],
            "email" => $mainDetails['email'],
            "height" => $mainDetails['height'],
            "civil_status" => $mainDetails['civil_status'],
            "country" => $mainDetails['country'],
            "province" => $mainDetails['province'],
            "district" => $mainDetails['district'],
            "area" => $mainDetails['area'],
            "nationality" => $mainDetails['nationality'],
            "religion" => $mainDetails['religion'],
            "cast" => $mainDetails['cast'],
            "profile_description" => $mainDetails['profile_description'],
        ];
    }

    private function _setProfessionalAndEducationalPostData($proposalId, $professionalAndEducationalData)
    {
        return  [
            "proposal_id" => $proposalId,
            "occupation" => $professionalAndEducationalData['occupation'],
            "industry" => $professionalAndEducationalData['industry'],
            "company" => $professionalAndEducationalData['company'],
            "salary_range" => $professionalAndEducationalData['salary_range'],
            "highest_education" => $professionalAndEducationalData['highest_education'],
            "field_of_study" => $professionalAndEducationalData['field_of_study'],
            "institution" => $professionalAndEducationalData['institution'],
            "other_details" => $professionalAndEducationalData['other_details'],
        ];
    }

    private function _setParentsPostData($proposalId, $parentsData)
    {
        return  [
            "proposal_id" => $proposalId,
            "father_nationality" => $parentsData['father_nationality'],
            "father_religion" => $parentsData['father_religion'],
            "father_cast" => $parentsData['father_cast'],
            "father_profession" => $parentsData['father_profession'],
            "father_is_live" => $parentsData['father_is_live'],
            "mother_nationality" => $parentsData['mother_nationality'],
            "mother_religion" => $parentsData['mother_religion'],
            "mother_cast" => $parentsData['mother_cast'],
            "mother_profession" => $parentsData['mother_profession'],
            "mother_is_live" => $parentsData['mother_is_live'],
        ];
    }

    private function _setSiblingsPostData($proposalId, $siblingData)
    {
        return  [
            "proposal_id" => $proposalId,
            "sibling_type" => $siblingData['sibling_type'],
            "civil_status" => $siblingData['civil_status'],
        ];
    }

    private function _setHoroscopePostData($proposalId, $horoscopeData)
    {
        return  [
            "proposal_id" => $proposalId,
            "birth_date" => $horoscopeData['birthDate'],
            "birth_time" => $horoscopeData['birthTime'],
            "birth_place" => $horoscopeData['birthPlace'],
            "lagnaya" => $horoscopeData['lagnaya'],
            "1" => isset($horoscopeData['1']) ? $horoscopeData['1'] : "",
            "2" => isset($horoscopeData['2']) ? $horoscopeData['2'] : "",
            "3" => isset($horoscopeData['3']) ? $horoscopeData['3'] : "",
            "4" => isset($horoscopeData['4']) ? $horoscopeData['4'] : "",
            "5" => isset($horoscopeData['5']) ? $horoscopeData['5'] : "",
            "6" => isset($horoscopeData['6']) ? $horoscopeData['6'] : "",
            "7" => isset($horoscopeData['7']) ? $horoscopeData['7'] : "",
            "8" => isset($horoscopeData['8']) ? $horoscopeData['8'] : "",
            "9" => isset($horoscopeData['9']) ? $horoscopeData['9'] : "",
            "10" => isset($horoscopeData['10']) ? $horoscopeData['10'] : "",
            "11" => isset($horoscopeData['11']) ? $horoscopeData['11'] : "",
            "12" => isset($horoscopeData['12']) ? $horoscopeData['12'] : "",
        ];
    }

    private function _setGalleryPostData($proposalId, $galleryData)
    {
        $filename = basename($galleryData['path']);

        return  [
            "proposal_id" => $proposalId,
            "image_url" => $filename,
            "is_main_photo" => $galleryData['is_main_photo'],
        ];
    }

    //get proposal details by id
    public function getProposalById($proposalId)
    {
        if ($proposalId) {
            $proposal = $this->proposalRepo->getProposalById($proposalId);
            return $this->apiResponse($proposal, 200, true, 'proposal retrieved successfully');
        }
    }

    //approve proposal by id
    public function approveProposal($proposalId)
    {
        if ($proposalId) {
            $proposal = $this->proposalRepo->approveProposalById($proposalId);
            return $this->apiResponse($proposal, 200, true, 'proposal approved successfully');
        }
    }

    //send email
    public function sendEmail(Request $request)
    {
        $requestParams = ($request->all());
        return sendEmail($requestParams);
    }

    //send sms
    public function sendSMS()
    {
        $requestParams = [
            'phone_number' => '94710197538',
            'message' => 'Hello! This message is generated from Paradise.lk'
        ];
        return sendSMS($requestParams);
    }

    // save image to local storage
    private function _saveImage($request)
    {
        $savedImages = [];

        foreach ($request as $image) {
            if (!empty($image['image_url'])) {
                $file = $image['image_url'];

                if ($file instanceof \Illuminate\Http\UploadedFile && $file->isValid()) {
                    $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
                    $path = $file->storeAs('public/images', $fileName);
                    $savedImages[] = [
                        'path' => $path,
                        'is_main_photo' => $image['is_main_photo'],
                    ];
                }
            }
        }

        return $savedImages;
    }
}
