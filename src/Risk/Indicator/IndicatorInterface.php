<?php

/**
 * @namespace
 */
namespace CYBERGATES\Assessment\Risk\Indicator;

/**
 * Interface class for risk indicators
 */
interface IndicatorInterface
{
    public function evaluate();
}