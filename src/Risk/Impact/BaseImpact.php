<?php

/**
 * @namespace
 */
namespace CYBERGATES\Assessment\Risk\Impact;

/**
 * Base class for risk impacts
 */
class BaseImpact implements \ArrayAccess, \Countable
{
    protected $impacts = array();

    /**
     * Checks if impact exists
     *
     * @param       string  $offset  The impact name
     * 
     * @return      bool The result.
     */
    public function offsetExists ($offset)
    {
        return array_key_exists($offset, $this->impacts);
    }

    /**
     * Gets an impact
     *
     * @param       string  $offset  The impact name
     * 
     * @return      integer The impact value.
     */
    public function offsetGet ($offset)
    {
        return $this->impacts[$offset];
    }

    /**
     * Sets an impact
     *
     * @param      string  $offset  The impact name
     * @param      integer $value The impact value
     * 
     * @return void
     */
    public function offsetSet ($offset, $value)
    {
        $this->impacts[$offset] = $value;
    }

    /**
     * Removes an impact
     *
     * @param      string  $offset  The impact name
     * 
     * @return void
     */
    public function offsetUnset ($offset)
    {
        unset($this->impacts[$offset]);
    }

    /**
     * Counts total number of impacts
     *
     * @return     integer  The total number of impacts.
     */
    public function count()
    {
        return count($this->impacts);
    }

    /**
     * Counts sum of all impacts
     *
     * @return     array  The sum of impacts.
     */
    public function sum()
    {
        return array_sum($this->impacts);
    }
}