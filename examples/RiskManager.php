<?php

use CYBERGATES\Assessment\Risk\Impact\Technical as TechnicalImpact;
use CYBERGATES\Assessment\Risk\Impact\Business as BusinessImpact;

use CYBERGATES\Assessment\Risk\Factor\Vulnerability as VulnerabilityFactor;
use CYBERGATES\Assessment\Risk\Factor\ThreatAgent as ThreatAgentFactor;

use CYBERGATES\Assessment\Risk\Indicator\Exposure as ExposureIndicator;
use CYBERGATES\Assessment\Risk\Indicator\Compromise as CompromiseIndicator;

use CYBERGATES\Assessment\Risk\Manager as RiskManager;

require __DIR__.'/../../../autoload.php';

$vulnerability = new ExposureIndicator();
$vulnerability
    ->setLikelihood(
        new ThreatAgentFactor(
            // How technically skilled is this group of threat agents?
            7,
            // How motivated is this group of threat agents to find and exploit this vulnerability?
            5,
            // What resources and opportunities are required for this group of threat agents to find and exploit this vulnerability?
            8,
            // How large is this group of threat agents?
            1
        ),
        new VulnerabilityFactor(
            // How easy is it for this group of threat agents to discover this vulnerability?
            9,
            // How easy is it for this group of threat agents to actually exploit this vulnerability?
            8,
            // How well known is this vulnerability to this group of threat agents?
            4,
            // How likely is an exploit to be detected?
            2
        ))
    ->setTechnicalImpact(
        new TechnicalImpact(
            // How much data could be disclosed and how sensitive is it?
            9,
            // How much data could be corrupted and how damaged is it?
            8,
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
            0,
            // How much exposure does non-compliance introduce?
            1,
            // How much personally identifiable information could be disclosed?
            2
        ));

$vulnerability->evaluate();
echo 'Vulnerability risk level is '. $vulnerability->getSeverityLevel()."\r\n";

// Example of an actual incident
$incident = new CompromiseIndicator();
$incident
    ->setTechnicalImpact(
        new TechnicalImpact(
            // How much data could be disclosed and how sensitive is it?
            9,
            // How much data could be corrupted and how damaged is it?
            1,
            // How much service could be lost and how vital is it?
            7,
            // Are the threat agents' actions traceable to an individual?
            9
        ))
    ->setBusinessImpact(
        new BusinessImpact(
            // How much financial damage will result from an exploit?
            1,
            // Would an exploit result in reputation damage that would harm the business?
            2,
            // How much exposure does non-compliance introduce?
            7,
            // How much personally identifiable information could be disclosed?
            9
        ));
$incident->setDetails([
    'date reported' => 1515890440, // 2018-01-14T00:40:40+00:00
    'status' => CompromiseIndicator::STATUS_OPEN
    ]);

$incident->evaluate();
echo 'Incident risk level is '. $incident->getSeverityLevel()."\r\n";

// Example of resolved incident
$incident2 = new CompromiseIndicator();
$incident2
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
$incident2->setDetails([
    'date reported' => 1515890440, // 2018-01-14T00:40:40+00:00
    'status' => CompromiseIndicator::STATUS_RESOLVED
    ]);

$incident2->evaluate();
echo 'Another incident risk level is '. $incident2->getSeverityLevel()."\r\n";

$riskManager = new RiskManager;
$riskManager->setIndicators([
    $vulnerability,
    $incident,
    $incident2
    ]);
$riskManager->evaluate();
echo 'Overall risk level is '. $riskManager->getSeverityLevel()."\r\n";