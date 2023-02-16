<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230102185045 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'comments';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE client_comments (
            id INT AUTO_INCREMENT NOT NULL, 
            client_id INT(10) NOT NULL, 
            user_id INT(10) NOT NULL, 
            creation_at DATETIME NOT NULL, 
            text VARCHAR(255) NOT NULL,
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
    }
}
