<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240527112552 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bus_trip (id INT AUTO_INCREMENT NOT NULL, driver_id INT DEFAULT NULL, trip_id INT DEFAULT NULL, status INT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_295B8A71C3423909 (driver_id), INDEX IDX_295B8A71A5BC2E0E (trip_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bus_trip ADD CONSTRAINT FK_295B8A71C3423909 FOREIGN KEY (driver_id) REFERENCES bus_driver (id)');
        $this->addSql('ALTER TABLE bus_trip ADD CONSTRAINT FK_295B8A71A5BC2E0E FOREIGN KEY (trip_id) REFERENCES bus_reservations (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bus_trip DROP FOREIGN KEY FK_295B8A71C3423909');
        $this->addSql('ALTER TABLE bus_trip DROP FOREIGN KEY FK_295B8A71A5BC2E0E');
        $this->addSql('DROP TABLE bus_trip');
    }
}
