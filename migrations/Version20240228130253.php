<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240228130253 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add user_link entity and relatino to the user';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE user_link (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, created_by VARCHAR(255) DEFAULT NULL, updated_by VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, type VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, icon_path VARCHAR(255) NOT NULL, INDEX IDX_4C2DD538A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_link ADD CONSTRAINT FK_4C2DD538A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user DROP github_link, DROP gitlab_link, DROP linkedin_link, DROP website_link, DROP youtube_link');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user_link DROP FOREIGN KEY FK_4C2DD538A76ED395');
        $this->addSql('DROP TABLE user_link');
        $this->addSql('ALTER TABLE user ADD github_link VARCHAR(255) DEFAULT NULL, ADD gitlab_link VARCHAR(255) DEFAULT NULL, ADD linkedin_link VARCHAR(255) DEFAULT NULL, ADD website_link VARCHAR(255) DEFAULT NULL, ADD youtube_link VARCHAR(255) DEFAULT NULL');
    }
}
