<?php

namespace App\Contracts;
use App\Contracts\MainRepositoryInterface;

interface ProposalRepositoryInterface extends MainRepositoryInterface
{
    public function getAllProposals($option, $pluck ='');
    public function createProposal(array $requestParams);
}
