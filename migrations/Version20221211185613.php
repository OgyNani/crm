<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221211185613 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'create admins table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('create table admins(
           id INT NOT NULL AUTO_INCREMENT,
           name VARCHAR(100) NOT NULL,
           created_at DATE,
           PRIMARY KEY ( id )
        );');

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
