<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230623142722 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE citations (id INT AUTO_INCREMENT NOT NULL, auteurs_id INT NOT NULL, citation VARCHAR(127) NOT NULL, explication LONGTEXT DEFAULT NULL, date_modif DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_AC492EACAE784107 (auteurs_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE citations ADD CONSTRAINT FK_AC492EACAE784107 FOREIGN KEY (auteurs_id) REFERENCES auteurs (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE citations DROP FOREIGN KEY FK_AC492EACAE784107');
        $this->addSql('DROP TABLE citations');
    }
}
