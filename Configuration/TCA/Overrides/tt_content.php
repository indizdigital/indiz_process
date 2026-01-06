<?php


$pluginSignature = \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'IndizProcess',
            'Process',
            'Process'
        );
        

/*
$GLOBALS['TCA']['tt_content']['types'][$pluginSignature] = array_replace_recursive(
    $GLOBALS['TCA']['tt_content']['types'][$pluginSignature],
    [
        'showitem' => '
            --div--;General,
            --palette--;General;general,
            --palette--;Headers;headers,
            --div--;Options,
            pi_flexform'
    ]
);*/