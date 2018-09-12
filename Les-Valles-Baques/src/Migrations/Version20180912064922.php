<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180912064922 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE quizz ADD crew_id INT DEFAULT NULL, ADD is_private TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE quizz ADD CONSTRAINT FK_7C77973D5FE259F6 FOREIGN KEY (crew_id) REFERENCES crew (id)');
        $this->addSql('CREATE INDEX IDX_7C77973D5FE259F6 ON quizz (crew_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE quizz DROP FOREIGN KEY FK_7C77973D5FE259F6');
        $this->addSql('DROP INDEX IDX_7C77973D5FE259F6 ON quizz');
        $this->addSql('ALTER TABLE quizz DROP crew_id, DROP is_private');
    }
}
