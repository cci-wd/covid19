<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200326013828 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE ask_beneficiaire');
        $this->addSql('ALTER TABLE answer DROP FOREIGN KEY FK_DADD4A2542C1DC4D');
        $this->addSql('ALTER TABLE answer DROP FOREIGN KEY FK_DADD4A259D86650F');
        $this->addSql('DROP INDEX IDX_DADD4A2542C1DC4D ON answer');
        $this->addSql('DROP INDEX IDX_DADD4A259D86650F ON answer');
        $this->addSql('ALTER TABLE answer ADD ask_id INT NOT NULL, ADD user_id INT NOT NULL, DROP ask_id_id, DROP user_id_id');
        $this->addSql('ALTER TABLE answer ADD CONSTRAINT FK_DADD4A25B93F8B63 FOREIGN KEY (ask_id) REFERENCES ask (id)');
        $this->addSql('ALTER TABLE answer ADD CONSTRAINT FK_DADD4A25A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_DADD4A25B93F8B63 ON answer (ask_id)');
        $this->addSql('CREATE INDEX IDX_DADD4A25A76ED395 ON answer (user_id)');
        $this->addSql('ALTER TABLE ask DROP FOREIGN KEY FK_6826EAE03CCE3900');
        $this->addSql('ALTER TABLE ask DROP FOREIGN KEY FK_6826EAE09D86650F');
        $this->addSql('ALTER TABLE ask DROP FOREIGN KEY FK_6826EAE0EFD2C16A');
        $this->addSql('DROP INDEX IDX_6826EAE03CCE3900 ON ask');
        $this->addSql('DROP INDEX IDX_6826EAE0EFD2C16A ON ask');
        $this->addSql('DROP INDEX IDX_6826EAE09D86650F ON ask');
        $this->addSql('ALTER TABLE ask ADD city_id INT NOT NULL, ADD mission_id INT NOT NULL, ADD benificiaire_id INT NOT NULL, ADD user_id INT NOT NULL, DROP city_id_id, DROP mission_id_id, DROP user_id_id, CHANGE objectif objectif LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE ask ADD CONSTRAINT FK_6826EAE08BAC62AF FOREIGN KEY (city_id) REFERENCES city (id)');
        $this->addSql('ALTER TABLE ask ADD CONSTRAINT FK_6826EAE0BE6CAE90 FOREIGN KEY (mission_id) REFERENCES mission (id)');
        $this->addSql('ALTER TABLE ask ADD CONSTRAINT FK_6826EAE05FF252E9 FOREIGN KEY (benificiaire_id) REFERENCES beneficiaire (id)');
        $this->addSql('ALTER TABLE ask ADD CONSTRAINT FK_6826EAE0A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_6826EAE08BAC62AF ON ask (city_id)');
        $this->addSql('CREATE INDEX IDX_6826EAE0BE6CAE90 ON ask (mission_id)');
        $this->addSql('CREATE INDEX IDX_6826EAE05FF252E9 ON ask (benificiaire_id)');
        $this->addSql('CREATE INDEX IDX_6826EAE0A76ED395 ON ask (user_id)');
        $this->addSql('ALTER TABLE beneficiaire CHANGE content content LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6498BAC62AF');
        $this->addSql('DROP INDEX IDX_8D93D6498BAC62AF ON user');
        $this->addSql('ALTER TABLE user DROP city_id, CHANGE address address VARCHAR(255) DEFAULT NULL, CHANGE tel tel VARCHAR(255) DEFAULT NULL, CHANGE roles roles JSON NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE ask_beneficiaire (ask_id INT NOT NULL, beneficiaire_id INT NOT NULL, INDEX IDX_4B39AF7BB93F8B63 (ask_id), INDEX IDX_4B39AF7B5AF81F68 (beneficiaire_id), PRIMARY KEY(ask_id, beneficiaire_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE ask_beneficiaire ADD CONSTRAINT FK_4B39AF7B5AF81F68 FOREIGN KEY (beneficiaire_id) REFERENCES beneficiaire (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ask_beneficiaire ADD CONSTRAINT FK_4B39AF7BB93F8B63 FOREIGN KEY (ask_id) REFERENCES ask (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE answer DROP FOREIGN KEY FK_DADD4A25B93F8B63');
        $this->addSql('ALTER TABLE answer DROP FOREIGN KEY FK_DADD4A25A76ED395');
        $this->addSql('DROP INDEX IDX_DADD4A25B93F8B63 ON answer');
        $this->addSql('DROP INDEX IDX_DADD4A25A76ED395 ON answer');
        $this->addSql('ALTER TABLE answer ADD ask_id_id INT NOT NULL, ADD user_id_id INT NOT NULL, DROP ask_id, DROP user_id');
        $this->addSql('ALTER TABLE answer ADD CONSTRAINT FK_DADD4A2542C1DC4D FOREIGN KEY (ask_id_id) REFERENCES ask (id)');
        $this->addSql('ALTER TABLE answer ADD CONSTRAINT FK_DADD4A259D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_DADD4A2542C1DC4D ON answer (ask_id_id)');
        $this->addSql('CREATE INDEX IDX_DADD4A259D86650F ON answer (user_id_id)');
        $this->addSql('ALTER TABLE ask DROP FOREIGN KEY FK_6826EAE08BAC62AF');
        $this->addSql('ALTER TABLE ask DROP FOREIGN KEY FK_6826EAE0BE6CAE90');
        $this->addSql('ALTER TABLE ask DROP FOREIGN KEY FK_6826EAE05FF252E9');
        $this->addSql('ALTER TABLE ask DROP FOREIGN KEY FK_6826EAE0A76ED395');
        $this->addSql('DROP INDEX IDX_6826EAE08BAC62AF ON ask');
        $this->addSql('DROP INDEX IDX_6826EAE0BE6CAE90 ON ask');
        $this->addSql('DROP INDEX IDX_6826EAE05FF252E9 ON ask');
        $this->addSql('DROP INDEX IDX_6826EAE0A76ED395 ON ask');
        $this->addSql('ALTER TABLE ask ADD city_id_id INT NOT NULL, ADD mission_id_id INT NOT NULL, ADD user_id_id INT NOT NULL, DROP city_id, DROP mission_id, DROP benificiaire_id, DROP user_id, CHANGE objectif objectif VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE ask ADD CONSTRAINT FK_6826EAE03CCE3900 FOREIGN KEY (city_id_id) REFERENCES city (id)');
        $this->addSql('ALTER TABLE ask ADD CONSTRAINT FK_6826EAE09D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE ask ADD CONSTRAINT FK_6826EAE0EFD2C16A FOREIGN KEY (mission_id_id) REFERENCES mission (id)');
        $this->addSql('CREATE INDEX IDX_6826EAE03CCE3900 ON ask (city_id_id)');
        $this->addSql('CREATE INDEX IDX_6826EAE0EFD2C16A ON ask (mission_id_id)');
        $this->addSql('CREATE INDEX IDX_6826EAE09D86650F ON ask (user_id_id)');
        $this->addSql('ALTER TABLE beneficiaire CHANGE content content VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE user ADD city_id INT NOT NULL, CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`, CHANGE address address VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE tel tel VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6498BAC62AF FOREIGN KEY (city_id) REFERENCES city (id)');
        $this->addSql('CREATE INDEX IDX_8D93D6498BAC62AF ON user (city_id)');
    }
}
