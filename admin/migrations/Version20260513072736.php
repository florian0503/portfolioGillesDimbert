<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260513072736 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE contact_info (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, phone VARCHAR(50) NOT NULL, email VARCHAR(255) NOT NULL, linkedin VARCHAR(255) NOT NULL, location VARCHAR(100) NOT NULL, availability VARCHAR(100) NOT NULL, extra_info VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE methode_step (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, sort_order INTEGER NOT NULL, day VARCHAR(20) NOT NULL, tag VARCHAR(255) NOT NULL, description CLOB NOT NULL)');
        $this->addSql('CREATE TABLE pitch_domain (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, sort_order INTEGER NOT NULL, title VARCHAR(255) NOT NULL, text CLOB NOT NULL)');
        $this->addSql('CREATE TABLE realisation (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, sort_order INTEGER NOT NULL, tab_label VARCHAR(100) NOT NULL, context_items CLOB NOT NULL, big_number VARCHAR(50) NOT NULL, big_number_suffix VARCHAR(10) NOT NULL, big_number_label VARCHAR(255) NOT NULL, result_items CLOB NOT NULL)');
        $this->addSql('CREATE TABLE source (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, sort_order INTEGER NOT NULL, badge VARCHAR(100) NOT NULL, title VARCHAR(255) NOT NULL, url VARCHAR(500) NOT NULL, visible BOOLEAN NOT NULL)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE contact_info');
        $this->addSql('DROP TABLE methode_step');
        $this->addSql('DROP TABLE pitch_domain');
        $this->addSql('DROP TABLE realisation');
        $this->addSql('DROP TABLE source');
    }
}
