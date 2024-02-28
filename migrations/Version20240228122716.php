<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240228122716 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add position_dictionary and relation with user';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE position_dictionary (id INT AUTO_INCREMENT NOT NULL, deleted_at DATETIME DEFAULT NULL, created_by VARCHAR(255) DEFAULT NULL, updated_by VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, name VARCHAR(24) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users_positions (user_id INT NOT NULL, position_dictionary_id INT NOT NULL, INDEX IDX_B0E29F9DA76ED395 (user_id), INDEX IDX_B0E29F9DA057F9D2 (position_dictionary_id), PRIMARY KEY(user_id, position_dictionary_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE users_positions ADD CONSTRAINT FK_B0E29F9DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users_positions ADD CONSTRAINT FK_B0E29F9DA057F9D2 FOREIGN KEY (position_dictionary_id) REFERENCES position_dictionary (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user DROP positions');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE users_positions DROP FOREIGN KEY FK_B0E29F9DA76ED395');
        $this->addSql('ALTER TABLE users_positions DROP FOREIGN KEY FK_B0E29F9DA057F9D2');
        $this->addSql('DROP TABLE position_dictionary');
        $this->addSql('DROP TABLE users_positions');
        $this->addSql('ALTER TABLE user ADD positions JSON DEFAULT NULL');
    }
}
