<?php

use CYBERGATES\Assessment\Risk\Severity\Level as RiskLevel;
use CYBERGATES\Assessment\Risk\Severity\Score as RiskScore;

require __DIR__.'/../../../autoload.php';

echo "Min threshold for high level risk score is ".RiskScore::SCORE_HIGH_MIN."\r\n";
echo "Risk severity level for 9.2 score is ".RiskLevel::getByScore(9.2)."\r\n";
echo "If a security event occured on '2017-11-20T07:08:11+00:00' then risk severity level is ".RiskLevel::getByDate(1511161691)."\r\n";
echo "You can sort a list of risk severity levels:\r\n";
$levels = RiskLevel::sort([
    'medium',
    'none',
    'high',
    'low',
    'critical',
    'high'
    ]);
var_dump($levels);
echo "\r\n";
echo "You can get overall risk level by risk matrix('medium','critical'):\r\n";
echo RiskLevel::getByMatrix('medium', 'critical');
