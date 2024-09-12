<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240911120525 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commentaire (id INT AUTO_INCREMENT NOT NULL, ressource_id INT DEFAULT NULL, utilisateur_id INT NOT NULL, contenu VARCHAR(500) NOT NULL, date_commentaire DATETIME NOT NULL, INDEX IDX_67F068BCFC6CD52A (ressource_id), INDEX IDX_67F068BCFB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE etat_ressource (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message_utilisateur (id INT AUTO_INCREMENT NOT NULL, utilisateur1_id INT NOT NULL, utilisateur2_id INT DEFAULT NULL, contenu VARCHAR(500) NOT NULL, date_heure_envoi DATETIME NOT NULL, INDEX IDX_7D633D4A30F4F973 (utilisateur1_id), INDEX IDX_7D633D4A2241569D (utilisateur2_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE relation_utilisateur (id INT AUTO_INCREMENT NOT NULL, id_type_relation_id INT NOT NULL, id_utilisateur_1_id INT NOT NULL, id_utilisateur_2_id INT NOT NULL, est_accepte TINYINT(1) NOT NULL, INDEX IDX_799DDBA99AC5131B (id_type_relation_id), INDEX IDX_799DDBA9DAD86511 (id_utilisateur_1_id), INDEX IDX_799DDBA9C86DCAFF (id_utilisateur_2_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reponse (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT DEFAULT NULL, commentaire_id INT NOT NULL, contenu VARCHAR(500) NOT NULL, date_reponse DATETIME NOT NULL, INDEX IDX_5FB6DEC7FB88E14F (utilisateur_id), INDEX IDX_5FB6DEC7BA9CD190 (commentaire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ressource (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT NOT NULL, categorie_id INT NOT NULL, etat_ressource_id INT NOT NULL, type_ressource_id INT NOT NULL, titre VARCHAR(500) NOT NULL, description VARCHAR(9999) NOT NULL, date_publication DATE NOT NULL, nb_consultation INT NOT NULL, nb_recherche INT NOT NULL, nb_partage INT NOT NULL, INDEX IDX_939F4544FB88E14F (utilisateur_id), INDEX IDX_939F4544BCF5E72D (categorie_id), INDEX IDX_939F4544E4B6E6F5 (etat_ressource_id), INDEX IDX_939F45447B2F6F2F (type_ressource_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE _ressource_type_relation (ressource_id INT NOT NULL, type_relation_id INT NOT NULL, INDEX IDX_CDEC90D4FC6CD52A (ressource_id), INDEX IDX_CDEC90D4794F46CA (type_relation_id), PRIMARY KEY(ressource_id, type_relation_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_relation (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, commentaire VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_ressource (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, api_token VARCHAR(255) DEFAULT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, departement VARCHAR(255) NOT NULL, est_active TINYINT(1) NOT NULL, date_creation DATE NOT NULL, date_desactivation DATE DEFAULT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCFC6CD52A FOREIGN KEY (ressource_id) REFERENCES ressource (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE message_utilisateur ADD CONSTRAINT FK_7D633D4A30F4F973 FOREIGN KEY (utilisateur1_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE message_utilisateur ADD CONSTRAINT FK_7D633D4A2241569D FOREIGN KEY (utilisateur2_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE relation_utilisateur ADD CONSTRAINT FK_799DDBA99AC5131B FOREIGN KEY (id_type_relation_id) REFERENCES type_relation (id)');
        $this->addSql('ALTER TABLE relation_utilisateur ADD CONSTRAINT FK_799DDBA9DAD86511 FOREIGN KEY (id_utilisateur_1_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE relation_utilisateur ADD CONSTRAINT FK_799DDBA9C86DCAFF FOREIGN KEY (id_utilisateur_2_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT FK_5FB6DEC7FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT FK_5FB6DEC7BA9CD190 FOREIGN KEY (commentaire_id) REFERENCES commentaire (id)');
        $this->addSql('ALTER TABLE ressource ADD CONSTRAINT FK_939F4544FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE ressource ADD CONSTRAINT FK_939F4544BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE ressource ADD CONSTRAINT FK_939F4544E4B6E6F5 FOREIGN KEY (etat_ressource_id) REFERENCES etat_ressource (id)');
        $this->addSql('ALTER TABLE ressource ADD CONSTRAINT FK_939F45447B2F6F2F FOREIGN KEY (type_ressource_id) REFERENCES type_ressource (id)');
        $this->addSql('ALTER TABLE _ressource_type_relation ADD CONSTRAINT FK_CDEC90D4FC6CD52A FOREIGN KEY (ressource_id) REFERENCES ressource (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE _ressource_type_relation ADD CONSTRAINT FK_CDEC90D4794F46CA FOREIGN KEY (type_relation_id) REFERENCES type_relation (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BCFC6CD52A');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BCFB88E14F');
        $this->addSql('ALTER TABLE message_utilisateur DROP FOREIGN KEY FK_7D633D4A30F4F973');
        $this->addSql('ALTER TABLE message_utilisateur DROP FOREIGN KEY FK_7D633D4A2241569D');
        $this->addSql('ALTER TABLE relation_utilisateur DROP FOREIGN KEY FK_799DDBA99AC5131B');
        $this->addSql('ALTER TABLE relation_utilisateur DROP FOREIGN KEY FK_799DDBA9DAD86511');
        $this->addSql('ALTER TABLE relation_utilisateur DROP FOREIGN KEY FK_799DDBA9C86DCAFF');
        $this->addSql('ALTER TABLE reponse DROP FOREIGN KEY FK_5FB6DEC7FB88E14F');
        $this->addSql('ALTER TABLE reponse DROP FOREIGN KEY FK_5FB6DEC7BA9CD190');
        $this->addSql('ALTER TABLE ressource DROP FOREIGN KEY FK_939F4544FB88E14F');
        $this->addSql('ALTER TABLE ressource DROP FOREIGN KEY FK_939F4544BCF5E72D');
        $this->addSql('ALTER TABLE ressource DROP FOREIGN KEY FK_939F4544E4B6E6F5');
        $this->addSql('ALTER TABLE ressource DROP FOREIGN KEY FK_939F45447B2F6F2F');
        $this->addSql('ALTER TABLE _ressource_type_relation DROP FOREIGN KEY FK_CDEC90D4FC6CD52A');
        $this->addSql('ALTER TABLE _ressource_type_relation DROP FOREIGN KEY FK_CDEC90D4794F46CA');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('DROP TABLE etat_ressource');
        $this->addSql('DROP TABLE message_utilisateur');
        $this->addSql('DROP TABLE relation_utilisateur');
        $this->addSql('DROP TABLE reponse');
        $this->addSql('DROP TABLE ressource');
        $this->addSql('DROP TABLE _ressource_type_relation');
        $this->addSql('DROP TABLE type_relation');
        $this->addSql('DROP TABLE type_ressource');
        $this->addSql('DROP TABLE user');
    }
}
