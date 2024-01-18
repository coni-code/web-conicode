<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240104192658 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Change relation of member and user';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE trello_member ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE trello_member ADD CONSTRAINT FK_F037935DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F037935DA76ED395 ON trello_member (user_id)');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6497597D3FE');
        $this->addSql('DROP INDEX UNIQ_8D93D6497597D3FE ON user');
        $this->addSql('ALTER TABLE user DROP member_id');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE trello_member DROP FOREIGN KEY FK_F037935DA76ED395');
        $this->addSql('DROP INDEX UNIQ_F037935DA76ED395 ON trello_member');
        $this->addSql('ALTER TABLE trello_member DROP user_id');
        $this->addSql('ALTER TABLE user ADD member_id VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6497597D3FE FOREIGN KEY (member_id) REFERENCES trello_member (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D6497597D3FE ON user (member_id)');
    }
}
