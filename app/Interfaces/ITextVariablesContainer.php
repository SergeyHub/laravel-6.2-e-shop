<?php


namespace App\Interfaces;

/**
 * Interface ITextVariablesContainer
 * Represents object, they can be used as Text Variables source for _rv() helper
 *
 * @package App\Interfaces
 */
interface ITextVariablesContainer
{
    /**
     * Returns Text Variables from this object
     *
     * @return array;
     */
    function variables();
}