<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220405165637 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE groupe_affectation DROP FOREIGN KEY FK_7B00121DB64ACF2C');
        $this->addSql('ALTER TABLE groupe_affectation ADD date_dernier_ajout DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('DROP INDEX idx_7b00121db64acf2c ON groupe_affectation');
        $this->addSql('CREATE INDEX IDX_7B00121D76C50E4A ON groupe_affectation (proprietaire_id)');
        $this->addSql('ALTER TABLE groupe_affectation ADD CONSTRAINT FK_7B00121DB64ACF2C FOREIGN KEY (proprietaire_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE groupe_affectation DROP FOREIGN KEY FK_7B00121D76C50E4A');
        $this->addSql('ALTER TABLE groupe_affectation DROP date_dernier_ajout');
        $this->addSql('DROP INDEX idx_7b00121d76c50e4a ON groupe_affectation');
        $this->addSql('CREATE INDEX IDX_7B00121DB64ACF2C ON groupe_affectation (proprietaire_id)');
        $this->addSql('ALTER TABLE groupe_affectation ADD CONSTRAINT FK_7B00121D76C50E4A FOREIGN KEY (proprietaire_id) REFERENCES user (id)');
    }
}
