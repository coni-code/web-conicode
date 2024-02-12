<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240212130025 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add fields for social links and positions in user table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user ADD positions JSON DEFAULT NULL, ADD github_link VARCHAR(255) DEFAULT NULL, ADD gitlab_link VARCHAR(255) DEFAULT NULL, ADD linkedin_link VARCHAR(255) DEFAULT NULL, ADD website_link VARCHAR(255) DEFAULT NULL, ADD youtube_link VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user DROP positions, DROP github_link, DROP gitlab_link, DROP linkedin_link, DROP website_link, DROP youtube_link');
    }
}
