<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20231223233606 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add meeting entity and add relation with user';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE meeting (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, date DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users_meetings (user_id INT NOT NULL, meeting_id INT NOT NULL, INDEX IDX_3FBF7938A76ED395 (user_id), INDEX IDX_3FBF793867433D9C (meeting_id), PRIMARY KEY(user_id, meeting_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE users_meetings ADD CONSTRAINT FK_3FBF7938A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users_meetings ADD CONSTRAINT FK_3FBF793867433D9C FOREIGN KEY (meeting_id) REFERENCES meeting (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE users_meetings DROP FOREIGN KEY FK_3FBF7938A76ED395');
        $this->addSql('ALTER TABLE users_meetings DROP FOREIGN KEY FK_3FBF793867433D9C');
        $this->addSql('DROP TABLE meeting');
        $this->addSql('DROP TABLE users_meetings');
    }
}
