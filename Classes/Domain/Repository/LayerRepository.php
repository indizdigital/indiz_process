<?php
namespace Indiz\Process\Domain\Repository;

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
 use TYPO3\CMS\Core\Utility\GeneralUtility;
 use TYPO3\CMS\Core\Database\ConnectionPool;
 use TYPO3\CMS\Core\Database\Query\Restriction\FrontendRestrictionContainer;
 use \TYPO3\CMS\Extbase\Persistence\Generic\Mapper\DataMapper;
 use Indiz\Process\Domain\Model\Layer;

/**
 * The repository for Layer
 */
class LayerRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{

    public $table = "tx_process_domain_model_layer";
    public function findLayers(&$start_layer){
        
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable($this->table);
        //fe_group restriction
        $queryBuilder->getRestrictions()->add(GeneralUtility::makeInstance(FrontendRestrictionContainer::class));
        $queryBuilder->select("*")->from($this->table);

        $dataMapper = GeneralUtility::makeInstance(DataMapper::class);
        $rows = $dataMapper->map(
            Layer::class,
            $queryBuilder->executeQuery()->fetchAllAssociative()
        );

        $hierarchic = [];
        
        
        foreach($rows as $row){
            
            if($row->getParentLayer() == 0){
                $start_layer = $row->getUid();
            }
            $hierarchic[$row->getUid()] = $row;
        }
        return $hierarchic;
    }

    public function getNextLayer($layer_uid){
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable($this->table);
        //fe_group restriction
        $queryBuilder->getRestrictions()->add(GeneralUtility::makeInstance(FrontendRestrictionContainer::class));
        $res = $queryBuilder->select("*")->from($this->table)->where(
            $queryBuilder->expr()->eq('parent_layer', $queryBuilder->createNamedParameter($layer_uid))
        );

        $dataMapper = GeneralUtility::makeInstance(DataMapper::class);
        $rows = $dataMapper->map(
            Layer::class,
            $queryBuilder->executeQuery()->fetchAllAssociative()
        );
        
        return count($rows)?array_shift($rows):NULL;
    }
}