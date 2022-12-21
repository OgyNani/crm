<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221212182538 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'create tables roles, resources, permissions';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE roles (
            id INT AUTO_INCREMENT NOT NULL, 
            name VARCHAR(180) NOT NULL, 
            role VARCHAR(180) NOT NULL, 
            UNIQUE INDEX UNIQ_8D93D649F85E0678 (name), 
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('CREATE TABLE resources (
            id INT AUTO_INCREMENT NOT NULL, 
            name VARCHAR(180) NOT NULL, 
            available_accesses VARCHAR(180) NOT NULL, 
            UNIQUE INDEX UNIQ_8D93D649F85E0679 (name), 
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('CREATE TABLE permissions (
            id INT AUTO_INCREMENT NOT NULL, 
            role_id INT NOT NULL, 
            resource_id INT NOT NULL, 
            access VARCHAR(40) NOT NULL, 
            UNIQUE INDEX UNIQ_8D93D649F85E0680 (role_id, resource_id, access), 
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
    }
}
