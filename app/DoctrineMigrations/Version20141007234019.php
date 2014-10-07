<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20141007234019 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('DROP TABLE Synonyms');
        $this->addSql('ALTER TABLE Eng2srb DROP FOREIGN KEY FK_2093BDF4B7494EC9');
        $this->addSql('ALTER TABLE Eng2srb DROP FOREIGN KEY FK_2093BDF4F00825FE');
        $this->addSql('ALTER TABLE Eng2srb CHANGE direction direction INT NOT NULL');
        $this->addSql('ALTER TABLE Eng2srb ADD CONSTRAINT FK_2093BDF4B7494EC9 FOREIGN KEY (srb_id) REFERENCES word (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE Eng2srb ADD CONSTRAINT FK_2093BDF4F00825FE FOREIGN KEY (eng_id) REFERENCES word (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE History DROP FOREIGN KEY FK_E80749D7A76ED395');
        $this->addSql('ALTER TABLE History DROP FOREIGN KEY FK_E80749D7E357438D');
        $this->addSql('ALTER TABLE History ADD CONSTRAINT FK_E80749D7A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE History ADD CONSTRAINT FK_E80749D7E357438D FOREIGN KEY (word_id) REFERENCES word (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE Piles DROP FOREIGN KEY FK_28540D7FA76ED395');
        $this->addSql('ALTER TABLE Piles DROP FOREIGN KEY FK_28540D7FE357438D');
        $this->addSql('ALTER TABLE Piles ADD CONSTRAINT FK_28540D7FA76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE Piles ADD CONSTRAINT FK_28540D7FE357438D FOREIGN KEY (word_id) REFERENCES word (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('CREATE TABLE Synonyms (id INT AUTO_INCREMENT NOT NULL, synonym_id INT DEFAULT NULL, word_id INT DEFAULT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, INDEX IDX_7761D681E357438D (word_id), INDEX IDX_7761D6818C1B728E (synonym_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE synonyms ADD CONSTRAINT FK_7761D6818C1B728E FOREIGN KEY (synonym_id) REFERENCES word (id)');
        $this->addSql('ALTER TABLE synonyms ADD CONSTRAINT FK_7761D681E357438D FOREIGN KEY (word_id) REFERENCES word (id)');
        $this->addSql('ALTER TABLE Eng2srb DROP FOREIGN KEY FK_2093BDF4F00825FE');
        $this->addSql('ALTER TABLE Eng2srb DROP FOREIGN KEY FK_2093BDF4B7494EC9');
        $this->addSql('ALTER TABLE Eng2srb CHANGE direction direction INT DEFAULT 1 NOT NULL');
        $this->addSql('ALTER TABLE Eng2srb ADD CONSTRAINT FK_2093BDF4F00825FE FOREIGN KEY (eng_id) REFERENCES word (id)');
        $this->addSql('ALTER TABLE Eng2srb ADD CONSTRAINT FK_2093BDF4B7494EC9 FOREIGN KEY (srb_id) REFERENCES word (id)');
        $this->addSql('ALTER TABLE History DROP FOREIGN KEY FK_E80749D7E357438D');
        $this->addSql('ALTER TABLE History DROP FOREIGN KEY FK_E80749D7A76ED395');
        $this->addSql('ALTER TABLE History ADD CONSTRAINT FK_E80749D7E357438D FOREIGN KEY (word_id) REFERENCES word (id)');
        $this->addSql('ALTER TABLE History ADD CONSTRAINT FK_E80749D7A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE Piles DROP FOREIGN KEY FK_28540D7FE357438D');
        $this->addSql('ALTER TABLE Piles DROP FOREIGN KEY FK_28540D7FA76ED395');
        $this->addSql('ALTER TABLE Piles ADD CONSTRAINT FK_28540D7FE357438D FOREIGN KEY (word_id) REFERENCES word (id)');
        $this->addSql('ALTER TABLE Piles ADD CONSTRAINT FK_28540D7FA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
    }
}
