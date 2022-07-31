<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220731183812 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE departement DROP FOREIGN KEY FK_C1765B63EEF58C7D');
        $this->addSql('DROP INDEX IDX_C1765B63EEF58C7D ON departement');
        $this->addSql('ALTER TABLE departement DROP cgo_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE departement ADD cgo_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE departement ADD CONSTRAINT FK_C1765B63EEF58C7D FOREIGN KEY (cgo_id) REFERENCES cgo (id)');
        $this->addSql('CREATE INDEX IDX_C1765B63EEF58C7D ON departement (cgo_id)');
    }
}
