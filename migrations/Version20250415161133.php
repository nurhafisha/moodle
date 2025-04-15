<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250415161133 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE actualite ADD code_ue VARCHAR(4) NOT NULL');
        $this->addSql('ALTER TABLE actualite ADD CONSTRAINT FK_54928197B6AA93DC FOREIGN KEY (code_ue) REFERENCES ue (code_ue) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_54928197B6AA93DC ON actualite (code_ue)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE actualite DROP FOREIGN KEY FK_54928197B6AA93DC');
        $this->addSql('DROP INDEX IDX_54928197B6AA93DC ON actualite');
        $this->addSql('ALTER TABLE actualite DROP code_ue');
    }
}
