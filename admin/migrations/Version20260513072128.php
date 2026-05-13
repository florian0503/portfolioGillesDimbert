<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260513072128 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE experience (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, sort_order INTEGER NOT NULL, period VARCHAR(50) NOT NULL, type VARCHAR(20) NOT NULL, company VARCHAR(255) NOT NULL, company_subtitle VARCHAR(255) DEFAULT NULL, role VARCHAR(255) NOT NULL, context CLOB NOT NULL, logo VARCHAR(255) DEFAULT NULL, detail_groups CLOB NOT NULL, external_links CLOB NOT NULL, tags CLOB NOT NULL)');
        $this->addSql('CREATE TABLE expertise (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, sort_order INTEGER NOT NULL, title VARCHAR(255) NOT NULL, description CLOB NOT NULL, visible BOOLEAN NOT NULL)');
        $this->addSql('CREATE TABLE stat (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, sort_order INTEGER NOT NULL, target INTEGER NOT NULL, suffix VARCHAR(10) NOT NULL, label VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE temoignage (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, quote CLOB NOT NULL, author_name VARCHAR(255) NOT NULL, author_role VARCHAR(255) NOT NULL, category VARCHAR(50) NOT NULL, sort_order INTEGER NOT NULL, visible BOOLEAN NOT NULL)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE experience');
        $this->addSql('DROP TABLE expertise');
        $this->addSql('DROP TABLE stat');
        $this->addSql('DROP TABLE temoignage');
    }
}
