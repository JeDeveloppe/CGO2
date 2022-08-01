<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220801050636 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE color_shop (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE type_of_shop ADD color_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE type_of_shop ADD CONSTRAINT FK_2173AB647ADA1FB5 FOREIGN KEY (color_id) REFERENCES color_shop (id)');
        $this->addSql('CREATE INDEX IDX_2173AB647ADA1FB5 ON type_of_shop (color_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE type_of_shop DROP FOREIGN KEY FK_2173AB647ADA1FB5');
        $this->addSql('DROP TABLE color_shop');
        $this->addSql('DROP INDEX IDX_2173AB647ADA1FB5 ON type_of_shop');
        $this->addSql('ALTER TABLE type_of_shop DROP color_id');
    }
}
