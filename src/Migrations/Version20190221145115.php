<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190221145115 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE produit_image');
        $this->addSql('ALTER TABLE produit ADD image_one_id INT DEFAULT NULL, ADD image_two_id INT DEFAULT NULL, ADD image_three_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC27548790DB FOREIGN KEY (image_one_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC273FDB7714 FOREIGN KEY (image_two_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC27F85183CD FOREIGN KEY (image_three_id) REFERENCES image (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_29A5EC27548790DB ON produit (image_one_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_29A5EC273FDB7714 ON produit (image_two_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_29A5EC27F85183CD ON produit (image_three_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE produit_image (produit_id INT NOT NULL, image_id INT NOT NULL, INDEX IDX_F5A163CBF347EFB (produit_id), INDEX IDX_F5A163CB3DA5256D (image_id), PRIMARY KEY(produit_id, image_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE produit_image ADD CONSTRAINT FK_F5A163CB3DA5256D FOREIGN KEY (image_id) REFERENCES image (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE produit_image ADD CONSTRAINT FK_F5A163CBF347EFB FOREIGN KEY (produit_id) REFERENCES produit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC27548790DB');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC273FDB7714');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC27F85183CD');
        $this->addSql('DROP INDEX UNIQ_29A5EC27548790DB ON produit');
        $this->addSql('DROP INDEX UNIQ_29A5EC273FDB7714 ON produit');
        $this->addSql('DROP INDEX UNIQ_29A5EC27F85183CD ON produit');
        $this->addSql('ALTER TABLE produit DROP image_one_id, DROP image_two_id, DROP image_three_id');
    }
}
