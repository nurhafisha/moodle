<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250414205426 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post ADD code_ue VARCHAR(4) NOT NULL');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8DB6AA93DC FOREIGN KEY (code_ue) REFERENCES ue (code_ue) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_5A8A6C8DB6AA93DC ON post (code_ue)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8DB6AA93DC');
        $this->addSql('DROP INDEX IDX_5A8A6C8DB6AA93DC ON post');
        $this->addSql('ALTER TABLE post DROP code_ue');
    }
}
