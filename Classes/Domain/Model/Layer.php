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
 * Layer
 */
class Layer extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * title
     *
     * @var string
     */
    protected $title = '';

    /**
     * parentLayer
     *
     * @var \Indiz\Process\Domain\Model\Layer
     */
    protected $parentLayer = NULL;

    /**
     * image
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $image = null;

    /**
     * pdf
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $pdf = null;

    /**
     * elements
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Indiz\Process\Domain\Model\Element>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $elements = null;

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
        $this->elements = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
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
     * Returns the parent_layer
     *
     * @return \Indiz\Process\Domain\Model\Layer $parent_layer
     */
    public function getParentLayer()
    {
        return $this->parentLayer;
    }

    /**
     * Sets the parentLayer
     *
     * @param \Indiz\Process\Domain\Model\Layer $parent_layer
     * @return void
     */
    public function setParentLayer(\Indiz\Process\Domain\Model\Layer $parent_layer)
    {
        $this->parentLayer = $parent_layer;
    }

    /**
     * Returns the elements
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage $elements
     */
    public function getElements()
    {
        return $this->elements;
    }

    /**
     * Sets the elements
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $elements
     * @return void
     */
    public function setElements($elements)
    {
        $this->elements = $elements;
    }
}
