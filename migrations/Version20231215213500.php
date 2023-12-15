<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20231215213500 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add Organization, Board, BoardList, Card and Member entity';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE trello_board (id VARCHAR(255) NOT NULL, organization_id VARCHAR(255) DEFAULT NULL, trello_id VARCHAR(255) NOT NULL, deleted_at DATETIME DEFAULT NULL, created_by VARCHAR(255) DEFAULT NULL, updated_by VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_EE58C5D232C8A3DE (organization_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trello_board_members (board_id VARCHAR(255) NOT NULL, member_id VARCHAR(255) NOT NULL, INDEX IDX_9CCC01EBE7EC5785 (board_id), INDEX IDX_9CCC01EB7597D3FE (member_id), PRIMARY KEY(board_id, member_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trello_card (id VARCHAR(255) NOT NULL, board_list_id VARCHAR(255) DEFAULT NULL, trello_id VARCHAR(255) NOT NULL, deleted_at DATETIME DEFAULT NULL, created_by VARCHAR(255) DEFAULT NULL, updated_by VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, url VARCHAR(255) NOT NULL, INDEX IDX_7ED730EC75B03E84 (board_list_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trello_card_members (card_id VARCHAR(255) NOT NULL, member_id VARCHAR(255) NOT NULL, INDEX IDX_42DD4C74ACC9A20 (card_id), INDEX IDX_42DD4C77597D3FE (member_id), PRIMARY KEY(card_id, member_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trello_list (id VARCHAR(255) NOT NULL, board_id VARCHAR(255) DEFAULT NULL, trello_id VARCHAR(255) NOT NULL, deleted_at DATETIME DEFAULT NULL, created_by VARCHAR(255) DEFAULT NULL, updated_by VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, name VARCHAR(255) NOT NULL, visible TINYINT(1) DEFAULT 1 NOT NULL, INDEX IDX_2C0B5027E7EC5785 (board_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trello_member (id VARCHAR(255) NOT NULL, trello_id VARCHAR(255) NOT NULL, deleted_at DATETIME DEFAULT NULL, created_by VARCHAR(255) DEFAULT NULL, updated_by VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, avatar_hash VARCHAR(255) NOT NULL, avatar_url VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trello_organization (id VARCHAR(255) NOT NULL, trello_id VARCHAR(255) NOT NULL, deleted_at DATETIME DEFAULT NULL, created_by VARCHAR(255) DEFAULT NULL, updated_by VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, name VARCHAR(255) NOT NULL, display_name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE trello_board ADD CONSTRAINT FK_EE58C5D232C8A3DE FOREIGN KEY (organization_id) REFERENCES trello_organization (id)');
        $this->addSql('ALTER TABLE trello_board_members ADD CONSTRAINT FK_9CCC01EBE7EC5785 FOREIGN KEY (board_id) REFERENCES trello_board (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE trello_board_members ADD CONSTRAINT FK_9CCC01EB7597D3FE FOREIGN KEY (member_id) REFERENCES trello_member (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE trello_card ADD CONSTRAINT FK_7ED730EC75B03E84 FOREIGN KEY (board_list_id) REFERENCES trello_list (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE trello_card_members ADD CONSTRAINT FK_42DD4C74ACC9A20 FOREIGN KEY (card_id) REFERENCES trello_card (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE trello_card_members ADD CONSTRAINT FK_42DD4C77597D3FE FOREIGN KEY (member_id) REFERENCES trello_member (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE trello_list ADD CONSTRAINT FK_2C0B5027E7EC5785 FOREIGN KEY (board_id) REFERENCES trello_board (id)');
        $this->addSql('ALTER TABLE user ADD deleted_at DATETIME DEFAULT NULL, ADD created_by VARCHAR(255) DEFAULT NULL, ADD updated_by VARCHAR(255) DEFAULT NULL, ADD created_at DATETIME NOT NULL, ADD updated_at DATETIME NOT NULL, CHANGE id id VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE trello_board DROP FOREIGN KEY FK_EE58C5D232C8A3DE');
        $this->addSql('ALTER TABLE trello_board_members DROP FOREIGN KEY FK_9CCC01EBE7EC5785');
        $this->addSql('ALTER TABLE trello_board_members DROP FOREIGN KEY FK_9CCC01EB7597D3FE');
        $this->addSql('ALTER TABLE trello_card DROP FOREIGN KEY FK_7ED730EC75B03E84');
        $this->addSql('ALTER TABLE trello_card_members DROP FOREIGN KEY FK_42DD4C74ACC9A20');
        $this->addSql('ALTER TABLE trello_card_members DROP FOREIGN KEY FK_42DD4C77597D3FE');
        $this->addSql('ALTER TABLE trello_list DROP FOREIGN KEY FK_2C0B5027E7EC5785');
        $this->addSql('DROP TABLE trello_board');
        $this->addSql('DROP TABLE trello_board_members');
        $this->addSql('DROP TABLE trello_card');
        $this->addSql('DROP TABLE trello_card_members');
        $this->addSql('DROP TABLE trello_list');
        $this->addSql('DROP TABLE trello_member');
        $this->addSql('DROP TABLE trello_organization');
        $this->addSql('ALTER TABLE user DROP deleted_at, DROP created_by, DROP updated_by, DROP created_at, DROP updated_at, CHANGE id id INT AUTO_INCREMENT NOT NULL');
    }
}
