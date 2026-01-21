<?php
namespace Indiz\Process\Services;

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

/**
 * EntityController
 */
class Session
{
    public $request;

    
    private function getFrontendUser(): FrontendUserAuthentication
    {
        // This will create an anonymous frontend user if none is logged in
        return $this->request->getAttribute('frontend.user');
    }

}