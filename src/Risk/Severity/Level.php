<?php

/**
 * @namespace
 */
namespace CYBERGATES\Assessment\Risk\Severity;

use CYBERGATES\Assessment\Risk\Severity\Score;

class Level
{
    /**
     * Secerity levels
     * 
     * @var        string
     */
    const LEVEL_NONE     = 'none';
    const LEVEL_LOW      = 'low';
    const LEVEL_MEDIUM   = 'medium';
    const LEVEL_HIGH     = 'high';
    const LEVEL_CRITICAL = 'critical';

    /**
     * Gets the risk severity level based on qualitative rating (score)
     *
     * @param      integer  $score  The score
     *
     * @return     string   The severity level.
     */
	public static function getByScore($score = 0)
    {
	    $score = round($score, 2, PHP_ROUND_HALF_DOWN);
	    
	    return self::getByProbability($score * 10);
	}
    
    /**
     * Gets the risk severity level based on attack probability
     *
     * @param      integer  $probability  The probability
     *
     * @return     string   The severity level.
     */
	public static function getByProbability($probability = 0)
    {
	    $probability = intval(round($probability, 0, PHP_ROUND_HALF_DOWN));

        $low = array("options" =>
                            array("min_range" => Score::SCORE_LOW_MIN, "max_range" => Score::SCORE_LOW_MAX));
        $medium = array("options" =>
                            array("min_range" => Score::SCORE_MEDIUM_MIN, "max_range" => Score::SCORE_MEDIUM_MAX));
        $high = array("options" =>
                            array("min_range" => Score::SCORE_HIGH_MIN, "max_range" => Score::SCORE_HIGH_MAX));
        $critical = array("options" =>
                            array("min_range" => Score::SCORE_CRITICAL_MIN));

        if (filter_var($probability, FILTER_VALIDATE_INT, $low))
            return self::LEVEL_LOW;
        if (filter_var($probability, FILTER_VALIDATE_INT, $medium))
            return self::LEVEL_MEDIUM;
        if (filter_var($probability, FILTER_VALIDATE_INT, $high))
            return self::LEVEL_HIGH;
        if (filter_var($probability, FILTER_VALIDATE_INT, $critical))
            return self::LEVEL_CRITICAL;
        
        return self::LEVEL_NONE;
	}

    /**
     * Determins the risk severity level based on successfull attack date
     *
     * Never            None    
     * Years ago        Low
     * Last year        Medium
     * Last 28 days     High
     * Last 48 hours    Critical
     *
     * @param      integer  $timestamp  The timestamp
     *
     * @return     string   The severity level.
     */
    public static function getByDate($timestamp = null)
    {
        if (null === $date) $date = time();
        
        // Converts texts to unix timestamps if not numeric 
        if (strtotime(date('d-m-Y H:i:s', $timestamp)) === (int)$timestamp)
            $date = $timestamp;
        else
            return strtotime($timestamp);

        // Gets the current timestamp
        $now = time();
        // Calculates the difference
        $difference = abs($now - $date);
        // Converts seconds into days
        $days = floor($difference / (60*60*24));
        
        $low = array("options" =>
                            array("min_range" => 366));
        $medium = array("options" =>
                            array("min_range" => 29, "max_range" => 365));
        $high = array("options" =>
                            array("min_range" => 3, "max_range" => 28));
        $critical = array("options" =>
                            array("min_range" => 0, "max_range" => 2));
        
        if (filter_var($days, FILTER_VALIDATE_INT, $low))
            return self::LEVEL_LOW;
        if (filter_var($days, FILTER_VALIDATE_INT, $medium))
            return self::LEVEL_MEDIUM;
        if (filter_var($days, FILTER_VALIDATE_INT, $high))
            return self::LEVEL_HIGH;
        if (filter_var($days, FILTER_VALIDATE_INT) === 0 ||
            filter_var($days, FILTER_VALIDATE_INT, $critical))
            return self::LEVEL_CRITICAL;
        
        return self::LEVEL_NONE;
    }

    /**
     * Determins the risk severity level based on two level matrix
     *
     * 0—2      None / false positive
     * 2—5      Low
     * 6—11     Medium
     * 12—16    High
     * 17-25    Critical
     *
     * @param      strng  $level1  The first severity level
     * @param      strng  $level2  The second severity level
     *
     * @return     string   The severity level.
     */
    public static function getByMatrix($level1 = self::LEVEL_NONE, $level2 = self::LEVEL_NONE)
    {
        $risk = Score::getByLevel($level1, Score::SCORE_SYSTEM_5) * Score::getByLevel($level2, Score::SCORE_SYSTEM_5);
        
        $low = array("options" =>
                            array("min_range" => 2, "max_range" => 5));
        $medium = array("options" =>
                            array("min_range" => 6, "max_range" => 11));
        $high = array("options" =>
                            array("min_range" => 12, "max_range" => 16));
        $critical = array("options" =>
                            array("min_range" => 17, "max_range" => 25));
        
        if (filter_var($risk, FILTER_VALIDATE_INT, $low))
            return self::LEVEL_LOW;
        if (filter_var($risk, FILTER_VALIDATE_INT, $medium))
            return self::LEVEL_MEDIUM;
        if (filter_var($risk, FILTER_VALIDATE_INT, $high))
            return self::LEVEL_HIGH;
        if (filter_var($risk, FILTER_VALIDATE_INT, $critical))
            return self::LEVEL_CRITICAL;
        
        return self::LEVEL_NONE;
    }

    /**
     * Sorts severity levels and removes dublicate values
     *
     * @param array $levels List of severity levels
     * 
     * @return array Returns the ordered list of severity levels.
     */
    public static function sort($levels = array())
    {
        $tmp = [];
        foreach ($levels as $level) {
            $tmp[Score::getByLevel($level)] = $level;
        }
        $levels = $tmp;
        krsort($levels);
        
        return $levels;
    }
}