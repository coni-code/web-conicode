<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240118183456 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Change avatar hash to be nullable';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE trello_member CHANGE avatar_hash avatar_hash VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE trello_member CHANGE avatar_hash avatar_hash VARCHAR(255) NOT NULL');
    }
}
