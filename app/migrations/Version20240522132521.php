<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240522132521 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE trip ADD type_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE trip ADD CONSTRAINT FK_7656F53BC54C8C93 FOREIGN KEY (type_id) REFERENCES trip_type (id)');
        $this->addSql('CREATE INDEX IDX_7656F53BC54C8C93 ON trip (type_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE trip DROP FOREIGN KEY FK_7656F53BC54C8C93');
        $this->addSql('DROP INDEX IDX_7656F53BC54C8C93 ON trip');
        $this->addSql('ALTER TABLE trip DROP type_id');
    }
}
