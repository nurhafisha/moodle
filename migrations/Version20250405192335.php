<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250405192335 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_ue DROP FOREIGN KEY FK_361EBE5EA76ED395');
        $this->addSql('DROP TABLE user_ue');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_ue (user_id INT NOT NULL, ue_id INT NOT NULL, INDEX IDX_361EBE5E62E883B1 (ue_id), INDEX IDX_361EBE5EA76ED395 (user_id), PRIMARY KEY(user_id, ue_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE user_ue ADD CONSTRAINT FK_361EBE5EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }
}
