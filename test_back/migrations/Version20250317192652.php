<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250317192652 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE band_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE concert_hall_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE band (id INT NOT NULL, name VARCHAR(255) DEFAULT NULL, origin VARCHAR(255) DEFAULT NULL, ville VARCHAR(255) DEFAULT NULL, year INT DEFAULT NULL, separation INT DEFAULT NULL, fondateur VARCHAR(255) DEFAULT NULL, membre VARCHAR(255) DEFAULT NULL, music VARCHAR(255) DEFAULT NULL, presentation VARCHAR(10000) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE band_concerthalls (band_id INT NOT NULL, concert_hall_id INT NOT NULL, PRIMARY KEY(band_id, concert_hall_id))');
        $this->addSql('CREATE INDEX IDX_C3E77AAF49ABEB17 ON band_concerthalls (band_id)');
        $this->addSql('CREATE INDEX IDX_C3E77AAFC8B57370 ON band_concerthalls (concert_hall_id)');
        $this->addSql('CREATE TABLE concert_hall (id INT NOT NULL, name VARCHAR(255) DEFAULT NULL, location VARCHAR(255) DEFAULT NULL, date VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE band_concerthalls ADD CONSTRAINT FK_C3E77AAF49ABEB17 FOREIGN KEY (band_id) REFERENCES band (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE band_concerthalls ADD CONSTRAINT FK_C3E77AAFC8B57370 FOREIGN KEY (concert_hall_id) REFERENCES concert_hall (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE band_concerthalls DROP CONSTRAINT FK_C3E77AAF49ABEB17');
        $this->addSql('ALTER TABLE band_concerthalls DROP CONSTRAINT FK_C3E77AAFC8B57370');
        $this->addSql('DROP SEQUENCE band_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE concert_hall_id_seq CASCADE');
        $this->addSql('DROP TABLE band');
        $this->addSql('DROP TABLE band_concerthalls');
        $this->addSql('DROP TABLE concert_hall');
    }
}
