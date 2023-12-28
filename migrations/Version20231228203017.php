<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20231228203017 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add vote and assign with user and meeting';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE vote (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, meeting_id INT DEFAULT NULL, INDEX IDX_5A108564A76ED395 (user_id), INDEX IDX_5A10856467433D9C (meeting_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT FK_5A108564A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT FK_5A10856467433D9C FOREIGN KEY (meeting_id) REFERENCES meeting (id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE vote DROP FOREIGN KEY FK_5A108564A76ED395');
        $this->addSql('ALTER TABLE vote DROP FOREIGN KEY FK_5A10856467433D9C');
        $this->addSql('DROP TABLE vote');
    }
}
