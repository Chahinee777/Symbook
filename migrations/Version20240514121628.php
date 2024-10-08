<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240514121628 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D6702C95E');
        $this->addSql('DROP INDEX IDX_6EEAA67D6702C95E ON commande');
        $this->addSql('ALTER TABLE commande DROP id_livre_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande ADD id_livre_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D6702C95E FOREIGN KEY (id_livre_id) REFERENCES livres (id)');
        $this->addSql('CREATE INDEX IDX_6EEAA67D6702C95E ON commande (id_livre_id)');
    }
}
