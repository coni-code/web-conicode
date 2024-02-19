<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240219205931 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Fix positions column in the user table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user CHANGE positions positions JSON DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user CHANGE positions positions JSON NOT NULL');
    }
}
