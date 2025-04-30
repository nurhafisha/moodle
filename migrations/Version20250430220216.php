<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250430220216 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE actualite (id_actualite INT AUTO_INCREMENT NOT NULL, code_ue VARCHAR(4) NOT NULL, id_post INT DEFAULT NULL, user_id INT DEFAULT NULL, description_act VARCHAR(255) NOT NULL, datetime_act DATETIME NOT NULL, INDEX IDX_54928197B6AA93DC (code_ue), INDEX IDX_54928197D1AA708F (id_post), INDEX IDX_54928197A76ED395 (user_id), PRIMARY KEY(id_actualite)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post (id_post INT AUTO_INCREMENT NOT NULL, code_ue VARCHAR(4) NOT NULL, epingleur_id INT DEFAULT NULL, user_id INT NOT NULL, titre_post VARCHAR(255) NOT NULL, type_post VARCHAR(20) NOT NULL, datetimePost DATETIME NOT NULL, description_post VARCHAR(2000) NOT NULL, depot_post_blob LONGBLOB DEFAULT NULL, depot_post_name VARCHAR(255) DEFAULT NULL, type_message VARCHAR(20) DEFAULT NULL, INDEX IDX_5A8A6C8DB6AA93DC (code_ue), INDEX IDX_5A8A6C8D2B50F058 (epingleur_id), INDEX IDX_5A8A6C8DA76ED395 (user_id), PRIMARY KEY(id_post)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE actualite ADD CONSTRAINT FK_54928197B6AA93DC FOREIGN KEY (code_ue) REFERENCES ue (code_ue) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE actualite ADD CONSTRAINT FK_54928197D1AA708F FOREIGN KEY (id_post) REFERENCES post (id_post)');
        $this->addSql('ALTER TABLE actualite ADD CONSTRAINT FK_54928197A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8DB6AA93DC FOREIGN KEY (code_ue) REFERENCES ue (code_ue) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8D2B50F058 FOREIGN KEY (epingleur_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE actualite DROP FOREIGN KEY FK_54928197B6AA93DC');
        $this->addSql('ALTER TABLE actualite DROP FOREIGN KEY FK_54928197D1AA708F');
        $this->addSql('ALTER TABLE actualite DROP FOREIGN KEY FK_54928197A76ED395');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8DB6AA93DC');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8D2B50F058');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8DA76ED395');
        $this->addSql('DROP TABLE actualite');
        $this->addSql('DROP TABLE post');
    }
}
