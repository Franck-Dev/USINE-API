<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220404105740 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE division (id INT AUTO_INCREMENT NOT NULL, entreprise_id INT NOT NULL, nom VARCHAR(255) NOT NULL, INDEX IDX_10174714A4AEAFEA (entreprise_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE groupe_affectation (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE groupe_affectation_user (groupe_affectation_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_7E1DCA48A4B85BB (groupe_affectation_id), INDEX IDX_7E1DCA48A76ED395 (user_id), PRIMARY KEY(groupe_affectation_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE usine (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE division ADD CONSTRAINT FK_10174714A4AEAFEA FOREIGN KEY (entreprise_id) REFERENCES usine (id)');
        $this->addSql('ALTER TABLE groupe_affectation_user ADD CONSTRAINT FK_7E1DCA48A4B85BB FOREIGN KEY (groupe_affectation_id) REFERENCES groupe_affectation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE groupe_affectation_user ADD CONSTRAINT FK_7E1DCA48A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD unite_id INT NOT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649EC4A74AB FOREIGN KEY (unite_id) REFERENCES division (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649EC4A74AB ON user (unite_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649EC4A74AB');
        $this->addSql('ALTER TABLE groupe_affectation_user DROP FOREIGN KEY FK_7E1DCA48A4B85BB');
        $this->addSql('ALTER TABLE division DROP FOREIGN KEY FK_10174714A4AEAFEA');
        $this->addSql('DROP TABLE division');
        $this->addSql('DROP TABLE groupe_affectation');
        $this->addSql('DROP TABLE groupe_affectation_user');
        $this->addSql('DROP TABLE usine');
        $this->addSql('DROP INDEX IDX_8D93D649EC4A74AB ON user');
        $this->addSql('ALTER TABLE user DROP unite_id');
    }
}
