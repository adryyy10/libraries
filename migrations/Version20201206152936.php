<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201206152936 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE biblioteca (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE libro (id INT AUTO_INCREMENT NOT NULL, biblioteca_id INT NOT NULL, titulo VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_5799AD2B6A5EDAE9 (biblioteca_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE prestamo (id INT AUTO_INCREMENT NOT NULL, libro_id INT DEFAULT NULL, created_by_id INT DEFAULT NULL, nombre VARCHAR(255) DEFAULT NULL, email VARCHAR(255) NOT NULL, idioma VARCHAR(50) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_F4D874F2C0238522 (libro_id), INDEX IDX_F4D874F2B03A8386 (created_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE usuario (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(50) NOT NULL, username VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_2265B05DF85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE libro ADD CONSTRAINT FK_5799AD2B6A5EDAE9 FOREIGN KEY (biblioteca_id) REFERENCES biblioteca (id)');
        $this->addSql('ALTER TABLE prestamo ADD CONSTRAINT FK_F4D874F2C0238522 FOREIGN KEY (libro_id) REFERENCES libro (id)');
        $this->addSql('ALTER TABLE prestamo ADD CONSTRAINT FK_F4D874F2B03A8386 FOREIGN KEY (created_by_id) REFERENCES usuario (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE libro DROP FOREIGN KEY FK_5799AD2B6A5EDAE9');
        $this->addSql('ALTER TABLE prestamo DROP FOREIGN KEY FK_F4D874F2C0238522');
        $this->addSql('ALTER TABLE prestamo DROP FOREIGN KEY FK_F4D874F2B03A8386');
        $this->addSql('DROP TABLE biblioteca');
        $this->addSql('DROP TABLE libro');
        $this->addSql('DROP TABLE prestamo');
        $this->addSql('DROP TABLE usuario');
    }
}
