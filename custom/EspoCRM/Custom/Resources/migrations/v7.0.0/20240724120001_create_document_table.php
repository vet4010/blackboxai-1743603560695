<?php
namespace Espo\Custom\Resources\migrations\v7_0_0;

use Espo\Core\Utils\Util;
use Espo\Core\ORM\EntityManager;
use Espo\Core\Utils\Database\Schema\Utils as SchemaUtils;

class V20240724120001_create_document_table
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
            CREATE TABLE IF NOT EXISTS `document` (
                `id` VARCHAR(24) NOT NULL,
                `name` VARCHAR(255) NOT NULL,
                `file_id` VARCHAR(24) DEFAULT NULL,
                `category_id` VARCHAR(24) DEFAULT NULL,
                `tags` TEXT DEFAULT NULL,
                `deleted` TINYINT(1) DEFAULT 0,
                PRIMARY KEY (`id`),
                INDEX `IDX_FILE` (`file_id`),
                INDEX `IDX_CATEGORY` (`category_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ");
    }

    public function down(): void
    {
        $connection = $this->entityManager->getConnection();
        $connection->executeQuery("DROP TABLE IF EXISTS `document`");
    }
}