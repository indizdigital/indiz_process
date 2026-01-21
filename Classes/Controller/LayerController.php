<?php
namespace Indiz\Process\Controller;

/***
 *
 * This file is part of the "Hersteller" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2018
 *
 ***/
use \TYPO3\CMS\Extbase\Annotation\Inject;
use \TYPO3\CMS\Core\Utility\GeneralUtility;
use \TYPO3\CMS\Core\Context\Context;
use \Indiz\Process\Domain\Model\Entity;

use TYPO3\CMS\Core\FormProtection\FormProtectionFactory;
/**
 * layerController
 */
class LayerController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    public $layerRepository;

    /*
    * @param \Indiz\Process\Domain\Repository\LayerRepository $layerRepository
    */
    public function injectLayerRepository(\Indiz\Process\Domain\Repository\LayerRepository $layerRepository)
    {
      $this->layerRepository = $layerRepository;
    }
    
    public $entityRepository;

    /*
    * @param \Indiz\Process\Domain\Repository\EntityRepository $entityRepository
    */
    public function injectEntityRepository(\Indiz\Process\Domain\Repository\EntityRepository $entityRepository)
    {
      $this->entityRepository = $entityRepository;
    }

    /**
     * action list
     *
     * @param \Indiz\Process\Domain\Model\Entity $entity
     * @return void
     */
    public function listAction(Entity $entity = NULL)
    {
      
        if(!$entity){
          $entity = GeneralUtility::makeInstance(Entity::class);
        }
        $this->entityRepository->loadEntityValues($entity);
        
        $current_layer = 0;
        $layers = $this->layerRepository->findLayers($current_layer);
        
        $this->view->assign("layers",$layers);
        $this->view->assign("entity",$entity);
        if($this->request->hasArgument("layer")){
          
          $entity->setState(["layer"=>$this->request->getArgument("layer")]);
          $this->entityRepository->update($entity);
        }
        $this_layer = ($entity->getLayer()?:$current_layer);
        
        $this->view->assign("next_layer",$this->layerRepository->getNextLayer($this_layer));
        $this->view->assign("current_layer",$this_layer);
        return $this->htmlResponse();

    }
}
