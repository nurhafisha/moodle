<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250329201143 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE actualite (id_actualite INT AUTO_INCREMENT NOT NULL, description_act VARCHAR(255) NOT NULL, PRIMARY KEY(id_actualite)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post (id_post INT AUTO_INCREMENT NOT NULL, titre_post VARCHAR(255) NOT NULL, image_ue LONGBLOB NOT NULL, type_post VARCHAR(255) NOT NULL, datetime_post DATETIME NOT NULL, description_post VARCHAR(255) NOT NULL, PRIMARY KEY(id_post)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ue (code_ue INT AUTO_INCREMENT NOT NULL, nom_ue VARCHAR(255) NOT NULL, image_ue LONGBLOB DEFAULT NULL, PRIMARY KEY(code_ue)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX `primary` ON user');
        $this->addSql('ALTER TABLE user ADD nom_user VARCHAR(255) NOT NULL, ADD prenom_user VARCHAR(255) NOT NULL, ADD image_user LONGBLOB DEFAULT NULL, CHANGE id id_user INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE user ADD PRIMARY KEY (id_user)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE actualite');
        $this->addSql('DROP TABLE post');
        $this->addSql('DROP TABLE ue');
        $this->addSql('ALTER TABLE user MODIFY id_user INT NOT NULL');
        $this->addSql('DROP INDEX `PRIMARY` ON user');
        $this->addSql('ALTER TABLE user DROP nom_user, DROP prenom_user, DROP image_user, CHANGE id_user id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE user ADD PRIMARY KEY (id)');
    }
}
