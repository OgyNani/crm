<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221212182539 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'orders';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE orders (
            id INT AUTO_INCREMENT NOT NULL, 
            order_id INT(10) NOT NULL, 
            client_id INT(10) NOT NULL, 
            products INT(255) NOT NULL, 
            country VARCHAR(180) NOT NULL, 
            `sum` INT(255) NOT NULL,
            status VARCHAR(180) NOT NULL, 
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
    }
}
