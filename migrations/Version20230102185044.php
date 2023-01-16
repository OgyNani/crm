<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230102185044 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'update table clients';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE clients ADD COLUMN user_id INT NOT NULL');
        $this->addSql('ALTER TABLE clients DROP COLUMN roles');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
