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
 use TYPO3\CMS\Core\Database\Connection;
 use TYPO3\CMS\Core\Database\Query\Restriction\FrontendRestrictionContainer;
 use \TYPO3\CMS\Extbase\Persistence\Generic\Mapper\DataMapper;
 use Indiz\Process\Domain\Model\Entity;

/**
 * The repository for Entity
 */
class EntityRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{

    public $table = "tx_process_domain_model_entity";
    public function findAllSorted(){
        
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable($this->table);
        //fe_group restriction
        $queryBuilder->getRestrictions()->add(GeneralUtility::makeInstance(FrontendRestrictionContainer::class));
        $queryBuilder->select("*")->from($this->table);

        $dataMapper = GeneralUtility::makeInstance(DataMapper::class);
        $rows = $dataMapper->map(
            Entity::class,
            $queryBuilder->executeQuery()->fetchAllAssociative()
        );
        return $rows;
    }

    public function updateVals($entity,$values){
        $value_table = "tx_process_domain_model_elementvalue";
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable($value_table);
        
        $q = $queryBuilder->update($value_table)->where(
            $queryBuilder->expr()->eq('entity_id', $queryBuilder->createNamedParameter($entity->getUid())),
            $queryBuilder->expr()->in('element_id', $queryBuilder->createNamedParameter(array_keys($values),Connection::PARAM_INT_ARRAY))
        )->set("hidden",1)->executeStatement();
       
        
        foreach($values as $element_id=>$val){
            $row_vals = ["element_id"=>$element_id,"entity_id"=>$entity->getUid(),"value"=>$val];
            $queryBuilder->insert($value_table)->values($row_vals)->executeStatement();
        }
    }

    public function loadEntityValues($entity):void{
        $value_table = "tx_process_domain_model_elementvalue";
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable($value_table);
        $res = $queryBuilder->select("*")->from($value_table)->where(
            $queryBuilder->expr()->eq('entity_id', $queryBuilder->createNamedParameter($entity->getUid()))
        )->executeQuery();
        
        $vals = [];
        while($row = $res->fetchAssociative()){
            $vals[$row["element_id"]] = $row;
        }
        $entity->setValues($vals);
    }
}