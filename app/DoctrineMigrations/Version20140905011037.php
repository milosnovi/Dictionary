<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140905011037 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('ALTER TABLE Eng2srb CHANGE relevance relevance INT NOT NULL');
        $this->addSql('ALTER TABLE Synonyms CHANGE synonym_id synonym_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE Synonyms ADD CONSTRAINT FK_7761D6818C1B728E FOREIGN KEY (synonym_id) REFERENCES word (id)');
        $this->addSql('CREATE INDEX IDX_7761D6818C1B728E ON Synonyms (synonym_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('ALTER TABLE Eng2srb CHANGE relevance relevance INT DEFAULT 1 NOT NULL');
        $this->addSql('ALTER TABLE Synonyms DROP FOREIGN KEY FK_7761D6818C1B728E');
        $this->addSql('DROP INDEX IDX_7761D6818C1B728E ON Synonyms');
        $this->addSql('ALTER TABLE Synonyms CHANGE synonym_id synonym_id INT NOT NULL');
    }
}
