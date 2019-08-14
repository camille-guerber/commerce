<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190322104029 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE marque_modele (marque_id INT NOT NULL, modele_id INT NOT NULL, INDEX IDX_1CFB4CB14827B9B2 (marque_id), INDEX IDX_1CFB4CB1AC14B70A (modele_id), PRIMARY KEY(marque_id, modele_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE marque_modele ADD CONSTRAINT FK_1CFB4CB14827B9B2 FOREIGN KEY (marque_id) REFERENCES marque (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE marque_modele ADD CONSTRAINT FK_1CFB4CB1AC14B70A FOREIGN KEY (modele_id) REFERENCES modele (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE marque DROP FOREIGN KEY FK_5A6F91CE708408C');
        $this->addSql('DROP INDEX IDX_5A6F91CE708408C ON marque');
        $this->addSql('ALTER TABLE marque DROP modeles_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE marque_modele');
        $this->addSql('ALTER TABLE marque ADD modeles_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE marque ADD CONSTRAINT FK_5A6F91CE708408C FOREIGN KEY (modeles_id) REFERENCES modele (id)');
        $this->addSql('CREATE INDEX IDX_5A6F91CE708408C ON marque (modeles_id)');
    }
}
