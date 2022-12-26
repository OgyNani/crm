<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version202212231742112 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'create table status';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE status (
            id INT AUTO_INCREMENT NOT NULL,
            name VARCHAR(180) NOT NULL, 
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
