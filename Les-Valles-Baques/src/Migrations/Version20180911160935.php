<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180911160935 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE question (id INT AUTO_INCREMENT NOT NULL, quizz_id INT NOT NULL, level_id INT NOT NULL, body VARCHAR(255) NOT NULL, prop1 VARCHAR(128) NOT NULL, prop2 VARCHAR(128) NOT NULL, prop3 VARCHAR(128) NOT NULL, prop4 VARCHAR(128) NOT NULL, anecdote VARCHAR(255) DEFAULT NULL, source VARCHAR(255) DEFAULT NULL, errore TINYINT(1) NOT NULL, INDEX IDX_B6F7494EBA934BCD (quizz_id), INDEX IDX_B6F7494E5FB14BA7 (level_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE is_like (user_id INT NOT NULL, quizz_id INT NOT NULL, like_it TINYINT(1) NOT NULL, INDEX IDX_39906E92A76ED395 (user_id), INDEX IDX_39906E92BA934BCD (quizz_id), PRIMARY KEY(user_id, quizz_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(64) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_crew (user_id INT NOT NULL, crew_id INT NOT NULL, role_crew_id INT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_F3C80C7BA76ED395 (user_id), INDEX IDX_F3C80C7B5FE259F6 (crew_id), INDEX IDX_F3C80C7BE32FFC0D (role_crew_id), PRIMARY KEY(user_id, crew_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, app_role_id INT NOT NULL, user_name VARCHAR(64) NOT NULL, password VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, avatar VARCHAR(255) DEFAULT NULL, is_actif TINYINT(1) NOT NULL, presentation LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, INDEX IDX_8D93D6493B5EA2E1 (app_role_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE statistic (id INT AUTO_INCREMENT NOT NULL, quizz_id INT NOT NULL, user_id INT NOT NULL, created_at DATETIME NOT NULL, result INT NOT NULL, INDEX IDX_649B469CBA934BCD (quizz_id), INDEX IDX_649B469CA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE level (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(32) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role_crew (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(64) NOT NULL, slug VARCHAR(64) NOT NULL, code VARCHAR(32) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE app_role (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(64) NOT NULL, code VARCHAR(32) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE crew (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(128) NOT NULL, slug VARCHAR(128) NOT NULL, avatar VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quizz (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, subcategory_id INT DEFAULT NULL, author_id INT NOT NULL, crew_id INT DEFAULT NULL, title VARCHAR(128) NOT NULL, slug VARCHAR(128) NOT NULL, description LONGTEXT DEFAULT NULL, is_private TINYINT(1) DEFAULT NULL, INDEX IDX_7C77973D12469DE2 (category_id), INDEX IDX_7C77973D5DC6FE57 (subcategory_id), INDEX IDX_7C77973DF675F31B (author_id), INDEX IDX_7C77973D5FE259F6 (crew_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE subcategory (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, name VARCHAR(64) NOT NULL, INDEX IDX_DDCA44812469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494EBA934BCD FOREIGN KEY (quizz_id) REFERENCES quizz (id)');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494E5FB14BA7 FOREIGN KEY (level_id) REFERENCES level (id)');
        $this->addSql('ALTER TABLE is_like ADD CONSTRAINT FK_39906E92A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE is_like ADD CONSTRAINT FK_39906E92BA934BCD FOREIGN KEY (quizz_id) REFERENCES quizz (id)');
        $this->addSql('ALTER TABLE user_crew ADD CONSTRAINT FK_F3C80C7BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_crew ADD CONSTRAINT FK_F3C80C7B5FE259F6 FOREIGN KEY (crew_id) REFERENCES crew (id)');
        $this->addSql('ALTER TABLE user_crew ADD CONSTRAINT FK_F3C80C7BE32FFC0D FOREIGN KEY (role_crew_id) REFERENCES role_crew (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6493B5EA2E1 FOREIGN KEY (app_role_id) REFERENCES app_role (id)');
        $this->addSql('ALTER TABLE statistic ADD CONSTRAINT FK_649B469CBA934BCD FOREIGN KEY (quizz_id) REFERENCES quizz (id)');
        $this->addSql('ALTER TABLE statistic ADD CONSTRAINT FK_649B469CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE quizz ADD CONSTRAINT FK_7C77973D12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE quizz ADD CONSTRAINT FK_7C77973D5DC6FE57 FOREIGN KEY (subcategory_id) REFERENCES subcategory (id)');
        $this->addSql('ALTER TABLE quizz ADD CONSTRAINT FK_7C77973DF675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE quizz ADD CONSTRAINT FK_7C77973D5FE259F6 FOREIGN KEY (crew_id) REFERENCES crew (id)');
        $this->addSql('ALTER TABLE subcategory ADD CONSTRAINT FK_DDCA44812469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE quizz DROP FOREIGN KEY FK_7C77973D12469DE2');
        $this->addSql('ALTER TABLE subcategory DROP FOREIGN KEY FK_DDCA44812469DE2');
        $this->addSql('ALTER TABLE is_like DROP FOREIGN KEY FK_39906E92A76ED395');
        $this->addSql('ALTER TABLE user_crew DROP FOREIGN KEY FK_F3C80C7BA76ED395');
        $this->addSql('ALTER TABLE statistic DROP FOREIGN KEY FK_649B469CA76ED395');
        $this->addSql('ALTER TABLE quizz DROP FOREIGN KEY FK_7C77973DF675F31B');
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494E5FB14BA7');
        $this->addSql('ALTER TABLE user_crew DROP FOREIGN KEY FK_F3C80C7BE32FFC0D');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6493B5EA2E1');
        $this->addSql('ALTER TABLE user_crew DROP FOREIGN KEY FK_F3C80C7B5FE259F6');
        $this->addSql('ALTER TABLE quizz DROP FOREIGN KEY FK_7C77973D5FE259F6');
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494EBA934BCD');
        $this->addSql('ALTER TABLE is_like DROP FOREIGN KEY FK_39906E92BA934BCD');
        $this->addSql('ALTER TABLE statistic DROP FOREIGN KEY FK_649B469CBA934BCD');
        $this->addSql('ALTER TABLE quizz DROP FOREIGN KEY FK_7C77973D5DC6FE57');
        $this->addSql('DROP TABLE question');
        $this->addSql('DROP TABLE is_like');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE user_crew');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE statistic');
        $this->addSql('DROP TABLE level');
        $this->addSql('DROP TABLE role_crew');
        $this->addSql('DROP TABLE app_role');
        $this->addSql('DROP TABLE crew');
        $this->addSql('DROP TABLE quizz');
        $this->addSql('DROP TABLE subcategory');
    }
}
