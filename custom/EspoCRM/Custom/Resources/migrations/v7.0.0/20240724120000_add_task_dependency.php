<?php
namespace Espo\Custom\Resources\migrations\v7_0_0;

use Espo\Core\Utils\Util;
use Espo\Core\ORM\EntityManager;
use Espo\Core\Utils\Database\Schema\Utils as SchemaUtils;

class V20240724120000_add_task_dependency
{
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function up(): void
    {
        $connection = $this->entityManager->getConnection();

        $connection->executeQuery("
            ALTER TABLE task 
            ADD parent_id VARCHAR(24) DEFAULT NULL,
            ADD INDEX IDX_PARENT_TASK (parent_id)
        ");

        $connection->executeQuery("
            ALTER TABLE task 
            ADD CONSTRAINT FK_PARENT_TASK 
            FOREIGN KEY (parent_id) REFERENCES task (id) 
            ON DELETE SET NULL
        ");
    }

    public function down(): void
    {
        $connection = $this->entityManager->getConnection();
        $connection->executeQuery("ALTER TABLE task DROP FOREIGN KEY FK_PARENT_TASK");
        $connection->executeQuery("ALTER TABLE task DROP COLUMN parent_id");
    }
}