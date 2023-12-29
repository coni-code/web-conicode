<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20231229213541 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Drop vote table and add start_date and end_date';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE vote DROP FOREIGN KEY FK_5A10856467433D9C');
        $this->addSql('ALTER TABLE vote DROP FOREIGN KEY FK_5A108564A76ED395');
        $this->addSql('DROP TABLE vote');
        $this->addSql('ALTER TABLE meeting ADD end_date DATETIME NOT NULL, CHANGE date start_date DATETIME NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE TABLE vote (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, meeting_id INT DEFAULT NULL, INDEX IDX_5A10856467433D9C (meeting_id), INDEX IDX_5A108564A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT FK_5A10856467433D9C FOREIGN KEY (meeting_id) REFERENCES meeting (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT FK_5A108564A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE meeting ADD date DATETIME NOT NULL, DROP start_date, DROP end_date');
    }
}
