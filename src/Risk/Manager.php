<?php
/**
 * Information security risk management library based on OWASP risk rating methodology
 * https://www.owasp.org/index.php/OWASP_Risk_Rating_Methodology
 *
 * @author Samvel Gevorgyan (http://twitter.com/SamvelG)
 * @copyright (c) 2018 CYBER GATES (http://www.cybergates.org)
 * @version 1.0, 15.01.18
 */

/**
 * @namespace
 */
namespace CYBERGATES\Assessment\Risk;

use CYBERGATES\Assessment\Risk\Indicator\IndicatorInterface;
use CYBERGATES\Assessment\Risk\Severity\Level as RiskLevel;
use CYBERGATES\Assessment\Risk\Severity\Score as RiskScore;

/**
 * Risk manager for estimating the overall risk.
 */
class Manager
{
    
    /**
    * Collection of risk indicators
    * @var array
    */
    protected $indicators = [];

    /**
    * Overall risk severity
    * @var array
    */
    protected $severity = [];
	
	/**
     * Initializes the Constructor
     */
    public function __construct() {}

	/**
     * Sets the indicators.
     *
     * @param      array  $indicators  The indicators
     *
     * @return     self   The object.
     */
    public function setIndicators($indicators = array())
    {
	    if (!empty($indicators)) {
            while ($indicator = current($indicators)) {
                if ($indicator instanceof IndicatorInterface) {
                    $this->indicators[] = $indicator;
                }

                // Moves to the next indicator
                next($indicators);
            }
        }
        
        return $this;
	}

    /**
     * Adds an indicator.
     *
     * @param      \CYBERGATES\Assessment\Risk\Indicator\IndicatorInterface  $indicator  The indicator
     *
     * @return     self                                                      The object.
     */
    public function addIndicator(IndicatorInterface $indicator = null)
    {
        if (!is_null($indicator)) $this->indicators[] = $indicator;

        return $this;
    }
    
    /**
     * Gets the indicators.
     *
     * @return     array  The indicators.
     */
    public function getIndicators()
    {
        return $this->indicators;
    }

    /**
     * Evaluates the overall risk severity
     *
     * @return     self  The object.
     */
    public function evaluateOverallRisk()
    {
        // Holds information about severity levels of of all indicators
        $severity_levels = [];
        // Holds information about severity scores of of all indicators
        $severity_scores = [];
        if (!empty($this->indicators)) {
            while ($indicator = current($this->indicators)) {
                $severity_levels[] = $indicator->getSeverityLevel();
                $severity_scores[] = $indicator->getSeverityScore();

                // Moves to the next indicator
                next($this->indicators);
            }
        }
        // Orders severities by its levels
        $severity_levels = RiskLevel::sort($severity_levels);
        $this->severity['level'] = reset($severity_levels);
        // Orders severities by its scores
        arsort($severity_scores);
        $this->severity['score'] = reset($severity_scores);        
        
        return $this;
    }

    /**
     * Helper method
     *
     * @return     self  The object.
     */
    public function evaluate()
    {
    	$this->evaluateOverallRisk();

    	return $this;
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
     * Returns a string representation of the object.
     *
     * @return     string  String representation of the object.
     */
    public function __toString()
    {
        return $this->severity['level'];
    }
}