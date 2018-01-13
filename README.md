
# CYBER GATES ® Information Systems Security Assessment library  inspired by [OWASP risk rating methodology](https://www.owasp.org/index.php/OWASP_Risk_Rating_Methodology)

Introduction
------------

Information Systems Security Assessment library is a collection of methods used to evaluate risk in your Information Systems based on existing vulnerabilities and previous incidents.

Initially this library was designed for the [professional cloud-based security solution](https://onlineservices.cybergates.org/en/websecurity/) which allows you to determine the importance of potential risks to your online business. Please feel free to use this library in your projects and/or extend its functionality by creating new pull requests on Github.

More information about [CYBER GATES ® Web Application Compliance & Risk Management](https://onlineservices.cybergates.org/en/websecurity/) solution may be found here: https://news.cybergates.org/en/articles/how-secure-is-your-business.

Requirements
------------

This library requires PHP 5.4.0 or better to work properly. No other extensions or dependencies are required.

Installation
------------

### Via composer

#### Stable version

`php composer.phar require "cybergates/assessment"`

#### Latest development version

`php composer.phar require "cybergates/assessment":"dev-master"`

Example usage
-------------

(see `CompromiseIndicator.php`)

```php
use CYBERGATES\Assessment\Risk\Impact\Technical as TechnicalImpact;
use CYBERGATES\Assessment\Risk\Impact\Business as BusinessImpact;
use CYBERGATES\Assessment\Risk\Indicator\Compromise as CompromiseIndicator;

// This path needs to be configured properly
require __DIR__.'/../../../autoload.php';

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
```
If you change the status of a security event, then the risk severity level will be changed accordingly.
```php
$incident->setDetails([
    'status' => CompromiseIndicator::STATUS_RESOLVED
    ]);
```
Using risk manager for estimating the overall risk.
------------------

(see `RiskManager.php`)

Risk management helps you identify and address the risks facing your business
and in doing so increase the likelihood of successfully achieving your businesses objectives.
```php
use CYBERGATES\Assessment\Risk\Impact\Technical as TechnicalImpact;
use CYBERGATES\Assessment\Risk\Impact\Business as BusinessImpact;

use CYBERGATES\Assessment\Risk\Factor\Vulnerability as VulnerabilityFactor;
use CYBERGATES\Assessment\Risk\Factor\ThreatAgent as ThreatAgentFactor;

use CYBERGATES\Assessment\Risk\Indicator\Exposure as ExposureIndicator;
use CYBERGATES\Assessment\Risk\Indicator\Compromise as CompromiseIndicator;

use CYBERGATES\Assessment\Risk\Manager as RiskManager;

// This path needs to be configured properly
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
```
Using risk scoring system
--------------------------

(see `RiskScores.php`)

The risk scoring system is easy to use. You can get risk severity level
even by providing the the date an incident occurred.
  ```php
use CYBERGATES\Assessment\Risk\Severity\Level as RiskLevel;
use CYBERGATES\Assessment\Risk\Severity\Score as RiskScore;

// This path needs to be configured properly
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
  ```

Notes 
-----

The latest version of the package and example scripts resides at 
https://github.com/CYBERGATES/Assessment

Contributing
---------------

If you want to extend functionality or
correct a bug, feel free to create a new pull request on Github's
repository https://github.com/CYBERGATES/Assessment

Credits
-------

* Suren Gevorgyan <suren.gevorgyan@cybergates.org>
* Edgar Chraghyan <edgar@it-universalzone.com>
