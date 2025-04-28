<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250329215510 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post ADD depot_post LONGBLOB DEFAULT NULL');
        // Ensure all existing records have a valid idUser before making the column NOT NULL
        $this->addSql('UPDATE actualite SET id_user = 1 WHERE id_user IS NULL'); // Replace '1' with a valid User ID

        // Apply the NOT NULL constraint
        $this->addSql('ALTER TABLE actualite ALTER COLUMN id_user SET NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post DROP depot_post');
    }
}
