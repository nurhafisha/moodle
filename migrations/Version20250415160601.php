<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250415160601 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_actualite DROP FOREIGN KEY FK_54720C73A76ED395');
        $this->addSql('ALTER TABLE user_actualite DROP FOREIGN KEY FK_54720C73A2843073');
        $this->addSql('DROP TABLE user_actualite');
        $this->addSql('ALTER TABLE actualite ADD datetime_act DATETIME NOT NULL');
        $this->addSql('ALTER TABLE post CHANGE description_post description_post VARCHAR(2000) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_actualite (user_id INT NOT NULL, actualite_id INT NOT NULL, INDEX IDX_54720C73A2843073 (actualite_id), INDEX IDX_54720C73A76ED395 (user_id), PRIMARY KEY(user_id, actualite_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE user_actualite ADD CONSTRAINT FK_54720C73A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_actualite ADD CONSTRAINT FK_54720C73A2843073 FOREIGN KEY (actualite_id) REFERENCES actualite (id_actualite)');
        $this->addSql('ALTER TABLE actualite DROP datetime_act');
        $this->addSql('ALTER TABLE post CHANGE description_post description_post VARCHAR(255) NOT NULL');
    }
}
