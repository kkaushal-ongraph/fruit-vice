<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230322141649 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE favourite CHANGE fruit_id fruit_id INT NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_62A2CA19BAC115F0 ON favourite (fruit_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_62A2CA19BAC115F0 ON favourite');
        $this->addSql('ALTER TABLE favourite CHANGE fruit_id fruit_id INT DEFAULT NULL');
    }
}
