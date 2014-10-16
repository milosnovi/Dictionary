<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20141016211019 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('ALTER TABLE Eng2srb ADD word_type INT NOT NULL');
        $this->addSql('Update Eng2srb left join word on Eng2srb.srb_id = word.id set Eng2srb.word_type = word.word_type;');
        $this->addSql('ALTER TABLE word DROP word_type');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE word ADD word_type INT NOT NULL');
        $this->addSql('update word left join Eng2srb on Eng2srb.srb_id = word.id set word.word_type = Eng2srb.word_type;');
        $this->addSql('ALTER TABLE Eng2srb DROP word_type');
    }
}
