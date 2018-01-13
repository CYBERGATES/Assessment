<?php

/**
 * @namespace
 */
namespace CYBERGATES\Assessment\Risk\Impact;

class Technical
{
    /**
     * Loss of confidentiality
     * how much data could be disclosed and how sensitive is it?
     * minimal non-sensitive data disclosed (2),
     * minimal critical data disclosed (6),
     * extensive non-sensitive data disclosed (6),
     * extensive critical data disclosed (7),
     * all data disclosed (9)
     */
    private $confidentiality = 0;

    /**
     * Loss of integrity
     * how much data could be corrupted and how damaged is it?
     * minimal slightly corrupt data (1),
     * minimal seriously corrupt data (3),
     * extensive slightly corrupt data (5),
     * extensive seriously corrupt data (7),
     * all data totally corrupt (9)
     */
    private $integrity = 0;

    /**
     * Loss of availability
     * how much service could be lost and how vital is it?
     * minimal secondary services interrupted (1),
     * minimal primary services interrupted (5),
     * extensive secondary services interrupted (5),
     * extensive primary services interrupted (7),
     * all services completely lost (9) 
     */
    private $availability = 0;

    /**
     * Loss of accountability
     * are the threat agents' actions traceable to an individual?
     * fully traceable (1),
     * possibly traceable (7),
     * completely anonymous (9)
     */
    private $accountability = 0;

    /**
     * Initializes the Constructor
     *
     * @param      integer  $confidentiality  The loss of confidentiality
     * @param      integer  $integrity        The loss of integrity
     * @param      integer  $availability     The loss of availability
     * @param      integer  $accountability   The loss of accountability
     */
    public function __construct($confidentiality = 0, $integrity = 0, $availability = 0, $accountability = 0)
    {
        $this->confidentiality = $confidentiality;
        $this->integrity = $integrity;
        $this->availability = $availability;
        $this->accountability = $accountability;
    }

    /**
     * Sets the confidentiality impact.
     *
     * @param      integer  $value  The confidentiality impact value
     *
     * @return     self  The object.
     */
    public function setConfidentialityLoss($value = 0)
    {
        if ($value > 0) $this->confidentiality = $value;

        return $this;
    }

    /**
     * Gets the confidentiality impact.
     *
     * @return     integer  The confidentiality impact value.
     */
    public function getConfidentialityLoss()
    {
        return $this->confidentiality;
    }

    /**
     * Sets the integrity impact.
     *
     * @param      integer  $value  The integrity impact value
     *
     * @return     self  The object.
     */
    public function setIntegrityLoss($value = 0)
    {
        if ($value > 0) $this->integrity = $value;

        return $this;
    }

    /**
     * Gets the integrity impact.
     *
     * @return     integer  The integrity impact value.
     */
    public function getIntegrityLoss()
    {
        return $this->integrity;
    }

    /**
     * Sets the availability impact.
     *
     * @param      integer  $value  The availability impact value
     *
     * @return     self  The object.
     */
    public function setAvailabilityLoss($value = 0)
    {
        if ($value > 0) $this->availability = $value;

        return $this;
    }

    /**
     * Gets the availability impact.
     *
     * @return     integer  The availability impact value.
     */
    public function getAvailabilityLoss()
    {
        return $this->availability;
    }

    /**
     * Sets the accountability impact.
     *
     * @param      integer  $value  The accountability impact value
     *
     * @return     self  The object.
     */
    public function setAccountabilityLoss($value = 0)
    {
        if ($value > 0) $this->accountability = $value;

        return $this;
    }

    /**
     * Gets the accountability impact.
     *
     * @return     integer  The accountability impact value.
     */
    public function getAccountabilityLoss()
    {
        return $this->accountability;
    }

    /**
     * Gets the overall impact.
     *
     * @return     array  The overall impact.
     */
    public function getOverallImpact()
    {
        return [
            'loss of confidentiality' => $this->confidentiality,
            'loss of integrity' => $this->integrity,
            'loss of availability' => $this->availability,
            'loss of accountability' => $this->accountability,
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
        return (string)(($this->confidentiality+$this->integrity+$this->availability+$this->accountability)/4);
    }
}