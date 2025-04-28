<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250329194011 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX `primary` ON post');
        $this->addSql('ALTER TABLE post DROP id, CHANGE id_post id_post INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE post ADD PRIMARY KEY (id_post)');
        $this->addSql('ALTER TABLE ue CHANGE code_ue code_ue INT AUTO_INCREMENT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post ADD id INT AUTO_INCREMENT NOT NULL, CHANGE id_post id_post INT NOT NULL, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE ue CHANGE code_ue code_ue INT NOT NULL');
    }
}
