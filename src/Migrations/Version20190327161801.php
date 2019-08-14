<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190327161801 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE produit DROP INDEX UNIQ_29A5EC27AC14B70A, ADD INDEX IDX_29A5EC27AC14B70A (modele_id)');
        $this->addSql('ALTER TABLE produit DROP INDEX UNIQ_29A5EC274827B9B2, ADD INDEX IDX_29A5EC274827B9B2 (marque_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE produit DROP INDEX IDX_29A5EC274827B9B2, ADD UNIQUE INDEX UNIQ_29A5EC274827B9B2 (marque_id)');
        $this->addSql('ALTER TABLE produit DROP INDEX IDX_29A5EC27AC14B70A, ADD UNIQUE INDEX UNIQ_29A5EC27AC14B70A (modele_id)');
    }
}
