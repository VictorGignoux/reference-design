<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250209122629 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, depend_id INT DEFAULT NULL, INDEX IDX_497DD634C09A9141 (depend_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE reference (id INT AUTO_INCREMENT NOT NULL, notice VARCHAR(255) NOT NULL, texte VARCHAR(255) DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, categorie_id INT NOT NULL, INDEX IDX_AEA34913BCF5E72D (categorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE categorie ADD CONSTRAINT FK_497DD634C09A9141 FOREIGN KEY (depend_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE reference ADD CONSTRAINT FK_AEA34913BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categorie DROP FOREIGN KEY FK_497DD634C09A9141');
        $this->addSql('ALTER TABLE reference DROP FOREIGN KEY FK_AEA34913BCF5E72D');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE reference');
    }
}
