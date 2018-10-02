<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181002091016 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE is_like DROP FOREIGN KEY FK_39906E92BA934BCD');
        $this->addSql('ALTER TABLE is_like ADD CONSTRAINT FK_39906E92BA934BCD FOREIGN KEY (quizz_id) REFERENCES quizz (id)');
        $this->addSql('ALTER TABLE crew_quizzs DROP FOREIGN KEY FK_C72984625FE259F6');
        $this->addSql('ALTER TABLE crew_quizzs DROP FOREIGN KEY FK_C7298462BA934BCD');
        $this->addSql('ALTER TABLE crew_quizzs ADD CONSTRAINT FK_C72984625FE259F6 FOREIGN KEY (crew_id) REFERENCES crew (id)');
        $this->addSql('ALTER TABLE crew_quizzs ADD CONSTRAINT FK_C7298462BA934BCD FOREIGN KEY (quizz_id) REFERENCES quizz (id)');
        $this->addSql('ALTER TABLE crew CHANGE slug slug VARCHAR(12) NOT NULL');
        $this->addSql('ALTER TABLE statistic DROP FOREIGN KEY FK_649B469CBA934BCD');
        $this->addSql('ALTER TABLE statistic ADD CONSTRAINT FK_649B469CBA934BCD FOREIGN KEY (quizz_id) REFERENCES quizz (id)');
        $this->addSql('ALTER TABLE user_crew DROP FOREIGN KEY FK_F3C80C7BA76ED395');
        $this->addSql('ALTER TABLE user_crew ADD CONSTRAINT FK_F3C80C7BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494EBA934BCD');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494EBA934BCD FOREIGN KEY (quizz_id) REFERENCES quizz (id)');
        $this->addSql('ALTER TABLE quizz ADD completed_at DATETIME DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7C77973D2B36786B ON quizz (title)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE crew CHANGE slug slug VARCHAR(128) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE crew_quizzs DROP FOREIGN KEY FK_C72984625FE259F6');
        $this->addSql('ALTER TABLE crew_quizzs DROP FOREIGN KEY FK_C7298462BA934BCD');
        $this->addSql('ALTER TABLE crew_quizzs ADD CONSTRAINT FK_C72984625FE259F6 FOREIGN KEY (crew_id) REFERENCES crew (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE crew_quizzs ADD CONSTRAINT FK_C7298462BA934BCD FOREIGN KEY (quizz_id) REFERENCES quizz (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE is_like DROP FOREIGN KEY FK_39906E92BA934BCD');
        $this->addSql('ALTER TABLE is_like ADD CONSTRAINT FK_39906E92BA934BCD FOREIGN KEY (quizz_id) REFERENCES quizz (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494EBA934BCD');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494EBA934BCD FOREIGN KEY (quizz_id) REFERENCES quizz (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('DROP INDEX UNIQ_7C77973D2B36786B ON quizz');
        $this->addSql('ALTER TABLE quizz DROP completed_at');
        $this->addSql('ALTER TABLE statistic DROP FOREIGN KEY FK_649B469CBA934BCD');
        $this->addSql('ALTER TABLE statistic ADD CONSTRAINT FK_649B469CBA934BCD FOREIGN KEY (quizz_id) REFERENCES quizz (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_crew DROP FOREIGN KEY FK_F3C80C7BA76ED395');
        $this->addSql('ALTER TABLE user_crew ADD CONSTRAINT FK_F3C80C7BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE CASCADE ON DELETE CASCADE');
    }
}
