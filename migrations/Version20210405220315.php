<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210405220315 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE prefecture (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nom VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__association AS SELECT id, nom, nombre, date FROM association');
        $this->addSql('DROP TABLE association');
        $this->addSql('CREATE TABLE association (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, prefecture_id INTEGER DEFAULT NULL, nom VARCHAR(255) NOT NULL COLLATE BINARY, nombre INTEGER DEFAULT NULL, date DATE DEFAULT NULL, CONSTRAINT FK_FD8521CC9D39C865 FOREIGN KEY (prefecture_id) REFERENCES prefecture (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO association (id, nom, nombre, date) SELECT id, nom, nombre, date FROM __temp__association');
        $this->addSql('DROP TABLE __temp__association');
        $this->addSql('CREATE INDEX IDX_FD8521CC9D39C865 ON association (prefecture_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE prefecture');
        $this->addSql('DROP INDEX IDX_FD8521CC9D39C865');
        $this->addSql('CREATE TEMPORARY TABLE __temp__association AS SELECT id, nom, nombre, date FROM association');
        $this->addSql('DROP TABLE association');
        $this->addSql('CREATE TABLE association (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, nombre INTEGER DEFAULT NULL, date DATE DEFAULT NULL)');
        $this->addSql('INSERT INTO association (id, nom, nombre, date) SELECT id, nom, nombre, date FROM __temp__association');
        $this->addSql('DROP TABLE __temp__association');
    }
}
