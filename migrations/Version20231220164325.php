<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20231220164325 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add integer type to id';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user CHANGE id id INT AUTO_INCREMENT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user CHANGE id id VARCHAR(255) NOT NULL');
    }
}
