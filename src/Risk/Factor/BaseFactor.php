<?php

/**
 * @namespace
 */
namespace CYBERGATES\Assessment\Risk\Factor;

/**
 * Base class for risk factors
 */
class BaseFactor implements
    \ArrayAccess,
    \Countable
{
    protected $factors = array();

    /**
     * Checks if factor exists
     *
     * @param       string  $offset  The factor name
     * 
     * @return      bool The result.
     */
    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->factors);
    }

    /**
     * Gets a factor
     *
     * @param       string  $offset  The factor name
     * 
     * @return      integer The factor value.
     */
    public function offsetGet($offset)
    {
        return $this->factors[$offset];
    }

    /**
     * Sets a factor
     *
     * @param      string  $offset  The factor name
     * @param      integer $value The factor value
     * 
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        $this->factors[$offset] = $value;
    }

    /**
     * Removes a factor
     *
     * @param      string  $offset  The factor name
     * 
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->factors[$offset]);
    }

    /**
     * Counts total number of factors
     *
     * @return     integer  The total number of factors.
     */
    public function count()
    {
        return count($this->factors);
    }

    /**
     * Counts sum of all factors
     *
     * @return     array  The sum of factors.
     */
    public function sum()
    {
        return array_sum($this->factors);
    }

    /**
     * Returns an array representation of the object.
     *
     * @return     array  Array representation of the object.
     */
    public function toArray()
    {
        return $this->factors;
    }
}