<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20181110050808 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE event ADD fk_category_id INT NOT NULL');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA77BB031D6 FOREIGN KEY (fk_category_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_3BAE0AA77BB031D6 ON event (fk_category_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA77BB031D6');
        $this->addSql('DROP INDEX IDX_3BAE0AA77BB031D6 ON event');
        $this->addSql('ALTER TABLE event DROP fk_category_id');
    }
}
