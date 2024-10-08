<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240514140829 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE lignecommandes (id INT AUTO_INCREMENT NOT NULL, commande_id_id INT NOT NULL, livre_id_id INT NOT NULL, quantite INT DEFAULT NULL, INDEX IDX_448E7C7A462C4194 (commande_id_id), INDEX IDX_448E7C7AEC470631 (livre_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE lignecommandes ADD CONSTRAINT FK_448E7C7A462C4194 FOREIGN KEY (commande_id_id) REFERENCES commande (id)');
        $this->addSql('ALTER TABLE lignecommandes ADD CONSTRAINT FK_448E7C7AEC470631 FOREIGN KEY (livre_id_id) REFERENCES livres (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lignecommandes DROP FOREIGN KEY FK_448E7C7A462C4194');
        $this->addSql('ALTER TABLE lignecommandes DROP FOREIGN KEY FK_448E7C7AEC470631');
        $this->addSql('DROP TABLE lignecommandes');
    }
}
