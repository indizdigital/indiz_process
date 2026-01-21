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

use TYPO3\CMS\Core\FormProtection\FormProtectionFactory;
/**
 * EntityController
 */
class EntityController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
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
     * @return void
     */
    public function listAction()
    {
          
        $this->view->assign("entities",$this->entityRepository->findAllSorted());
          return $this->htmlResponse();

    }

    /**
     * action save
     *
     * @param \Indiz\Process\Domain\Model\Entity $entity
     * @return void
     */
    public function saveAction(\Indiz\Process\Domain\Model\Entity $entity)
    {
        
        if($this->request->hasArgument("element_values") ){
          $this->entityRepository->updateVals($entity,$this->request->getArgument("element_values"));
        }
        $args = ["entity"=>$entity];
        if($this->request->hasArgument("layer") ){
          $args["layer"] = $this->request->getArgument("layer");
        }
        
        return $this->redirect("list","Layer",null,$args);
    }

    /**
     * getCSRF
     *
     * @param string $formName
     * @param string $action
     * @param string $formInstanceName
     * @return \string
     */
    public function getCSRF($formName, $action = '', $formInstanceName = ''){
      $formProtectionFactory = GeneralUtility::makeInstance(FormProtectionFactory::class);
      $formProtection = $formProtectionFactory->createForType('frontend');

      return $formProtection ->generateToken($formName, $action, $formInstanceName);
    }

    /**
     * validateCSRF
     *
     * @param string $formName
     * @param string $action
     * @param string $formInstanceName
     * @return bool
     */
    public function validateCSRF($formName, $action = '', $formInstanceName = ''){
      $csrf = $this->getArgument("csrf","string","POST");
      $formProtectionFactory = GeneralUtility::makeInstance(FormProtectionFactory::class);
      $formProtection = $formProtectionFactory->createForType('frontend');

      $csrfIsValid = $formProtection->validateToken($csrf,$formName, $action, $formInstanceName);
      //dismiss csrf token if it is an adminviewer
      $user = GeneralUtility::makeInstance(Context::class)->getAspect('frontend.user');
      if($user->isFeAdminViewer()){
        $csrfIsValid = false;
      }
      //dismiss csrf token if it is an adminviewer

      return $csrfIsValid;
    }

    /**
     * validateCSRF
     *
     * @param \array $params
     * @return void
     */
    public function securityCheck($params){
      $valid = true;
      if(isset($params["csrf"])){
        $csrfValidation = $this->validateCSRF($params["csrf"]["formName"],$params["csrf"]["action"],$params["csrf"]["formInstanceName"]);
        if(!$csrfValidation){
          $valid = false;
          error_log("CSRF Token Error".$params["csrf"]["formName"].$params["csrf"]["action"]. " - " . $this->getArgument("csrf","string","POST"));
        }
      }
      if(isset($params["auth"])){
        $manufacturer = isset($params["auth"]["manufacturer"])?$params["auth"]["manufacturer"]:0;

         $user = GeneralUtility::makeInstance(Context::class)->getAspect('frontend.user');
         $isAdmin = $user->isFeAdmin();
        if(!$isAdmin && (isset($params["auth"]["adminAssert"]) && $params["auth"]["adminAssert"])){
          $valid = false;
        }elseif($manufacturer){
          $currentManufacturer = $this->supplierService->checkSupplier();
          if($manufacturer->getParentManufacturer()){
            if($manufacturer->getParentManufacturer()->getUid() !== $currentManufacturer->getUid()){
              $valid = false;

              error_log("Parent Authorization Error");
            }
          }elseif($currentManufacturer){
            if($manufacturer->getUid() !== $currentManufacturer->getUid()){
              $valid = false;
              error_log("Authorization Error");
            }
          }
          if($isAdmin && (isset($params["auth"]["adminAllowed"]) && !$params["auth"]["adminAllowed"])){
            $valid = false;
          }
        }else{
          $valid = false;
          error_log("Entity Error");
        }
      }
      if(!$valid){
        $this->securityError();
      }

	return $valid;
    }

	public function securityRedirect($pageUid = 4){
          	$uri = $this->uriBuilder->setTargetPageUid($pageUid)->build();
          	return $this->redirectToURI($uri);
	}
}
