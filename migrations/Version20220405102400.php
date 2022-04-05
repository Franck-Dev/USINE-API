<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220405102400 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE groupe_affectation_user (groupe_affectation_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_7E1DCA48A4B85BB (groupe_affectation_id), INDEX IDX_7E1DCA48A76ED395 (user_id), PRIMARY KEY(groupe_affectation_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE groupe_affectation_user ADD CONSTRAINT FK_7E1DCA48A4B85BB FOREIGN KEY (groupe_affectation_id) REFERENCES groupe_affectation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE groupe_affectation_user ADD CONSTRAINT FK_7E1DCA48A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE groupe_affectation ADD proprietaire_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE groupe_affectation ADD CONSTRAINT FK_7B00121DB64ACF2C FOREIGN KEY (proprietaire_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_7B00121DB64ACF2C ON groupe_affectation (proprietaire_id)');
        $this->addSql('ALTER TABLE user ADD site_id INT NOT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649F6BD1646 FOREIGN KEY (site_id) REFERENCES usine (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649F6BD1646 ON user (site_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE groupe_affectation_user');
        $this->addSql('ALTER TABLE groupe_affectation DROP FOREIGN KEY FK_7B00121DB64ACF2C');
        $this->addSql('DROP INDEX IDX_7B00121DB64ACF2C ON groupe_affectation');
        $this->addSql('ALTER TABLE groupe_affectation DROP proprietaire_id');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649F6BD1646');
        $this->addSql('DROP INDEX IDX_8D93D649F6BD1646 ON user');
        $this->addSql('ALTER TABLE user DROP site_id');
    }
}
