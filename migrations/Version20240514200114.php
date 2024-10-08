<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240514200114 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lignecommandes ADD commande_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE lignecommandes ADD CONSTRAINT FK_448E7C7A82EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
        $this->addSql('CREATE INDEX IDX_448E7C7A82EA2E54 ON lignecommandes (commande_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lignecommandes DROP FOREIGN KEY FK_448E7C7A82EA2E54');
        $this->addSql('DROP INDEX IDX_448E7C7A82EA2E54 ON lignecommandes');
        $this->addSql('ALTER TABLE lignecommandes DROP commande_id');
    }
}
