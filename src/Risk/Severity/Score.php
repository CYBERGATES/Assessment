<?php

/**
 * @namespace
 */
namespace CYBERGATES\Assessment\Risk\Severity;

use CYBERGATES\Assessment\Risk\Severity\Level;

class Score
{
    /**
     * Severity scores
     * CVSS score range Severity in advisory
     * https://www.first.org/cvss/specification-document#5-Qualitative-Severity-Rating-Scale
     * 0—2.9	None / false positive
     * 3—39     Low
     * 40—69    Medium
     * 70—89    High
     * 90-100   Critical
     * 
     * @var        integer
     */
    const SCORE_LOW_MIN      = self::THRESHOLD_FALSE_POSITIVE;
    const SCORE_LOW_MAX      = 39;
    const SCORE_MEDIUM_MIN   = 40;
    const SCORE_MEDIUM_MAX   = 69;
    const SCORE_HIGH_MIN     = 70;
    const SCORE_HIGH_MAX     = 89;
    const SCORE_CRITICAL_MIN = 90;
    const SCORE_CRITICAL_MAX = 100;

    /**
     * Severity score based on 5 point rating system
     * 
     * 0.0—0.15	   None / false positive / rare / insignificant
     * 0.16—1.9    Low / unlikely / minor
     * 2.0—2.9     Medium / possible / moderate
     * 3.0—3.9     High / likely / major
     * 4.0—5.0     Critical / almost certain / catastrophic
     * 
     * @var        integer
     */
    const SCORE_SYSTEM_5   = 5;
    
    /**
     * Severity score based on 10 point rating system
     * 
     * 0.0—0.29	   None / false positive / rare / insignificant
     * 0.3—3.9     Low / unlikely / minor
     * 4.0—6.9     Medium / possible / moderate
     * 7.0—8.9     High / likely / major
     * 9.0-10.0    Critical / almost certain / catastrophic
     * 
     * @var        integer
     */
    const SCORE_SYSTEM_10  = 10;
    
    /**
     * Severity score based on 100 point rating system
     * 
     * 0.0—2.9	None / false positive / rare / insignificant
     * 3—39     Low / unlikely / minor
     * 40—69    Medium / possible / moderate
     * 70—89    High / likely / major
     * 90-100   Critical / almost certain / catastrophic
     * 
     * @var        integer
     */
    const SCORE_SYSTEM_100 = 100;

    /**
     * Defines threshold for false positive detections
     * False positive threshold for probability is 3%
     * 
     * @var        integer
     */
    const THRESHOLD_FALSE_POSITIVE = 3;

    /**
     * Gets the risk severity score based on its level
     *
     * @param      string  $level  The severity level
     * @param      integer $system The severity scoring system
     *
     * @return     string   The severity score.
     */
    public static function getByLevel($level = Level::LEVEL_NONE, $system = self::SCORE_SYSTEM_10)
    {
        /*if ($system === self::SCORE_SYSTEM_100) {
        	$levels = [
	            // rare / insignificant
	            'none' => 0,
	            // unlikely / minor
	            'low' => self::SCORE_LOW_MIN,
	            // possible / moderate
	            'medium' => self::SCORE_MEDIUM_MIN,
	            // likely / major
	            'high' => self::SCORE_HIGH_MIN,
	            // almost certain / catastrophic
	            'critical' => self::SCORE_CRITICAL_MIN,
	        ];
        } else if ($system === self::SCORE_SYSTEM_5) {
        	$levels = [
	            // rare / insignificant
	            'none' => 0,
	            // unlikely / minor
	            'low' => 0.16,
	            // possible / moderate
	            'medium' => 2,
	            // likely / major
	            'high' => 3,
	            // almost certain / catastrophic
	            'critical' => 4,
	        ];
        } else {
        	$levels = [
	            // rare / insignificant
	            'none' => 0,
	            // unlikely / minor
	            'low' => 0.3,
	            // possible / moderate
	            'medium' => 4,
	            // likely / major
	            'high' => 7,
	            // almost certain / catastrophic
	            'critical' => 9,
	        ];
        }*/

        if ($system === self::SCORE_SYSTEM_100) {
        	$levels = [
	            // rare / insignificant
	            'none' => 2.9,
	            // unlikely / minor
	            'low' => self::SCORE_LOW_MAX,
	            // possible / moderate
	            'medium' => self::SCORE_MEDIUM_MAX,
	            // likely / major
	            'high' => self::SCORE_HIGH_MAX,
	            // almost certain / catastrophic
	            'critical' => self::SCORE_CRITICAL_MAX,
	        ];
        } else if ($system === self::SCORE_SYSTEM_5) {
        	$levels = [
	            // rare / insignificant
	            'none' => 0.15,
	            // unlikely / minor
	            'low' => 1.9,
	            // possible / moderate
	            'medium' => 2.9,
	            // likely / major
	            'high' => 3.9,
	            // almost certain / catastrophic
	            'critical' => 5.0,
	        ];
        } else {
        	$levels = [
	            // rare / insignificant
	            'none' => 0.29,
	            // unlikely / minor
	            'low' => 3.9,
	            // possible / moderate
	            'medium' => 6.9,
	            // likely / major
	            'high' => 8.9,
	            // almost certain / catastrophic
	            'critical' => 10.0,
	        ];
        }

        if (isset($levels[$level])) return intval(round($levels[$level], 0, PHP_ROUND_HALF_DOWN));
    }

}