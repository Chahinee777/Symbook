<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240514200831 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lignecommandes DROP FOREIGN KEY FK_448E7C7AEC470631');
        $this->addSql('ALTER TABLE lignecommandes DROP FOREIGN KEY FK_448E7C7A462C4194');
        $this->addSql('DROP INDEX IDX_448E7C7A462C4194 ON lignecommandes');
        $this->addSql('DROP INDEX IDX_448E7C7AEC470631 ON lignecommandes');
        $this->addSql('ALTER TABLE lignecommandes ADD livre_id INT NOT NULL, DROP commande_id_id, DROP livre_id_id, CHANGE commande_id commande_id INT NOT NULL');
        $this->addSql('ALTER TABLE lignecommandes ADD CONSTRAINT FK_448E7C7A37D925CB FOREIGN KEY (livre_id) REFERENCES livres (id)');
        $this->addSql('CREATE INDEX IDX_448E7C7A37D925CB ON lignecommandes (livre_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lignecommandes DROP FOREIGN KEY FK_448E7C7A37D925CB');
        $this->addSql('DROP INDEX IDX_448E7C7A37D925CB ON lignecommandes');
        $this->addSql('ALTER TABLE lignecommandes ADD livre_id_id INT NOT NULL, CHANGE commande_id commande_id INT DEFAULT NULL, CHANGE livre_id commande_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE lignecommandes ADD CONSTRAINT FK_448E7C7AEC470631 FOREIGN KEY (livre_id_id) REFERENCES livres (id)');
        $this->addSql('ALTER TABLE lignecommandes ADD CONSTRAINT FK_448E7C7A462C4194 FOREIGN KEY (commande_id_id) REFERENCES commande (id)');
        $this->addSql('CREATE INDEX IDX_448E7C7A462C4194 ON lignecommandes (commande_id_id)');
        $this->addSql('CREATE INDEX IDX_448E7C7AEC470631 ON lignecommandes (livre_id_id)');
    }
}
