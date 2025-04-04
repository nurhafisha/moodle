<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250404195851 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ue ADD id_ue INT AUTO_INCREMENT NOT NULL, DROP idUE, ADD PRIMARY KEY (id_ue)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ue MODIFY id_ue INT NOT NULL');
        $this->addSql('DROP INDEX `primary` ON ue');
        $this->addSql('ALTER TABLE ue ADD idUE INT NOT NULL, DROP id_ue');
    }
}
