<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250428070811 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_actualite DROP FOREIGN KEY FK_54720C73A2843073');
        $this->addSql('ALTER TABLE user_actualite DROP FOREIGN KEY FK_54720C73A76ED395');
        $this->addSql('DROP TABLE user_actualite');
        $this->addSql('ALTER TABLE actualite ADD code_ue VARCHAR(4) NOT NULL, ADD datetime_act DATETIME NOT NULL');
        $this->addSql('ALTER TABLE actualite ADD CONSTRAINT FK_54928197B6AA93DC FOREIGN KEY (code_ue) REFERENCES ue (code_ue) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_54928197B6AA93DC ON actualite (code_ue)');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_post_ue');
        $this->addSql('ALTER TABLE post DROP datetime_post, DROP depot_post, CHANGE code_ue code_ue VARCHAR(4) NOT NULL, CHANGE description_post description_post VARCHAR(2000) NOT NULL');
        $this->addSql('DROP INDEX fk_post_ue ON post');
        $this->addSql('CREATE INDEX IDX_5A8A6C8DB6AA93DC ON post (code_ue)');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_post_ue FOREIGN KEY (code_ue) REFERENCES ue (code_ue) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_actualite (user_id INT NOT NULL, actualite_id INT NOT NULL, INDEX IDX_54720C73A76ED395 (user_id), INDEX IDX_54720C73A2843073 (actualite_id), PRIMARY KEY(user_id, actualite_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE user_actualite ADD CONSTRAINT FK_54720C73A2843073 FOREIGN KEY (actualite_id) REFERENCES actualite (id_actualite)');
        $this->addSql('ALTER TABLE user_actualite ADD CONSTRAINT FK_54720C73A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE actualite DROP FOREIGN KEY FK_54928197B6AA93DC');
        $this->addSql('DROP INDEX IDX_54928197B6AA93DC ON actualite');
        $this->addSql('ALTER TABLE actualite DROP code_ue, DROP datetime_act');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8DB6AA93DC');
        $this->addSql('ALTER TABLE post ADD datetime_post DATETIME NOT NULL, ADD depot_post LONGBLOB DEFAULT NULL, CHANGE code_ue code_ue VARCHAR(255) NOT NULL, CHANGE description_post description_post VARCHAR(255) NOT NULL');
        $this->addSql('DROP INDEX idx_5a8a6c8db6aa93dc ON post');
        $this->addSql('CREATE INDEX FK_post_ue ON post (code_ue)');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8DB6AA93DC FOREIGN KEY (code_ue) REFERENCES ue (code_ue) ON DELETE CASCADE');
    }
}
