<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181001123207 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE crew_quizzs (crew_id INT NOT NULL, quizz_id INT NOT NULL, INDEX IDX_C72984625FE259F6 (crew_id), INDEX IDX_C7298462BA934BCD (quizz_id), PRIMARY KEY(crew_id, quizz_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE crew_quizzs ADD CONSTRAINT FK_C72984625FE259F6 FOREIGN KEY (crew_id) REFERENCES crew (id)');
        $this->addSql('ALTER TABLE crew_quizzs ADD CONSTRAINT FK_C7298462BA934BCD FOREIGN KEY (quizz_id) REFERENCES quizz (id)');

        $this->addSql('ALTER TABLE statistic ADD answers LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\'');
        $this->addSql('ALTER TABLE crew CHANGE slug slug VARCHAR(12) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_894940B25E237E06 ON crew (name)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE crew_quizzs');
        $this->addSql('DROP INDEX UNIQ_894940B25E237E06 ON crew');
        $this->addSql('ALTER TABLE crew CHANGE slug slug VARCHAR(128) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE statistic DROP answers');
    }
}
