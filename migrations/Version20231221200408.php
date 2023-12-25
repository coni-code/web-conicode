<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20231221200408 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Drop trello_id column';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE trello_board DROP trello_id');
        $this->addSql('ALTER TABLE trello_card DROP trello_id');
        $this->addSql('ALTER TABLE trello_list DROP trello_id');
        $this->addSql('ALTER TABLE trello_member DROP trello_id');
        $this->addSql('ALTER TABLE trello_organization DROP trello_id');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE trello_board ADD trello_id VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE trello_card ADD trello_id VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE trello_list ADD trello_id VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE trello_organization ADD trello_id VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE trello_member ADD trello_id VARCHAR(255) NOT NULL');
    }
}
