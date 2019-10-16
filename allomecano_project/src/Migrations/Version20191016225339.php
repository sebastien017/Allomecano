<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191016225339 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, firstname VARCHAR(100) NOT NULL, lastname VARCHAR(100) NOT NULL, phone INT NOT NULL, adress VARCHAR(255) DEFAULT NULL, avatar LONGTEXT DEFAULT NULL, email VARCHAR(320) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, gps VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, garage_id INT DEFAULT NULL, content LONGTEXT DEFAULT NULL, rate INT NOT NULL, created_at DATETIME NOT NULL, enable TINYINT(1) NOT NULL, INDEX IDX_9474526CA76ED395 (user_id), INDEX IDX_9474526CC4FFF555 (garage_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, garage_id INT DEFAULT NULL, url LONGTEXT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, filename VARCHAR(255) NOT NULL, INDEX IDX_C53D045FC4FFF555 (garage_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE visit (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, garage_id INT DEFAULT NULL, service_id INT DEFAULT NULL, date DATE NOT NULL, time TIME NOT NULL, reservation_date DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_437EE939A76ED395 (user_id), INDEX IDX_437EE939C4FFF555 (garage_id), INDEX IDX_437EE939ED5CA9E6 (service_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE garage (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, name VARCHAR(100) NOT NULL, adress VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, mobility TINYINT(1) DEFAULT NULL, distance INT DEFAULT NULL, gps VARCHAR(255) NOT NULL, presentation LONGTEXT DEFAULT NULL, avatar LONGTEXT DEFAULT NULL, lat VARCHAR(255) DEFAULT NULL, lng VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_9F26610BA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE garage_service (garage_id INT NOT NULL, service_id INT NOT NULL, INDEX IDX_67DD7642C4FFF555 (garage_id), INDEX IDX_67DD7642ED5CA9E6 (service_id), PRIMARY KEY(garage_id, service_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, price INT NOT NULL, image LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CC4FFF555 FOREIGN KEY (garage_id) REFERENCES garage (id)');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045FC4FFF555 FOREIGN KEY (garage_id) REFERENCES garage (id)');
        $this->addSql('ALTER TABLE visit ADD CONSTRAINT FK_437EE939A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE visit ADD CONSTRAINT FK_437EE939C4FFF555 FOREIGN KEY (garage_id) REFERENCES garage (id)');
        $this->addSql('ALTER TABLE visit ADD CONSTRAINT FK_437EE939ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)');
        $this->addSql('ALTER TABLE garage ADD CONSTRAINT FK_9F26610BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE garage_service ADD CONSTRAINT FK_67DD7642C4FFF555 FOREIGN KEY (garage_id) REFERENCES garage (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE garage_service ADD CONSTRAINT FK_67DD7642ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CA76ED395');
        $this->addSql('ALTER TABLE visit DROP FOREIGN KEY FK_437EE939A76ED395');
        $this->addSql('ALTER TABLE garage DROP FOREIGN KEY FK_9F26610BA76ED395');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CC4FFF555');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045FC4FFF555');
        $this->addSql('ALTER TABLE visit DROP FOREIGN KEY FK_437EE939C4FFF555');
        $this->addSql('ALTER TABLE garage_service DROP FOREIGN KEY FK_67DD7642C4FFF555');
        $this->addSql('ALTER TABLE visit DROP FOREIGN KEY FK_437EE939ED5CA9E6');
        $this->addSql('ALTER TABLE garage_service DROP FOREIGN KEY FK_67DD7642ED5CA9E6');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE visit');
        $this->addSql('DROP TABLE garage');
        $this->addSql('DROP TABLE garage_service');
        $this->addSql('DROP TABLE service');
    }
}
