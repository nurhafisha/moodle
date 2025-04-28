<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250405192105 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_ue DROP FOREIGN KEY user_ue_ibfk_1');
        $this->addSql('ALTER TABLE user_ue ADD CONSTRAINT FK_361EBE5E62E883B1 FOREIGN KEY (ue_id) REFERENCES ue (idUE)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_ue DROP FOREIGN KEY FK_361EBE5E62E883B1');
        $this->addSql('ALTER TABLE user_ue ADD CONSTRAINT user_ue_ibfk_1 FOREIGN KEY (ue_id) REFERENCES ue (id_ue)');
    }
}
