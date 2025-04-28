<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250428080946 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE actualite DROP FOREIGN KEY FK_ACTUALITE_POST');
        $this->addSql('ALTER TABLE actualite DROP FOREIGN KEY FK_ACTUALITE_USER');
        $this->addSql('DROP INDEX fk_actualite_post ON actualite');
        $this->addSql('CREATE INDEX IDX_54928197D1AA708F ON actualite (id_post)');
        $this->addSql('DROP INDEX fk_actualite_user ON actualite');
        $this->addSql('CREATE INDEX IDX_54928197A76ED395 ON actualite (user_id)');
        $this->addSql('ALTER TABLE actualite ADD CONSTRAINT FK_ACTUALITE_POST FOREIGN KEY (id_post) REFERENCES post (id_post)');
        $this->addSql('ALTER TABLE actualite ADD CONSTRAINT FK_ACTUALITE_USER FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE actualite DROP FOREIGN KEY FK_54928197D1AA708F');
        $this->addSql('ALTER TABLE actualite DROP FOREIGN KEY FK_54928197A76ED395');
        $this->addSql('DROP INDEX idx_54928197d1aa708f ON actualite');
        $this->addSql('CREATE INDEX FK_ACTUALITE_POST ON actualite (id_post)');
        $this->addSql('DROP INDEX idx_54928197a76ed395 ON actualite');
        $this->addSql('CREATE INDEX FK_ACTUALITE_USER ON actualite (user_id)');
        $this->addSql('ALTER TABLE actualite ADD CONSTRAINT FK_54928197D1AA708F FOREIGN KEY (id_post) REFERENCES post (id_post)');
        $this->addSql('ALTER TABLE actualite ADD CONSTRAINT FK_54928197A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }
}
