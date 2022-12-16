<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221212182537 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'create table clients';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE clients (
            id INT AUTO_INCREMENT NOT NULL, 
            username VARCHAR(180) NOT NULL, 
            country VARCHAR(255) NOT NULL, 
            contact VARCHAR(255) NOT NULL, 
            UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), 
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
    }
}
