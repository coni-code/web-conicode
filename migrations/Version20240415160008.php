<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240415160008 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add cv_filename to the user';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user ADD cv_filename VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user DROP cv_filename');
    }
}
