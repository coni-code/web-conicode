<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240127115904 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE sprint (id INT AUTO_INCREMENT NOT NULL, deleted_at DATETIME DEFAULT NULL, created_by VARCHAR(255) DEFAULT NULL, updated_by VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, title VARCHAR(65) NOT NULL, start_date DATETIME NOT NULL, end_date DATETIME NOT NULL, is_successful TINYINT(1) NOT NULL, story_points DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sprint_user (id INT AUTO_INCREMENT NOT NULL, sprint_id INT DEFAULT NULL, user_id INT DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, created_by VARCHAR(255) DEFAULT NULL, updated_by VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, availability_in_hours DOUBLE PRECISION NOT NULL, INDEX IDX_B65179658C24077B (sprint_id), INDEX IDX_B6517965A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE sprint_user ADD CONSTRAINT FK_B65179658C24077B FOREIGN KEY (sprint_id) REFERENCES sprint (id)');
        $this->addSql('ALTER TABLE sprint_user ADD CONSTRAINT FK_B6517965A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE meeting ADD sprint_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE meeting ADD CONSTRAINT FK_F515E1398C24077B FOREIGN KEY (sprint_id) REFERENCES sprint (id)');
        $this->addSql('CREATE INDEX IDX_F515E1398C24077B ON meeting (sprint_id)');
        $this->addSql('ALTER TABLE trello_card ADD sprint_id INT DEFAULT NULL, ADD story_points VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE trello_card ADD CONSTRAINT FK_7ED730EC8C24077B FOREIGN KEY (sprint_id) REFERENCES sprint (id)');
        $this->addSql('CREATE INDEX IDX_7ED730EC8C24077B ON trello_card (sprint_id)');
        $this->addSql('ALTER TABLE user ADD name VARCHAR(255) DEFAULT NULL, ADD surname VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE meeting DROP FOREIGN KEY FK_F515E1398C24077B');
        $this->addSql('ALTER TABLE trello_card DROP FOREIGN KEY FK_7ED730EC8C24077B');
        $this->addSql('ALTER TABLE sprint_user DROP FOREIGN KEY FK_B65179658C24077B');
        $this->addSql('ALTER TABLE sprint_user DROP FOREIGN KEY FK_B6517965A76ED395');
        $this->addSql('DROP TABLE sprint');
        $this->addSql('DROP TABLE sprint_user');
        $this->addSql('DROP INDEX IDX_7ED730EC8C24077B ON trello_card');
        $this->addSql('ALTER TABLE trello_card DROP sprint_id, DROP story_points');
        $this->addSql('ALTER TABLE user DROP name, DROP surname');
        $this->addSql('DROP INDEX IDX_F515E1398C24077B ON meeting');
        $this->addSql('ALTER TABLE meeting DROP sprint_id');
    }
}
