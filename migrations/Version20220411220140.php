<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220411220140 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE groupe_affectation DROP FOREIGN KEY FK_7B00121DB64ACF2C');
        $this->addSql('ALTER TABLE groupe_affectation ADD CONSTRAINT FK_7B00121D76C50E4A FOREIGN KEY (proprietaire_id) REFERENCES service (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE groupe_affectation DROP FOREIGN KEY FK_7B00121D76C50E4A');
        $this->addSql('ALTER TABLE groupe_affectation ADD CONSTRAINT FK_7B00121DB64ACF2C FOREIGN KEY (proprietaire_id) REFERENCES user (id)');
    }
}
