<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190222141626 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE voiture DROP FOREIGN KEY FK_E9E2810F4584665A');
        $this->addSql('DROP INDEX UNIQ_E9E2810F4584665A ON voiture');
        $this->addSql('ALTER TABLE voiture ADD product VARCHAR(255) NOT NULL, DROP product_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE voiture ADD product_id INT DEFAULT NULL, DROP product');
        $this->addSql('ALTER TABLE voiture ADD CONSTRAINT FK_E9E2810F4584665A FOREIGN KEY (product_id) REFERENCES produit (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E9E2810F4584665A ON voiture (product_id)');
    }
}
