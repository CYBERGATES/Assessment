<?php

/**
 * @namespace
 */
namespace CYBERGATES\Assessment\Risk\Impact;

use CYBERGATES\Assessment\Risk\Impact\BaseImpact;

/**
 * Technical impacts
 */
class Technical extends BaseImpact
{
    protected $impacts=array();
    
    /**
     * Initializes the Constructor
     *
     * Loss of confidentiality
     * how much data could be disclosed and how sensitive is it?
     * minimal non-sensitive data disclosed (2),
     * minimal critical data disclosed (6),
     * extensive non-sensitive data disclosed (6),
     * extensive critical data disclosed (7),
     * all data disclosed (9)
     * @param      integer  $confidentiality    The loss of confidentiality
     * 
     * Loss of integrity
     * how much data could be corrupted and how damaged is it?
     * minimal slightly corrupt data (1),
     * minimal seriously corrupt data (3),
     * extensive slightly corrupt data (5),
     * extensive seriously corrupt data (7),
     * all data totally corrupt (9)
     * @param      integer  $integrity     The loss of integrity
     * 
     * Loss of availability
     * how much service could be lost and how vital is it?
     * minimal secondary services interrupted (1),
     * minimal primary services interrupted (5),
     * extensive secondary services interrupted (5),
     * extensive primary services interrupted (7),
     * all services completely lost (9) 
     * @param      integer  $availability       The loss of availability
     * 
     *
     * Loss of accountability
     * are the threat agents' actions traceable to an individual?
     * fully traceable (1),
     * possibly traceable (7),
     * completely anonymous (9)
     * @param      integer  $accountability      The loss of accountability
     */
    public function __construct($confidentiality = 0, $integrity = 0, $availability = 0, $accountability = 0)
    {
        $this->impacts['loss of confidentiality'] = $confidentiality;
        $this->impacts['loss of integrity'] = $integrity;
        $this->impacts['loss of availability'] = $availability;
        $this->impacts['loss of accountability'] = $accountability;
    }
}