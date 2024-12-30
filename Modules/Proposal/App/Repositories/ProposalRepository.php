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
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
        $matchingGender = Auth::user()->gender === 'Male' ? "Female" : "Male";
        $proposals = Proposal::query()->select("*")->where('gender', $matchingGender);

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
        try {
            // Update proposal status into active
            $proposalUpdated = Proposal::where('id', $proposalId)->update(['status' => 1]);

            if ($proposalUpdated) {
                $proposal = Proposal::select('id', 'user_id', 'reference_number', 'email', 'first_name', 'last_name', 'phone_number')
                    ->where('id', $proposalId)
                    ->first();

                if (!$proposal) {
                    throw new Exception("Proposal not found with ID: $proposalId");
                }

                try {
                    // Update user status into active
                    User::where('id', $proposal['user_id'])->update(['status' => 1]);
                } catch (Exception $e) {
                    Log::error("Failed to update user status for User ID: {$proposal['user_id']}", ['error' => $e->getMessage()]);
                    return false;
                }

                if (env('ENABLE_EMAIL_AND_SMS', true) == true) {
                    try {
                        $emailData = [
                            'email' => $proposal['email'],
                            'name' => $proposal['first_name'] . ' ' . $proposal['last_name'],
                            'type' => 'User',
                            'reference' => $proposal['reference_number'],
                        ];
                        sendEmail($emailData);
                    } catch (Exception $e) {
                        Log::error("Failed to send email to: {$proposal['email']}", ['error' => $e->getMessage()]);
                    }

                    try {
                        $smsData = [
                            'phone_number' => $proposal['phone_number'],
                            'message' => 'Your account has been created successfully. Your login details as below. Username is ' . $proposal['reference_number'] . ' and Password is ' . 'password@123',
                            'type' => 'User',
                        ];
                        sendSMS($smsData);
                    } catch (Exception $e) {
                        Log::error("Failed to send SMS to: {$proposal['phone_number']}", ['error' => $e->getMessage()]);
                    }
                }

                return $proposal;
            }

            return false;
        } catch (Exception $e) {
            Log::error("Failed to approve proposal with ID: $proposalId", ['error' => $e->getMessage()]);
            return false;
        }
    }

    //get latest reference 
    public function getLatestReference()
    {
        return Proposal::select('reference_number')
            ->latest('id')
            ->value('reference_number');
    }

    //get proposals for admin 
    public function getAllProposalsForAdmin()
    {
        return Proposal::select('*')
            ->with('payment')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    //get proposal details by user id
    public function getProposalDetailsByUserId($userId)
    {
        return Proposal::select('*')
            ->where('user_id', $userId)
            ->with('professionalEducational', 'parents', 'siblings', 'horoscope', 'gallery', 'payment')
            ->first();
    }

    // get the main photo's image URL by user ID
    public function getProfileImageByUserId($userId)
    {
        return Photo::select('photos.image_url')
            ->join('proposals', 'photos.proposal_id', '=', 'proposals.id')
            ->where('proposals.user_id', $userId)
            ->where('photos.is_main_photo', true)
            ->first();
    }
}
