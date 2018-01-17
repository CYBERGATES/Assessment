<?php

/**
 * @namespace
 */
namespace CYBERGATES\Assessment\Risk\Impact;

use CYBERGATES\Assessment\Risk\Impact\BaseImpact;

/**
 * Business impacts
 */
class Business extends BaseImpact
{
    protected $impacts=array();
    
    /**
     * Initializes the Constructor
     *
     * Financial damage
     * how much financial damage will result from an exploit?
     * less than the cost to fix the vulnerability (1),
     * minor effect on annual profit (3),
     * significant effect on annual profit (7),
     * bankruptcy (9)
     * @param      integer  $financial    The financial damage
     * 
     * Reputation damage
     * would an exploit result in reputation damage that would harm the business?
     * minimal damage (1),
     * loss of major accounts (4),
     * loss of goodwill (5),
     * brand damage (9)
     * @param      integer  $reputation     The reputation damage
     * 
     * Non-compliance
     * how much exposure does non-compliance introduce?
     * minor violation (2),
     * clear violation (5),
     * high profile violation (7)
     * @param      integer  $noncompliance       The non-compliance
     * 
     *
     * Privacy violation
     * how much personally identifiable information could be disclosed?
     * one individual (3),
     * hundreds of people (5),
     * thousands of people (7),
     * millions of people (9)
     * @param      integer  $privacy      The privacy violation
     */
    public function __construct($financial = 0, $reputation = 0, $noncompliance = 0, $privacy = 0)
    {
        $this->impacts['financial damage'] = $financial;
        $this->impacts['reputation damage'] = $reputation;
        $this->impacts['non-compliance'] = $noncompliance;
        $this->impacts['privacy violation'] = $privacy;
    }
}