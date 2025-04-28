<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250331060423 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ue MODIFY idUE INT NOT NULL');
        $this->addSql('DROP INDEX `primary` ON ue');
        $this->addSql('ALTER TABLE ue CHANGE code_ue code_ue INT NOT NULL, CHANGE idUE id_ue INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE ue ADD PRIMARY KEY (id_ue)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ue MODIFY id_ue INT NOT NULL');
        $this->addSql('DROP INDEX `PRIMARY` ON ue');
        $this->addSql('ALTER TABLE ue CHANGE code_ue code_ue VARCHAR(20) NOT NULL, CHANGE id_ue idUE INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE ue ADD PRIMARY KEY (idUE)');
    }
}
