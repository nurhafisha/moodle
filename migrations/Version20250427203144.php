<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250427203144 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post ADD epingleur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8D2B50F058 FOREIGN KEY (epingleur_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_5A8A6C8D2B50F058 ON post (epingleur_id)');
        $this->addSql('ALTER TABLE ue ADD image_mime_type_ue VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8D2B50F058');
        $this->addSql('DROP INDEX IDX_5A8A6C8D2B50F058 ON post');
        $this->addSql('ALTER TABLE post DROP epingleur_id');
        $this->addSql('ALTER TABLE ue DROP image_mime_type_ue');
    }
}
