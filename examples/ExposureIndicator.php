<?php

use CYBERGATES\Assessment\Risk\Impact\Technical as TechnicalImpact;
use CYBERGATES\Assessment\Risk\Impact\Business as BusinessImpact;

use CYBERGATES\Assessment\Risk\Factor\Vulnerability as VulnerabilityFactor;
use CYBERGATES\Assessment\Risk\Factor\ThreatAgent as ThreatAgentFactor;

use CYBERGATES\Assessment\Risk\Indicator\Exposure as ExposureIndicator;

require __DIR__.'/../../../autoload.php';

$vulnerability = new ExposureIndicator();
$vulnerability
    ->setLikelihood(
        new ThreatAgentFactor(
            // How technically skilled is this group of threat agents?
            5,
            // How motivated is this group of threat agents to find and exploit this vulnerability?
            2,
            // What resources and opportunities are required for this group of threat agents to find and exploit this vulnerability?
            7,
            // How large is this group of threat agents?
            1
        ),
        new VulnerabilityFactor(
            // How easy is it for this group of threat agents to discover this vulnerability?
            3,
            // How easy is it for this group of threat agents to actually exploit this vulnerability?
            6,
            // How well known is this vulnerability to this group of threat agents?
            9,
            // How likely is an exploit to be detected?
            2
        ))
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

$vulnerability->evaluate();
echo 'Vulnerability risk level is '. $vulnerability->getSeverityLevel();