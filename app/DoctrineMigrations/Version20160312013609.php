<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160312013609 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE eng2srb (id INT AUTO_INCREMENT NOT NULL, srb_id INT DEFAULT NULL, eng_id INT DEFAULT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, relevance INT NOT NULL, direction INT NOT NULL, word_type INT NOT NULL, INDEX IDX_2093BDF4F00825FE (eng_id), INDEX IDX_2093BDF4B7494EC9 (srb_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE history (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, word_id INT DEFAULT NULL, last_search DATETIME NOT NULL, hits INT NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, INDEX IDX_E80749D7E357438D (word_id), INDEX IDX_E80749D7A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mismatch (id INT AUTO_INCREMENT NOT NULL, value VARCHAR(256) NOT NULL, created DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE piles (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, word_id INT DEFAULT NULL, type INT NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, INDEX IDX_28540D7FE357438D (word_id), INDEX IDX_28540D7FA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, username_canonical VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, email_canonical VARCHAR(255) NOT NULL, enabled TINYINT(1) NOT NULL, salt VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, last_login DATETIME DEFAULT NULL, locked TINYINT(1) NOT NULL, expired TINYINT(1) NOT NULL, expires_at DATETIME DEFAULT NULL, confirmation_token VARCHAR(255) DEFAULT NULL, password_requested_at DATETIME DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', credentials_expired TINYINT(1) NOT NULL, credentials_expire_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_1483A5E992FC23A8 (username_canonical), UNIQUE INDEX UNIQ_1483A5E9A0D96FBF (email_canonical), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE words (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, type INT NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, INDEX search_index_word (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE eng2srb ADD CONSTRAINT FK_EF2E8468B7494EC9 FOREIGN KEY (srb_id) REFERENCES words (id)');
        $this->addSql('ALTER TABLE eng2srb ADD CONSTRAINT FK_EF2E8468F00825FE FOREIGN KEY (eng_id) REFERENCES words (id)');
        $this->addSql('ALTER TABLE history ADD CONSTRAINT FK_27BA704BA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE history ADD CONSTRAINT FK_27BA704BE357438D FOREIGN KEY (word_id) REFERENCES words (id)');
        $this->addSql('ALTER TABLE piles ADD CONSTRAINT FK_E995227BA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE piles ADD CONSTRAINT FK_E995227BE357438D FOREIGN KEY (word_id) REFERENCES words (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE history DROP FOREIGN KEY FK_27BA704BA76ED395');
        $this->addSql('ALTER TABLE piles DROP FOREIGN KEY FK_E995227BA76ED395');
        $this->addSql('ALTER TABLE eng2srb DROP FOREIGN KEY FK_EF2E8468B7494EC9');
        $this->addSql('ALTER TABLE eng2srb DROP FOREIGN KEY FK_EF2E8468F00825FE');
        $this->addSql('ALTER TABLE history DROP FOREIGN KEY FK_27BA704BE357438D');
        $this->addSql('ALTER TABLE piles DROP FOREIGN KEY FK_E995227BE357438D');
        $this->addSql('DROP TABLE eng2srb');
        $this->addSql('DROP TABLE history');
        $this->addSql('DROP TABLE mismatch');
        $this->addSql('DROP TABLE piles');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE words');
    }
}
