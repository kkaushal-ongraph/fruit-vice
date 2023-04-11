<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230322094142 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE fruits (id INT AUTO_INCREMENT NOT NULL, fruit_genus VARCHAR(255) NOT NULL, fruit_name VARCHAR(255) NOT NULL, fruit_id INT NOT NULL, fruit_family VARCHAR(255) NOT NULL, fruit_order VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_75C5C23EBAC115F0 (fruit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE nutritions (id INT AUTO_INCREMENT NOT NULL, fruit_id INT NOT NULL, fruit_carbohydrates VARCHAR(255) NOT NULL, fruit_protein VARCHAR(255) NOT NULL, fruit_fat VARCHAR(255) NOT NULL, fruit_calories VARCHAR(255) NOT NULL, fruit_sugar VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_D103CEE1BAC115F0 (fruit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE fruits');
        $this->addSql('DROP TABLE nutritions');
    }
}
