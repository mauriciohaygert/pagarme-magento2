<?php

namespace MundiPagg\MundiPagg\Concrete;

use Mundipagg\Core\Kernel\Abstractions\AbstractDatabaseDecorator;

final class Magento2DatabaseDecorator extends AbstractDatabaseDecorator
{
    protected function setTableArray()
    {
        $this->tableArray = [
            AbstractDatabaseDecorator::TABLE_MODULE_CONFIGURATION =>
                $this->db->getTableName('mundipagg_module_core_configuration'),

            AbstractDatabaseDecorator::TABLE_WEBHOOK =>
                $this->db->getTableName('mundipagg_module_core_webhook')
        ];
    }

    protected function doQuery($query)
    {
        $connection = $this->db->getConnection();
        $connection->query($query);
        $this->setLastInsertId($connection->lastInsertId());
    }

    protected function formatResults($queryResult)
    {
        $retn = new \stdClass;
        $retn->num_rows = count($queryResult);
        $retn->row = array();
        if (!empty($queryResult)) {
            $retn->row = $queryResult[0];
        }
        $retn->rows = $queryResult;
        return $retn;
    }

    protected function doFetch($query)
    {
        $connection = $this->db->getConnection();

        return $connection->fetchAll($query);
    }

    public function getLastId()
    {
        return $this->db->lastInsertId;
    }

    protected function setTablePrefix()
    {
        //Magento2 getTableName method already retrieves the table with the prefix.
        $this->tablePrefix = '';
    }

    protected function setLastInsertId($lastInsertId)
    {
        $this->db->lastInsertId = $lastInsertId;
    }
}