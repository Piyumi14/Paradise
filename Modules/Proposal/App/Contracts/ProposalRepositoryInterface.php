<?php

namespace Modules\Proposal\App\Contracts;
use App\Contracts\MainRepositoryInterface;

interface ProposalRepositoryInterface extends MainRepositoryInterface
{
    public function getAllProposals($option, $pluck ='');
    public function createMainProposalDetails(array $requestParams);
    public function createProfessionalAndEducationalDetails(array $requestParams);
    public function createParentsDetails(array $requestParams);
    public function createSiblingsDetails(array $requestParams);
    public function createHoroscopeDetails(array $requestParams);
    public function createGalleryDetails(array $requestParams);
}