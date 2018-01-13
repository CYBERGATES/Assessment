<?php

use CYBERGATES\Assessment\Risk\Impact\Technical as TechnicalImpact;
use CYBERGATES\Assessment\Risk\Impact\Business as BusinessImpact;

use CYBERGATES\Assessment\Risk\Indicator\Compromise as CompromiseIndicator;

require __DIR__.'/../../../autoload.php';

// Example of an actual incident
$incident = new CompromiseIndicator();
$incident
    ->setTechnicalImpact(
        new TechnicalImpact(
            // How much data could be disclosed and how sensitive is it?
            9,
            // How much data could be corrupted and how damaged is it?
            7,
            // How much service could be lost and how vital is it?
            5,
            // Are the threat agents' actions traceable to an individual?
            8
        ))
    ->setBusinessImpact(
        new BusinessImpact(
            // How much financial damage will result from an exploit?
            1,
            // Would an exploit result in reputation damage that would harm the business?
            2,
            // How much exposure does non-compliance introduce?
            1,
            // How much personally identifiable information could be disclosed?
            5
        ));
$incident->setDetails([
    'date reported' => 1515890440, // 2018-01-14T00:40:40+00:00
    'status' => CompromiseIndicator::STATUS_OPEN
    ]);

$incident->evaluate();
echo 'Incident risk level is '. $incident->getSeverityLevel()."\r\n";

echo "\r\n";

// Example of resolved incident
$incident = new CompromiseIndicator();
$incident
    ->setTechnicalImpact(
        new TechnicalImpact(
            // How much data could be disclosed and how sensitive is it?
            9,
            // How much data could be corrupted and how damaged is it?
            7,
            // How much service could be lost and how vital is it?
            5,
            // Are the threat agents' actions traceable to an individual?
            8
        ))
    ->setBusinessImpact(
        new BusinessImpact(
            // How much financial damage will result from an exploit?
            1,
            // Would an exploit result in reputation damage that would harm the business?
            2,
            // How much exposure does non-compliance introduce?
            1,
            // How much personally identifiable information could be disclosed?
            5
        ));
$incident->setDetails([
    'date reported' => 1515890440, // 2018-01-14T00:40:40+00:00
    'status' => CompromiseIndicator::STATUS_RESOLVED
    ]);

$incident->evaluate();
echo 'Incident risk level is '. $incident->getSeverityLevel()."\r\n";