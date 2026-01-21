<?php
namespace Indiz\Process\Domain\Model;

/***
 *
 * This file is part of the "News" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2019
 *
 ***/

/**
 * Entity
 */
class Entity extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * title
     *
     * @var string
     */
    protected $title = '';

    /**
     * state
     *
     * @var string
     */
    protected $state = '';

    /**
     * values
     *
     * @var array
     */
    protected $values = [];

    /**
     * __construct
     */
    public function __construct()
    {
        //Do not remove the next line: It would break the functionality
        $this->initStorageObjects();
    }

    /**
     * Initializes all ObjectStorage properties
     * Do not modify this method!
     * It will be rewritten on each save in the extension builder
     * You may modify the constructor of this class instead
     *
     * @return void
     */
    protected function initStorageObjects()
    {
        //$this->category = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * Returns the title
     *
     * @return string $title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Sets the title
     *
     * @param string $title
     * @return void
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Returns the State
     *
     * @return string $state
     */
    public function getState()
    {
        return json_decode($this->state,true);
    }

    /**
     * Sets the state
     *
     * @param string $state
     * @return void
     */
    public function setState($state)
    {
        $this->state = json_encode($state);
    }

    /**
     * Returns the Layer
     *
     * @return string $state
     */
    public function getLayer()
    {
        return isset($this->getState()["layer"])? $this->getState()["layer"]:0;
    }

    /**
     * Returns the values
     *
     * @return string $values
     */
    public function getValues()
    {
        return $this->values;
    }

    /**
     * Sets the values
     *
     * @param string $values
     * @return void
     */
    public function setValues($values)
    {
        $this->values = $values;
    }
}
