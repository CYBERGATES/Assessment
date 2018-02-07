<?php

/**
 * @namespace
 */
namespace CYBERGATES\Assessment\Risk\Factor;

use CYBERGATES\Assessment\Risk\Factor\BaseFactor;

/**
 * ThreatAgent as a risk factor
 */
class ThreatAgent extends BaseFactor
{
    protected $factors = array();
    
    /**
     * Initializes the Constructor
     *
     * Skill levely
     * how technically skilled is this group of threat agents?
     * security penetration skills (9),
     * network and programming skills (6),
     * advanced computer user (5),
     * some technical skills (3),
     * no technical skills (1)
     * @param      integer  $skills    The skill level
     * 
     * Motive
     * how motivated is this group of threat agents to find and exploit this vulnerability?
     * low or no reward (1),
     * possible reward (4),
     * high reward (9)
     * @param      integer  $motive     The motive
     * 
     * Opportunity
     * what resources and opportunities are required for this group of threat agents to find and exploit this vulnerability?
     * full access or expensive resources required (0),
     * special access or resources required (4),
     * some access or resources required (7),
     * no access or resources required (9)
     * @param      integer  $opportunity       The opportunity
     * 
     * Size
     * how large is this group of threat agents?
     * developers (2), system administrators (2),
     * intranet users (4),
     * partners (5),
     * authenticated users (6),
     * anonymous Internet users (9)
     * @param      integer  $size      The size
     */
    public function __construct($skills = 0, $motive = 0, $opportunity = 0, $size = 0)
    {
        $this->factors['skill level'] = $skills;
        $this->factors['motive']      = $motive;
        $this->factors['opportunity'] = $opportunity;
        $this->factors['size']        = $size;
    }
}