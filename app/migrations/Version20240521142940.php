<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240521142940 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bus_reservations ADD client_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE bus_reservations ADD CONSTRAINT FK_A4ED971A19EB6921 FOREIGN KEY (client_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_A4ED971A19EB6921 ON bus_reservations (client_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bus_reservations DROP FOREIGN KEY FK_A4ED971A19EB6921');
        $this->addSql('DROP INDEX IDX_A4ED971A19EB6921 ON bus_reservations');
        $this->addSql('ALTER TABLE bus_reservations DROP client_id');
    }
}
