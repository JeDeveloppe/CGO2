<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220731183952 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE departement_cgo (departement_id INT NOT NULL, cgo_id INT NOT NULL, INDEX IDX_D37681D2CCF9E01E (departement_id), INDEX IDX_D37681D2EEF58C7D (cgo_id), PRIMARY KEY(departement_id, cgo_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE departement_cgo ADD CONSTRAINT FK_D37681D2CCF9E01E FOREIGN KEY (departement_id) REFERENCES departement (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE departement_cgo ADD CONSTRAINT FK_D37681D2EEF58C7D FOREIGN KEY (cgo_id) REFERENCES cgo (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE departement_cgo');
    }
}
