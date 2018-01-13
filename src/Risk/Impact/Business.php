<?php

/**
 * @namespace
 */
namespace CYBERGATES\Assessment\Risk\Impact;

class Business
{
    /**
     * Financial damage
     * how much financial damage will result from an exploit?
     * less than the cost to fix the vulnerability (1),
     * minor effect on annual profit (3),
     * significant effect on annual profit (7),
     * bankruptcy (9)
     */
    private $financial = 0;

    /**
     * Reputation damage
     * would an exploit result in reputation damage that would harm the business?
     * minimal damage (1),
     * loss of major accounts (4),
     * loss of goodwill (5),
     * brand damage (9)
     */
    private $reputation = 0;

    /**
     * Non-compliance
     * how much exposure does non-compliance introduce?
     * minor violation (2),
     * clear violation (5),
     * high profile violation (7)
     */
    private $noncompliance = 0;

    /**
     * Privacy violation
     * how much personally identifiable information could be disclosed?
     * one individual (3),
     * hundreds of people (5),
     * thousands of people (7),
     * millions of people (9)
     */
    private $privacy = 0;

    /**
     * Initializes the Constructor
     *
     * @param      integer  $financial      The financial damage
     * @param      integer  $reputation     The reputation damage
     * @param      integer  $noncompliance  The non-compliance
     * @param      integer  $privacy        The privacy violation
     */
    public function __construct($financial = 0, $reputation = 0, $noncompliance = 0, $privacy = 0)
    {
        $this->financial = $financial;
        $this->reputation = $reputation;
        $this->noncompliance = $noncompliance;
        $this->privacy = $privacy;
    }

    /**
     * Sets the financial impact.
     *
     * @param      integer  $value  The financial impact value
     *
     * @return     self  The object.
     */
    public function setFinancialDamage($value = 0)
    {
        if ($value > 0) $this->financial = $value;

        return $this;
    }

    /**
     * Gets the financial impact.
     *
     * @return     integer  The financial impact value.
     */
    public function getFinancialDamage()
    {
        return $this->financial;
    }

    /**
     * Sets the reputation impact.
     *
     * @param      integer  $value  The reputation impact value
     *
     * @return     self  The object.
     */
    public function setReputationDamage($value = 0)
    {
        if ($value > 0) $this->reputation = $value;

        return $this;
    }

    /**
     * Gets the reputation impact.
     *
     * @return     integer  The reputation impact value.
     */
    public function getReputationDamage()
    {
        return $this->reputation;
    }

    /**
     * Sets the non-compliance impact.
     *
     * @param      integer  $value  The non-compliance impact value
     *
     * @return     self  The object.
     */
    public function setNoncompliance($value = 0)
    {
        if ($value > 0) $this->noncompliance = $value;

        return $this;
    }

    /**
     * Gets the non-compliance impact.
     *
     * @return     integer  The non-compliance impact value.
     */
    public function getNoncompliance()
    {
        return $this->noncompliance;
    }

    /**
     * Sets the privacy impact.
     *
     * @param      integer  $value  The privacy impact value
     *
     * @return     self  The object.
     */
    public function setPrivacyViolation($value = 0)
    {
        if ($value > 0) $this->privacy = $value;

        return $this;
    }

    /**
     * Gets the privacy impact.
     *
     * @return     integer  The privacy impact value.
     */
    public function getPrivacyViolation()
    {
        return $this->privacy;
    }

    /**
     * Gets the overall impact.
     *
     * @return     array  The overall impact.
     */
    public function getOverallImpact()
    {
        return [
            'financial damage' => $this->financial,
            'reputation damage' => $this->reputation,
            'non-compliance' => $this->noncompliance,
            'privacy violation' => $this->privacy,
          ];
    }

    /**
     * Returns an array representation of the object.
     *
     * @return     array  Array representation of the object.
     */
    public function toArray()
    {
        return $this->getOverallImpact();
    }

    /**
     * Returns a string representation of the object.
     *
     * @return     string  String representation of the object.
     */
    public function __toString()
    {
        return (string)(($this->financial+$this->reputation+$this->noncompliance+$this->privacy)/4);
    }
}