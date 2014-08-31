<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140831210603 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('CREATE TABLE Eng2srb (id INT AUTO_INCREMENT NOT NULL, eng_id INT DEFAULT NULL, srb_id INT DEFAULT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, INDEX IDX_2093BDF4F00825FE (eng_id), INDEX IDX_2093BDF4B7494EC9 (srb_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE History (id INT AUTO_INCREMENT NOT NULL, word_id INT DEFAULT NULL, user_id INT DEFAULT NULL, last_search DATETIME NOT NULL, hits INT NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, INDEX IDX_E80749D7E357438D (word_id), INDEX IDX_E80749D7A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, username_canonical VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, email_canonical VARCHAR(255) NOT NULL, enabled TINYINT(1) NOT NULL, salt VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, last_login DATETIME DEFAULT NULL, locked TINYINT(1) NOT NULL, expired TINYINT(1) NOT NULL, expires_at DATETIME DEFAULT NULL, confirmation_token VARCHAR(255) DEFAULT NULL, password_requested_at DATETIME DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', credentials_expired TINYINT(1) NOT NULL, credentials_expire_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_1483A5E992FC23A8 (username_canonical), UNIQUE INDEX UNIQ_1483A5E9A0D96FBF (email_canonical), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE word (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, type INT NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, INDEX search_index_word (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE Eng2srb ADD CONSTRAINT FK_2093BDF4F00825FE FOREIGN KEY (eng_id) REFERENCES word (id)');
        $this->addSql('ALTER TABLE Eng2srb ADD CONSTRAINT FK_2093BDF4B7494EC9 FOREIGN KEY (srb_id) REFERENCES word (id)');
        $this->addSql('ALTER TABLE History ADD CONSTRAINT FK_E80749D7E357438D FOREIGN KEY (word_id) REFERENCES word (id)');
        $this->addSql('ALTER TABLE History ADD CONSTRAINT FK_E80749D7A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('ALTER TABLE History DROP FOREIGN KEY FK_E80749D7A76ED395');
        $this->addSql('ALTER TABLE Eng2srb DROP FOREIGN KEY FK_2093BDF4F00825FE');
        $this->addSql('ALTER TABLE Eng2srb DROP FOREIGN KEY FK_2093BDF4B7494EC9');
        $this->addSql('ALTER TABLE History DROP FOREIGN KEY FK_E80749D7E357438D');
        $this->addSql('DROP TABLE Eng2srb');
        $this->addSql('DROP TABLE History');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE word');
    }
}
