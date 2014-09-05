<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140903205604 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('CREATE TABLE Piles (id INT AUTO_INCREMENT NOT NULL, word_id INT DEFAULT NULL, user_id INT DEFAULT NULL, type INT NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, INDEX IDX_28540D7FE357438D (word_id), INDEX IDX_28540D7FA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Synonyms (id INT AUTO_INCREMENT NOT NULL, word_id INT DEFAULT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, INDEX IDX_7761D681E357438D (word_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE Piles ADD CONSTRAINT FK_28540D7FE357438D FOREIGN KEY (word_id) REFERENCES word (id)');
        $this->addSql('ALTER TABLE Piles ADD CONSTRAINT FK_28540D7FA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE Synonyms ADD CONSTRAINT FK_7761D681E357438D FOREIGN KEY (word_id) REFERENCES word (id)');
        $this->addSql('ALTER TABLE Eng2srb ADD relevance INT NOT NULL');
        $this->addSql('ALTER TABLE word ADD word_type INT NOT NULL');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('DROP TABLE Piles');
        $this->addSql('DROP TABLE Synonyms');
        $this->addSql('ALTER TABLE Eng2srb DROP relevance');
        $this->addSql('ALTER TABLE word DROP word_type');
    }
}
