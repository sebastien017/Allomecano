<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190926123634 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE garage_service (garage_id INT NOT NULL, service_id INT NOT NULL, INDEX IDX_67DD7642C4FFF555 (garage_id), INDEX IDX_67DD7642ED5CA9E6 (service_id), PRIMARY KEY(garage_id, service_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE garage_service ADD CONSTRAINT FK_67DD7642C4FFF555 FOREIGN KEY (garage_id) REFERENCES garage (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE garage_service ADD CONSTRAINT FK_67DD7642ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE visit ADD garage_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE visit ADD CONSTRAINT FK_437EE939C4FFF555 FOREIGN KEY (garage_id) REFERENCES garage (id)');
        $this->addSql('CREATE INDEX IDX_437EE939C4FFF555 ON visit (garage_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE garage_service');
        $this->addSql('ALTER TABLE visit DROP FOREIGN KEY FK_437EE939C4FFF555');
        $this->addSql('DROP INDEX IDX_437EE939C4FFF555 ON visit');
        $this->addSql('ALTER TABLE visit DROP garage_id');
    }
}
