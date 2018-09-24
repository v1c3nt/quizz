<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180924212330 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE is_like DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE is_like ADD PRIMARY KEY (like_it, user_id, quizz_id)');
        $this->addSql('ALTER TABLE quizz DROP updated_at');
        $this->addSql('ALTER TABLE user DROP updated_at');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE is_like DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE is_like ADD PRIMARY KEY (user_id, quizz_id)');
        $this->addSql('ALTER TABLE quizz ADD updated_at DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD updated_at DATE DEFAULT NULL');
    }
}
