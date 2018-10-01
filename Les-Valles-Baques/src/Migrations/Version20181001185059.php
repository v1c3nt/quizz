<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181001185059 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE is_like DROP FOREIGN KEY FK_39906E92BA934BCD');
        $this->addSql('ALTER TABLE is_like ADD CONSTRAINT FK_39906E92BA934BCD FOREIGN KEY (quizz_id) REFERENCES quizz (id)');
        $this->addSql('ALTER TABLE statistic DROP FOREIGN KEY FK_649B469CBA934BCD');
        $this->addSql('ALTER TABLE statistic ADD CONSTRAINT FK_649B469CBA934BCD FOREIGN KEY (quizz_id) REFERENCES quizz (id)');
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494EBA934BCD');
        $this->addSql('ALTER TABLE question ADD image_file VARCHAR(255) DEFAULT NULL, ADD image VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494EBA934BCD FOREIGN KEY (quizz_id) REFERENCES quizz (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE crew CHANGE slug slug VARCHAR(128) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE is_like DROP FOREIGN KEY FK_39906E92BA934BCD');
        $this->addSql('ALTER TABLE is_like ADD CONSTRAINT FK_39906E92BA934BCD FOREIGN KEY (quizz_id) REFERENCES quizz (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494EBA934BCD');
        $this->addSql('ALTER TABLE question DROP image_file, DROP image');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494EBA934BCD FOREIGN KEY (quizz_id) REFERENCES quizz (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE statistic DROP FOREIGN KEY FK_649B469CBA934BCD');
        $this->addSql('ALTER TABLE statistic ADD CONSTRAINT FK_649B469CBA934BCD FOREIGN KEY (quizz_id) REFERENCES quizz (id) ON UPDATE CASCADE ON DELETE CASCADE');
    }
}
