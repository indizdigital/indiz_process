<?php
defined('TYPO3') || die('Access denied.');

call_user_func(
    function()
    {

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'IndizProcess',
            'Process',
            [
                Indiz\Process\Controller\StepController::class => 'list, show,filter'
            ],
            // non-cacheable actions
            [
            ],
            'CType'
        );


    }
);
