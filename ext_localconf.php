<?php
defined('TYPO3') || die('Access denied.');

call_user_func(
    function()
    {

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'IndizProcess',
            'Process',
            [
                Indiz\Process\Controller\EntityController::class => 'list, save',
                Indiz\Process\Controller\LayerController::class => 'list'
            ],
            // non-cacheable actions
            [
                Indiz\Process\Controller\EntityController::class => 'list,save',
                Indiz\Process\Controller\LayerController::class => 'list'
            ],
            'CType'
        );


    }
);
