<?php

/**
 * @namespace
 */
namespace CYBERGATES\Assessment\Risk\Indicator;

use CYBERGATES\Assessment\Risk\Indicator\IndicatorInterface;
use CYBERGATES\Assessment\Risk\Severity\Level as RiskLevel;
use CYBERGATES\Assessment\Risk\Severity\Score as RiskScore;
use CYBERGATES\Assessment\Risk\Factor\ThreatAgent as ThreatAgentFactor;
use CYBERGATES\Assessment\Risk\Factor\Vulnerability as VulnerabilityFactor;
use CYBERGATES\Assessment\Risk\Impact\Technical as TechnicalImpact;
use CYBERGATES\Assessment\Risk\Impact\Business as BusinessImpact;

/**
 * Risk indicators of exposure (IoE) indicate that incident may occur in the future.
 */
class Exposure implements IndicatorInterface
{
    /**
    * Indicator likelihood factors
    * @var array
    */
    protected $likelihood = [];

    /**
    * Indicator impact factors
    * @var array
    */
    protected $impact = [];
    
    /**
    * Indicator risk severity
    * @var array
    */
    protected $severity = [];
    
    /**
     * Initializes the Constructor
     */
    public function __construct()
    {
        $this->reset();
    }

    /**
     * Sets the risk likelihood factors.
     *
     * @param      ThreatAgentFactor    $threatAgentFactor    The threat agent factor
     * @param      VulnerabilityFactor  $vulnerabilityFactor  The vulnerability factor
     *
     * @return     self             The object.
     */
    public function setLikelihood(ThreatAgentFactor $threatAgentFactor, VulnerabilityFactor $vulnerabilityFactor)
    {
        $this->likelihood = [
          'threat agent factors' => $threatAgentFactor,
          'vulnerability factors' => $vulnerabilityFactor
        ];
        
        return $this;
    }

    /**
     * Gets the risk likelihood factors.
     *
     * @return     array             The risk likelihood factors.
     */
    public function getLikelihood()
    {        
        if (!empty($this->likelihood)) return $this->likelihood;
        
        return false;
    }

    /**
     * Gets the overall likelihood.
     *
     * @return     integer  The overall likelihood.
     */
    public function getOverallLikelihood()
    {
        return max($this->likelihood['threat agent factors']->sum()/count($this->likelihood['threat agent factors']),
                   $this->likelihood['vulnerability factors']->sum()/count($this->likelihood['vulnerability factors']), 0);
    }

    /**
     * Sets the technical impact.
     *
     * @param      TechnicalImpact  $impact  The impact
     *
     * @return     self             The object.
     */
    public function setTechnicalImpact(TechnicalImpact $impact)
    {
        $this->impact['technical'] = $impact;
        
        return $this;
    }

    /**
     * Gets the technical impact.
     *
     * @return     array             The technical impact.
     */
    public function getTechnicalImpact()
    {        
        if (!empty($this->impact['technical'])) return $this->impact['technical'];
        
        return false;
    }

     /**
     * Sets the business impact.
     *
     * @param      BusinessImpact  $impact  The impact
     *
     * @return     self             The object.
     */
    public function setBusinessImpact(BusinessImpact $impact)
    {
        $this->impact['business'] = $impact;
        
        return $this;
    }

    /**
     * Gets the business impact.
     *
     * @return     array             The business impact.
     */
    public function getBusinessImpact()
    {        
        if (!empty($this->impact['business'])) return $this->impact['business'];
        
        return false;
    }

    /**
     * Gets the impacts.
     *
     * @return     array  The impacts.
     */
    public function getImpacts()
    {
        return array_merge($this->impact['technical'], $this->impact['business']);
    }

    /**
     * Gets the overall impact.
     *
     * @return     integer  The overall impact.
     */
    public function getOverallImpact()
    {
        return max($this->impact['technical']->sum()/count($this->impact['technical']),
                   $this->impact['business']->sum()/count($this->impact['business']), 0);
    }

    /**
     * Gets the risk severity.
     *
     * @return     integer  The risk severity.
     */
    public function getSeverity()
    {
        return $this->severity;
    }

    /**
     * Gets the risk severity level.
     *
     * @return     integer  The risk severity level.
     */
    public function getSeverityLevel()
    {
        if (isset($this->severity['level'])) return $this->severity['level'];

        return false;
    }

    /**
     * Gets the risk severity score.
     *
     * @return     integer  The risk severity score.
     */
    public function getSeverityScore()
    {
        if (isset($this->severity['score'])) return $this->severity['score'];

        return false;
    }

    /**
     * Evaluates the overall risk severity
     *
     * @return     self  The object.
     */
    public function evaluateOverallSeverity()
    {
        // Gets severity level of the overall impact
        $impact = RiskLevel::getByScore($this->getOverallImpact());
        // Gets severity level of the overall likelihood
        $likelihood = RiskLevel::getByScore($this->getOverallLikelihood());
        // Gets risk severity level based on successfull attack likelihood and impact
        $this->severity['level'] = RiskLevel::getByMatrix($likelihood, $impact);
        // Gets risk severity score based on its level
        $this->severity['score'] = RiskScore::getByLevel($this->severity['level'], RiskScore::SCORE_SYSTEM_100);
        
        return $this;
    }

    /**
     * Helper method
     *
     * @return     self  The object.
     */
    public function evaluate()
    {
        $this->evaluateOverallSeverity();

        return $this;
    }
    
    /**
     * Resets the object properties.
     *
     * @return     self  The object.
     */
    public function reset()
    {
        $this->likelihood = [
            'threat agent factors' => new ThreatAgentFactor(),
            'vulnerability factors' =>  new VulnerabilityFactor()
        ];
        $this->impact = [
            'technical' => new TechnicalImpact(),
            'business' =>  new BusinessImpact()
        ];
        $this->severity['level'] = RiskLevel::LEVEL_NONE;
        $this->severity['score'] = 0;
        

        return $this;
    }

    /**
     * Returns a string representation of the object.
     *
     * @return     string  String representation of the object.
     */
    public function __toString()
    {
        return $this->severity['level'];
    }
}