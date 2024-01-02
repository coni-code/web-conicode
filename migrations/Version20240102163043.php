<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240102163043 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add relation between User and Member';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649E0F404F5');
        $this->addSql('DROP INDEX UNIQ_8D93D649E0F404F5 ON user');
        $this->addSql('ALTER TABLE user CHANGE trello_member_id member_id VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6497597D3FE FOREIGN KEY (member_id) REFERENCES trello_member (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D6497597D3FE ON user (member_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6497597D3FE');
        $this->addSql('DROP INDEX UNIQ_8D93D6497597D3FE ON user');
        $this->addSql('ALTER TABLE user CHANGE member_id trello_member_id VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649E0F404F5 FOREIGN KEY (trello_member_id) REFERENCES trello_member (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E0F404F5 ON user (trello_member_id)');
    }
}
