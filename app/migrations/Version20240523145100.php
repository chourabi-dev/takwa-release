<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240523145100 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE trip_reservation (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, trip_id INT DEFAULT NULL, created_at DATETIME NOT NULL, INDEX IDX_B6E9EEDFA76ED395 (user_id), INDEX IDX_B6E9EEDFA5BC2E0E (trip_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE trip_reservation ADD CONSTRAINT FK_B6E9EEDFA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE trip_reservation ADD CONSTRAINT FK_B6E9EEDFA5BC2E0E FOREIGN KEY (trip_id) REFERENCES trip (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE trip_reservation DROP FOREIGN KEY FK_B6E9EEDFA76ED395');
        $this->addSql('ALTER TABLE trip_reservation DROP FOREIGN KEY FK_B6E9EEDFA5BC2E0E');
        $this->addSql('DROP TABLE trip_reservation');
    }
}
