<?php

/**
 * @namespace
 */
namespace CYBERGATES\Assessment\Risk\Indicator;

use CYBERGATES\Assessment\Risk\Indicator\IndicatorInterface;
use CYBERGATES\Assessment\Risk\Severity\Level as RiskLevel;
use CYBERGATES\Assessment\Risk\Severity\Score as RiskScore;
use CYBERGATES\Assessment\Risk\Impact\Technical as TechnicalImpact;
use CYBERGATES\Assessment\Risk\Impact\Business as BusinessImpact;

/**
 * Risk indicators of compromise (IoC) give information that incident might have occurred or is happening now.
 */
class Compromise implements IndicatorInterface
{
    /**
     * Status names
     */
    const STATUS_OPEN       = 'open';
    const STATUS_RESOLVED   = 'resolved';

    /**
    * Indicator details
    * @var array
    */
    protected $details = [];

    /**
    * Indicator impact factors
    * @var array
    */
    protected $impact = [];

    /**
    * Indicator priority
    * @var string
    */
    protected $priority = 'none';
    
    /**
    * Indicaror risk severity
    * @var array
    */
    protected $severity = [];
    
    /**
     * Initializes the Constructor
     */
    public function __construct() {}

    /**
     * Sets the indicaror detail.
     *
     * @param      string  $name   The detail name
     * @param      string  $value  The detail value
     *
     * @return     array  The indicator details.
     */
    public function setDetail($name = '', $value = '')
    {
        if ($name != '') $this->details[$name] = $value;

        return $this->details;
    }

    /**
     * Gets the indicaror detail.
     *
     * @param      string  $name   The detail name
     *
     * @return     array  The indicator detail.
     */
    public function getDetail($name = '')
    {
        if (isset($this->details[$name])) return $this->details[$name];

        return false;
    }

    /**
     * Sets the indicaror details.
     *
     * @param      array   $values  The details
     *
     * @return     array  The indicator details.
     */
    public function setDetails($values = array())
    {
        if (empty($values)) return;

        foreach ($values as $name => $value) {
            $this->details[$name] = $value;
        }

        return $this->details;
    }

    /**
     * Gets the indicator details.
     *
     * @return     array  The indicator details.
     */
    public function getDetails()
    {
        return $this->details;
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
        $this->impact['technical'] = $impact->toArray();
        
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
        $this->impact['business'] = $impact->toArray();
        
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
        return max(array_sum($this->impact['technical'])/count($this->impact['technical']),
                   array_sum($this->impact['business'])/count($this->impact['business']), 0);
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
        // Gets severity level of security event priority
        $this->priority = RiskLevel::getByDate($this->details['date reported']);
        $priority = RiskScore::getByLevel($this->priority, RiskScore::SCORE_SYSTEM_10);
        $priority = ($this->details['status'] == self::STATUS_RESOLVED)
            // Decreases priority level if issue is already resolved
            ? $priority * 0.8
            : $priority;
        $this->priority = RiskLevel::getByScore($priority);
        // Gets risk severity score based on overall impact, security event priority and its status
        $impact = $this->getOverallImpact();
        $this->severity['score'] = intval(round(($priority * $impact), 0, PHP_ROUND_HALF_DOWN));
        // Gets risk severity level based on its score
        $this->severity['level'] = RiskLevel::getByProbability($this->severity['score']);
        
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
     * Returns a string representation of the object.
     *
     * @return     string  String representation of the object.
     */
    public function __toString()
    {
        return $this->severity['level'];
    }
}