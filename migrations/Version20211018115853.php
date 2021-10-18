<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211018115853 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE customer (id INT AUTO_INCREMENT NOT NULL, company_name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, registered_since DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mobile_phone (id INT AUTO_INCREMENT NOT NULL, model VARCHAR(255) NOT NULL, manufacturer VARCHAR(255) NOT NULL, year VARCHAR(255) NOT NULL, price NUMERIC(6, 2) NOT NULL, description LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, customer_id INT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, INDEX IDX_8D93D6499395C3F3 (customer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_mobile_phone (user_id INT NOT NULL, mobile_phone_id INT NOT NULL, INDEX IDX_8A655A93A76ED395 (user_id), INDEX IDX_8A655A93F6448F95 (mobile_phone_id), PRIMARY KEY(user_id, mobile_phone_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6499395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id)');
        $this->addSql('ALTER TABLE user_mobile_phone ADD CONSTRAINT FK_8A655A93A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_mobile_phone ADD CONSTRAINT FK_8A655A93F6448F95 FOREIGN KEY (mobile_phone_id) REFERENCES mobile_phone (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6499395C3F3');
        $this->addSql('ALTER TABLE user_mobile_phone DROP FOREIGN KEY FK_8A655A93F6448F95');
        $this->addSql('ALTER TABLE user_mobile_phone DROP FOREIGN KEY FK_8A655A93A76ED395');
        $this->addSql('DROP TABLE customer');
        $this->addSql('DROP TABLE mobile_phone');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_mobile_phone');
    }
}
