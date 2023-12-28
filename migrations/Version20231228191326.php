<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20231228191326 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add meeting statuses for meeting table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE meeting ADD status VARCHAR(255) DEFAULT \'pending\' NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE meeting DROP status');
    }
}
