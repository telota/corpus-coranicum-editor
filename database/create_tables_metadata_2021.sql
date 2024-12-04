CREATE TABLE cc_authors
(
  id                 INT PRIMARY KEY AUTO_INCREMENT NOT NULL UNIQUE,
  author_name        VARCHAR(255)                   NOT NULL UNIQUE,
  author_description TEXT                                    DEFAULT NULL,
  created_at         TIMESTAMP                      NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at         TIMESTAMP                               DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP

)
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

ALTER TABLE cc_authors
  COMMENT = 'It represents all authors in the Corpus
Coranicum project including colleagues and extern.';

INSERT INTO cc_authors (author_name)
VALUES ('Michael Marx');
INSERT INTO cc_authors (author_name)
VALUES ('Nestor Kavvadas');
INSERT INTO cc_authors (author_name)
VALUES ('Dirk Hartwig');
INSERT INTO cc_authors (author_name)
VALUES ('Johanna Schubert');
INSERT INTO cc_authors (author_name)
VALUES ('Farah C. Artika');
INSERT INTO cc_authors (author_name)
VALUES ('Manssur Karamzadeh');
INSERT INTO cc_authors (author_name)
VALUES ('Yunus C. Öç');
INSERT INTO cc_authors (author_name)
VALUES ('Tobias J. Jocham');
INSERT INTO cc_authors (author_name)
VALUES ('Salome Beridze');
INSERT INTO cc_authors (author_name)
VALUES ('Charlotte Bohm');
INSERT INTO cc_authors (author_name)
VALUES ('Sabrina Cimiotti');
INSERT INTO cc_authors (author_name)
VALUES ('Hadiya Gurtmann');
INSERT INTO cc_authors (author_name)
VALUES ('Laura Hinrichsen');
INSERT INTO cc_authors (author_name)
VALUES ('Tolou Khademalsharieh');
INSERT INTO cc_authors (author_name)
VALUES ('Nora Reifenstein');
INSERT INTO cc_authors (author_name)
VALUES ('Jens Sauer');
INSERT INTO cc_authors (author_name)
VALUES ('Sophie Schmid');
INSERT INTO cc_authors (author_name)
VALUES ('Annemarie Jehring');
INSERT INTO cc_authors (author_name)
VALUES ('Ali Aghaei');
INSERT INTO cc_authors (author_name)
VALUES ('Marcus Fraser');
INSERT INTO cc_authors (author_name)
VALUES ('Elahe Shahpasand');
INSERT INTO cc_authors (author_name)
VALUES ('Raheleh Shahpasand');
INSERT INTO cc_authors (author_name)
VALUES ('Azam Shahpasand');
INSERT INTO cc_authors (author_name)
VALUES ('Zahra Mollaei');
INSERT INTO cc_authors (author_name)
VALUES ('Mojgan Azimian');
INSERT INTO cc_authors (author_name)
VALUES ('Fatemeh Nayeree');
INSERT INTO cc_authors (author_name)
VALUES ('Veronika Roth');
INSERT INTO cc_authors (author_name)
VALUES ('Jerome Okensky');
INSERT INTO cc_authors (author_name)
VALUES ('Mohammed Maraqten');
INSERT INTO cc_authors (author_name)
VALUES ('David Kiltz');
INSERT INTO cc_authors (author_name)
VALUES ('Yousef Kouriyhe');
INSERT INTO cc_authors (author_name)
VALUES ('Nicolai Sinai');
INSERT INTO cc_authors (author_name)
VALUES ('Vasiliki Chamourgiotaki');
INSERT INTO cc_authors (author_name)
VALUES ('Antonia Kura');


CREATE TABLE cc_modules
(
  id                 INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
  module_name        VARCHAR(100)                   NOT NULL UNIQUE,
  module_description TEXT                                    DEFAULT NULL,
  created_at         TIMESTAMP                      NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at         TIMESTAMP                               DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP

)
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

ALTER TABLE cc_modules
  COMMENT = 'It represents and describes all modules in the Corpus
Coranicum project.';

INSERT INTO cc_modules (module_name)
VALUES ('manuscript');
INSERT INTO cc_modules (module_name)
VALUES ('intertext');

CREATE TABLE cc_roles
(
  id               INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
  role_name        VARCHAR(100)                   NOT NULL,
  module_id        INT                            NOT NULL,
  role_description TEXT                                    DEFAULT NULL,
  created_at       TIMESTAMP                      NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at       TIMESTAMP                               DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  UNIQUE unique_index (role_name, module_id),

  FOREIGN KEY (module_id)
  REFERENCES cc_modules (id)

)
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

ALTER TABLE cc_roles
  COMMENT = 'It represents and describes the roles of authors in the project.';

INSERT INTO cc_roles (role_name, module_id, role_description)
VALUES ('metadata', 1, 'It represents the colleagues who determine the metadata of manuscripts.');
INSERT INTO cc_roles (role_name, module_id, role_description)
VALUES ('metadata', 2, 'It represents the authors of metadata intertexts.');
INSERT INTO cc_roles (role_name, module_id, role_description)
VALUES ('transliteration', 1,
        'It represents the colleagues who transliterate manuscript pages into the standard Kairo Quran.');
INSERT INTO cc_roles (role_name, module_id, role_description)
VALUES ('image', 1, 'It represents the colleagues who edit manuscript page images.');
INSERT INTO cc_roles (role_name, module_id, role_description)
VALUES ('assistance', 1, 'It represents colleagues who assist during the study of manuscripts.');
INSERT INTO cc_roles (role_name, module_id, role_description)
VALUES ('information', 2, 'It represents the authors of any information texts in intertext module.');
INSERT INTO cc_roles (role_name, module_id, role_description)
VALUES ('translation', 2, 'It represents the translators of any texts in intertext module.');
INSERT INTO cc_roles (role_name, module_id, role_description)
VALUES ('translation', 1, 'It represents the translators of any texts in manuscript module.');
INSERT INTO cc_roles (role_name, module_id, role_description)
VALUES ('collaboration', 2, 'It represents the collaborators of any texts in intertext module.');
INSERT INTO cc_roles (role_name, module_id, role_description)
VALUES ('update', 2, 'It represents the updaters of any texts in intertext module.');
INSERT INTO cc_roles (role_name, module_id, role_description)
VALUES ('text_editing', 2, 'It represents the text editing of any texts in intertext module.');

CREATE TABLE cc_author_roles
(
  id         INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
  author_id  INT                            NOT NULL,
  role_id    INT                            NOT NULL,
  created_at TIMESTAMP                      NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP                               DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  UNIQUE unique_index (author_id, role_id),

  FOREIGN KEY (author_id)
  REFERENCES cc_authors (id),
  FOREIGN KEY (role_id)
  REFERENCES cc_roles (id)

)
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

ALTER TABLE cc_author_roles
  COMMENT = 'It represents the role of a certain author.';

# manuscript - assistances
INSERT INTO cc_author_roles (author_id, role_id)
VALUES (5, 5);
INSERT INTO cc_author_roles (author_id, role_id)
VALUES (6, 5);
INSERT INTO cc_author_roles (author_id, role_id)
VALUES (7, 5);
INSERT INTO cc_author_roles (author_id, role_id)
VALUES (8, 5);
INSERT INTO cc_author_roles (author_id, role_id)
VALUES (9, 5);
INSERT INTO cc_author_roles (author_id, role_id)
VALUES (10, 5);
INSERT INTO cc_author_roles (author_id, role_id)
VALUES (11, 5);
INSERT INTO cc_author_roles (author_id, role_id)
VALUES (12, 5);
INSERT INTO cc_author_roles (author_id, role_id)
VALUES (13, 5);
INSERT INTO cc_author_roles (author_id, role_id)
VALUES (14, 5);
INSERT INTO cc_author_roles (author_id, role_id)
VALUES (15, 5);
INSERT INTO cc_author_roles (author_id, role_id)
VALUES (16, 5);
INSERT INTO cc_author_roles (author_id, role_id)
VALUES (17, 5);
INSERT INTO cc_author_roles (author_id, role_id)
VALUES (18, 5);

# manuscript - metadata
INSERT INTO cc_author_roles (author_id, role_id)
VALUES (1, 1);
INSERT INTO cc_author_roles (author_id, role_id)
VALUES (19, 1);
INSERT INTO cc_author_roles (author_id, role_id)
VALUES (8, 1);
INSERT INTO cc_author_roles (author_id, role_id)
VALUES (20, 1);
INSERT INTO cc_author_roles (author_id, role_id)
VALUES (9, 1);

# manuscript - image
INSERT INTO cc_author_roles (author_id, role_id)
VALUES (5, 4);
INSERT INTO cc_author_roles (author_id, role_id)
VALUES (8, 4);
INSERT INTO cc_author_roles (author_id, role_id)
VALUES (18, 4);
INSERT INTO cc_author_roles (author_id, role_id)
VALUES (12, 4);

# manuscript - transliteration
INSERT INTO cc_author_roles (author_id, role_id)
VALUES (21, 3);
INSERT INTO cc_author_roles (author_id, role_id)
VALUES (22, 3);
INSERT INTO cc_author_roles (author_id, role_id)
VALUES (23, 3);
INSERT INTO cc_author_roles (author_id, role_id)
VALUES (24, 3);
INSERT INTO cc_author_roles (author_id, role_id)
VALUES (25, 3);
INSERT INTO cc_author_roles (author_id, role_id)
VALUES (26, 3);
INSERT INTO cc_author_roles (author_id, role_id)
VALUES (9, 3);
INSERT INTO cc_author_roles (author_id, role_id)
VALUES (10, 3);
INSERT INTO cc_author_roles (author_id, role_id)
VALUES (11, 3);
INSERT INTO cc_author_roles (author_id, role_id)
VALUES (12, 3);
INSERT INTO cc_author_roles (author_id, role_id)
VALUES (13, 3);
INSERT INTO cc_author_roles (author_id, role_id)
VALUES (8, 3);
INSERT INTO cc_author_roles (author_id, role_id)
VALUES (14, 3);
INSERT INTO cc_author_roles (author_id, role_id)
VALUES (15, 3);
INSERT INTO cc_author_roles (author_id, role_id)
VALUES (16, 3);
INSERT INTO cc_author_roles (author_id, role_id)
VALUES (17, 3);
INSERT INTO cc_author_roles (author_id, role_id)
VALUES (18, 3);

# manuscript - translation
INSERT INTO cc_author_roles (author_id, role_id)
VALUES (1, 8);

# intertext - metadata
INSERT INTO cc_author_roles (author_id, role_id)
VALUES (1, 2);
INSERT INTO cc_author_roles (author_id, role_id)
VALUES (2, 2);
INSERT INTO cc_author_roles (author_id, role_id)
VALUES (3, 2);
INSERT INTO cc_author_roles (author_id, role_id)
VALUES (4, 2);
INSERT INTO cc_author_roles (author_id, role_id)
VALUES (29, 2);
INSERT INTO cc_author_roles (author_id, role_id)
VALUES (30, 2);
INSERT INTO cc_author_roles (author_id, role_id)
VALUES (31, 2);
INSERT INTO cc_author_roles (author_id, role_id)
VALUES (32, 2);
INSERT INTO cc_author_roles (author_id, role_id)
VALUES (27, 2);

# intertext - information
INSERT INTO cc_author_roles (author_id, role_id)
VALUES (1, 6);

# intertext - translation
INSERT INTO cc_author_roles (author_id, role_id)
VALUES (1, 7);

# intertext - collaboration
INSERT INTO cc_author_roles (author_id, role_id)
VALUES (9, 9);
INSERT INTO cc_author_roles (author_id, role_id)
VALUES (27, 9);
INSERT INTO cc_author_roles (author_id, role_id)
VALUES (14, 9);
INSERT INTO cc_author_roles (author_id, role_id)
VALUES (4, 9);
INSERT INTO cc_author_roles (author_id, role_id)
VALUES (28, 9);

# intertext - update
INSERT INTO cc_author_roles (author_id, role_id)
VALUES (33, 10);

# intertext - text editing
INSERT INTO cc_author_roles (author_id, role_id)
VALUES (4, 11);
INSERT INTO cc_author_roles (author_id, role_id)
VALUES (34, 11);

CREATE TABLE cc_translation_languages
(
  id                   INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
  translation_language VARCHAR(255)                   NOT NULL UNIQUE,
  created_at           TIMESTAMP                      NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at           TIMESTAMP                               DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP

)
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

ALTER TABLE cc_translation_languages
  COMMENT = 'It represents the languages of translation texts.';

INSERT INTO cc_translation_languages (translation_language)
VALUES ('german');
INSERT INTO cc_translation_languages (translation_language)
VALUES ('english');
INSERT INTO cc_translation_languages (translation_language)
VALUES ('french');
INSERT INTO cc_translation_languages (translation_language)
VALUES ('arabic');
INSERT INTO cc_translation_languages (translation_language)
VALUES ('latin');
INSERT INTO cc_translation_languages (translation_language)
VALUES ('russian');
INSERT INTO cc_translation_languages (translation_language)
VALUES ('dutch');
INSERT INTO cc_translation_languages (translation_language)
VALUES ('spanish');
INSERT INTO cc_translation_languages (translation_language)
VALUES ('italian');
INSERT INTO cc_translation_languages (translation_language)
VALUES ('persian');
INSERT INTO cc_translation_languages (translation_language)
VALUES ('hebrew');
INSERT INTO cc_translation_languages (translation_language)
VALUES ('turkish');
INSERT INTO cc_translation_languages (translation_language)
VALUES ('bahasa');

# MANUSCRIPTS


CREATE TABLE ms_places # aufbewahrungsorte
(
  id                  INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
  place               VARCHAR(255)                            DEFAULT NULL,
  place_name          VARCHAR(255)                            DEFAULT NULL UNIQUE,
  country_code        CHAR(2)                                 DEFAULT NULL,
  description         TEXT(65535)                             DEFAULT NULL,
  link                TEXT(1000)                              DEFAULT NULL,
  image_link          TEXT(1000)                              DEFAULT NULL,
  image_original_link TEXT(1000)                              DEFAULT NULL,
  image_description   TEXT(65535)                             DEFAULT NULL,
  longitude           DECIMAL(10, 7)                          DEFAULT NULL,
  latitude            DECIMAL(10, 7)                          DEFAULT NULL,
  geonames            VARCHAR(255)                            DEFAULT NULL,
  created_at          TIMESTAMP                      NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at          TIMESTAMP                               DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  UNIQUE unique_index (place_name, longitude, latitude, geonames)

)
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

ALTER TABLE ms_places
  COMMENT = 'old table: aufbewahrungstorte. It represents the location where the manuscripts are stored.';

CREATE TABLE ms_script_styles
(
  id         INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
  style      VARCHAR(255)                            DEFAULT NULL UNIQUE,
  created_at TIMESTAMP                      NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP                               DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;


ALTER TABLE ms_script_styles
  COMMENT = 'It represents the script styles of manuscripts, according to Deroche.';


CREATE TABLE ms_original_codexes # sister leaves
(
  id                  INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
  original_codex_name VARCHAR(500)                            DEFAULT NULL UNIQUE,
  supercategory       INT                                     DEFAULT NULL,
  script_style_id     INT                                     DEFAULT NULL,
  created_at          TIMESTAMP                      NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at          TIMESTAMP                               DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  UNIQUE unique_index (supercategory, original_codex_name),

  FOREIGN KEY (supercategory)
  REFERENCES ms_original_codexes (id),
  FOREIGN KEY (script_style_id)
  REFERENCES ms_script_styles (id)
)
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

ALTER TABLE ms_original_codexes
  COMMENT = 'It represents the category of manuscripts.';


CREATE TABLE ms_provenances
(
  id         INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
  provenance VARCHAR(255)                            DEFAULT NULL UNIQUE,
  created_at TIMESTAMP                      NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP                               DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

ALTER TABLE ms_provenances
  COMMENT = 'It represents the place of origin of manuscripts.';


CREATE TABLE ms_manuscript
(
  id                  INT PRIMARY KEY    AUTO_INCREMENT,
  call_number         VARCHAR(255)       DEFAULT NULL,
  place_id            INT                DEFAULT NULL,
  is_online           TINYINT            DEFAULT 0,
  dimensions          VARCHAR(255)       DEFAULT NULL,
  format_text_field   VARCHAR(255)       DEFAULT NULL,
  number_of_lines     VARCHAR(255)       DEFAULT NULL,
  number_of_folios    INT                DEFAULT NULL,
  carbon_dating       VARCHAR(255)       DEFAULT NULL,
  date_start          DATE               DEFAULT NULL,
  date_end            DATE               DEFAULT NULL,
  writing_surface     VARCHAR(255)       DEFAULT NULL,
  original_codex_id   INT                DEFAULT NULL,
  palimpsest          VARCHAR(255)       DEFAULT NULL,
  palimpsest_text     TEXT(65535)        DEFAULT NULL,
  sajda_signs         VARCHAR(255)       DEFAULT NULL,
  sajda_signs_text    TEXT(65535)        DEFAULT NULL,
  colophon            VARCHAR(255)       DEFAULT NULL,
  colophon_text       TEXT(65535)        DEFAULT NULL,
  colophon_date_start DATE               DEFAULT NULL,
  colophon_date_end   DATE               DEFAULT NULL,
  doi                 VARCHAR(255)       DEFAULT NULL,
  credit_line_image   TEXT(65535)        DEFAULT NULL,
  codicology          TEXT(65535)        DEFAULT NULL,
  paleography         TEXT(65535)        DEFAULT NULL,
  commentary_internal TEXT(65535)        DEFAULT NULL,
  ornaments           TEXT(65535)        DEFAULT NULL,
  catalogue_entry     TEXT(65535)        DEFAULT NULL,
  transliteration     TEXT(65535)        DEFAULT NULL,
  created_at          TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at          TIMESTAMP          DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  UNIQUE unique_index (call_number, place_id),

  INDEX (is_online),

  FOREIGN KEY (place_id)
  REFERENCES ms_places (id),
  FOREIGN KEY (original_codex_id)
  REFERENCES ms_original_codexes (id)
)
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

ALTER TABLE ms_manuscript
  COMMENT = 'Old table: manuskript. It represents manuscript metadata.';


CREATE TABLE ms_manuscript_colophon_text_translations
(
  id                                  INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
  language_id                         INT                            NOT NULL,
  manuscript_id                       INT                            NOT NULL,
  translator_id                       INT                            NOT NULL,
  colophon_text_translation_reference TEXT(65535)                             DEFAULT NULL,
  colophon_text_translation           TEXT(65535)                             DEFAULT NULL,
  created_at                          TIMESTAMP                      NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at                          TIMESTAMP                               DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  UNIQUE unique_index (language_id, manuscript_id, translator_id),

  FOREIGN KEY (language_id)
  REFERENCES cc_translation_languages (id),
  FOREIGN KEY (manuscript_id)
  REFERENCES ms_manuscript (id)
    ON DELETE CASCADE,
  FOREIGN KEY (translator_id)
  REFERENCES cc_authors (id)

)
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

ALTER TABLE ms_manuscript_colophon_text_translations
  COMMENT = 'It represents the translation of a colophon text.';


CREATE TABLE ms_manuscript_sajda_signs_text_translations
(
  id                                     INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
  language_id                            INT                            NOT NULL,
  manuscript_id                          INT                            NOT NULL,
  translator_id                          INT                            NOT NULL,
  sajda_signs_text_translation_reference TEXT(65535)                             DEFAULT NULL,
  sajda_signs_text_translation           TEXT(65535)                             DEFAULT NULL,
  created_at                             TIMESTAMP                      NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at                             TIMESTAMP                               DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  UNIQUE unique_index (language_id, manuscript_id, translator_id),

  FOREIGN KEY (language_id)
  REFERENCES cc_translation_languages (id),
  FOREIGN KEY (manuscript_id)
  REFERENCES ms_manuscript (id)
    ON DELETE CASCADE,
  FOREIGN KEY (translator_id)
  REFERENCES cc_authors (id)

)
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

ALTER TABLE ms_manuscript_sajda_signs_text_translations
  COMMENT = 'It represents the translation of a sajda signs text.';


CREATE TABLE ms_manuscript_palimpsest_text_translations
(
  id                                    INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
  language_id                           INT                            NOT NULL,
  manuscript_id                         INT                            NOT NULL,
  translator_id                         INT                            NOT NULL,
  palimpsest_text_translation_reference TEXT(65535)                             DEFAULT NULL,
  palimpsest_text_translation           TEXT(65535)                             DEFAULT NULL,
  created_at                            TIMESTAMP                      NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at                            TIMESTAMP                               DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  UNIQUE unique_index (language_id, manuscript_id, translator_id),

  FOREIGN KEY (language_id)
  REFERENCES cc_translation_languages (id),
  FOREIGN KEY (manuscript_id)
  REFERENCES ms_manuscript (id)
    ON DELETE CASCADE,
  FOREIGN KEY (translator_id)
  REFERENCES cc_authors (id)

)
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

ALTER TABLE ms_manuscript_palimpsest_text_translations
  COMMENT = 'It represents the translation of a palimpsest text.';


CREATE TABLE ms_manuscript_provenances
(
  id            INT PRIMARY KEY    AUTO_INCREMENT,
  manuscript_id INT       NOT NULL,
  provenance_id INT       NOT NULL,
  created_at    TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at    TIMESTAMP          DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  UNIQUE unique_index (manuscript_id, provenance_id),

  FOREIGN KEY (manuscript_id)
  REFERENCES ms_manuscript (id)
    ON DELETE CASCADE,
  FOREIGN KEY (provenance_id)
  REFERENCES ms_provenances (id)
    ON DELETE CASCADE
)
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

ALTER TABLE ms_manuscript_provenances
  COMMENT = 'It represents the provenances of a certain manuscript.';


CREATE TABLE ms_manuscript_rwt_provenances
(
  id            INT PRIMARY KEY    AUTO_INCREMENT,
  manuscript_id INT       NOT NULL,
  provenance_id INT       NOT NULL,
  created_at    TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at    TIMESTAMP          DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  UNIQUE unique_index (manuscript_id, provenance_id),

  FOREIGN KEY (manuscript_id)
  REFERENCES ms_manuscript (id)
    ON DELETE CASCADE,
  FOREIGN KEY (provenance_id)
  REFERENCES ms_provenances (id)
    ON DELETE CASCADE
)
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

ALTER TABLE ms_manuscript_rwt_provenances
  COMMENT = 'It represents the regional writing tradition provenances of a certain manuscript.';


CREATE TABLE ms_manuscript_mapping #manuskript_mapping
(
  id            INT PRIMARY KEY    AUTO_INCREMENT,
  manuscript_id INT                DEFAULT NULL,
  sure_start    DECIMAL(3, 0)      DEFAULT NULL,
  vers_start    DECIMAL(3, 0)      DEFAULT NULL,
  word_start    DECIMAL(3, 0)      DEFAULT NULL,
  sure_end      DECIMAL(3, 0)      DEFAULT NULL,
  vers_end      DECIMAL(3, 0)      DEFAULT NULL,
  word_end      DECIMAL(3, 0)      DEFAULT NULL,
  created_at    TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at    TIMESTAMP          DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  #     UNIQUE unique_index (manuscript_id, sure_start, vers_start, word_start, sure_end, vers_end, word_end), # too many duplicates in the old table manuskript_mapping to copy

  INDEX mapping_index (sure_start ASC, vers_start ASC, word_start ASC, sure_end ASC, vers_end ASC, word_end ASC),

  INDEX (manuscript_id),
  FOREIGN KEY (manuscript_id)
  REFERENCES ms_manuscript (id)
    ON DELETE CASCADE

)
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

ALTER TABLE ms_manuscript_mapping
  COMMENT = 'Old table: manuskript_mapping. It represents mapping table for manuscript, in contrast to ms_manuscript_pages_mapping the datasets are summarized.';


CREATE TABLE ms_funders
(
  id         INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
  funder     VARCHAR(255)                            DEFAULT NULL UNIQUE,
  created_at TIMESTAMP                      NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP                               DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

ALTER TABLE ms_funders
  COMMENT = 'It represents the funders of the manuscript project.';


CREATE TABLE ms_manuscript_funders
(
  id            INT PRIMARY KEY    AUTO_INCREMENT,
  manuscript_id INT       NOT NULL,
  funder_id     INT       NOT NULL,
  created_at    TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at    TIMESTAMP          DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  UNIQUE unique_index (manuscript_id, funder_id),

  FOREIGN KEY (manuscript_id)
  REFERENCES ms_manuscript (id)
    ON DELETE CASCADE,
  FOREIGN KEY (funder_id)
  REFERENCES ms_funders (id)
    ON DELETE CASCADE
)
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

ALTER TABLE ms_manuscript_funders
  COMMENT = 'It represents the funders of a certain manuscript.';


CREATE TABLE ms_reading_signs
(
  id           INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
  reading_sign VARCHAR(255)                            DEFAULT NULL UNIQUE,
  created_at   TIMESTAMP                      NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at   TIMESTAMP                               DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

ALTER TABLE ms_reading_signs
  COMMENT = 'It represents the reading signs or vowel signs a manuscript can have.';


CREATE TABLE ms_manuscript_reading_signs
(
  id              INT PRIMARY KEY    AUTO_INCREMENT,
  manuscript_id   INT       NOT NULL,
  reading_sign_id INT       NOT NULL,
  created_at      TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at      TIMESTAMP          DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  UNIQUE unique_index (manuscript_id, reading_sign_id),

  FOREIGN KEY (manuscript_id)
  REFERENCES ms_manuscript (id)
    ON DELETE CASCADE,
  FOREIGN KEY (reading_sign_id)
  REFERENCES ms_reading_signs (id)
    ON DELETE CASCADE
)
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

ALTER TABLE ms_reading_signs
  COMMENT = 'It represents the reading signs or vowel signs of a certain manuscript.';


CREATE TABLE ms_attributed_to
(
  id         INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
  person     VARCHAR(255)                            DEFAULT NULL UNIQUE,
  created_at TIMESTAMP                      NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP                               DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

ALTER TABLE ms_attributed_to
  COMMENT = 'It represents the people whom manuscripts attributed.';


CREATE TABLE ms_manuscript_attributed_to
(
  id               INT PRIMARY KEY    AUTO_INCREMENT,
  manuscript_id    INT       NOT NULL,
  attributed_to_id INT       NOT NULL,
  created_at       TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at       TIMESTAMP          DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  UNIQUE unique_index (manuscript_id, attributed_to_id),

  FOREIGN KEY (manuscript_id)
  REFERENCES ms_manuscript (id)
    ON DELETE CASCADE,
  FOREIGN KEY (attributed_to_id)
  REFERENCES ms_attributed_to (id)
    ON DELETE CASCADE
)
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

ALTER TABLE ms_manuscript_attributed_to
  COMMENT = 'It represents the person whom a certain manuscript attributed.';


CREATE TABLE ms_manuscript_script_styles
(
  id            INT PRIMARY KEY    AUTO_INCREMENT,
  manuscript_id INT       NOT NULL,
  style_id      INT       NOT NULL,
  created_at    TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at    TIMESTAMP          DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  UNIQUE unique_index (manuscript_id, style_id),

  FOREIGN KEY (manuscript_id)
  REFERENCES ms_manuscript (id)
    ON DELETE CASCADE,
  FOREIGN KEY (style_id)
  REFERENCES ms_script_styles (id)
    ON DELETE CASCADE
)
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

ALTER TABLE ms_manuscript_script_styles
  COMMENT = 'It represents the script styles of a certain manuscript.';


CREATE TABLE ms_manuscript_reading_signs_functions
(
  id                    INT PRIMARY KEY    AUTO_INCREMENT,
  manuscript_id         INT                DEFAULT NULL,
  reading_sign_function VARCHAR(255)       DEFAULT NULL,
  created_at            TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at            TIMESTAMP          DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  UNIQUE unique_index (manuscript_id, reading_sign_function),

  FOREIGN KEY (manuscript_id)
  REFERENCES ms_manuscript (id)
    ON DELETE CASCADE
)
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

ALTER TABLE ms_manuscript_reading_signs_functions
  COMMENT = 'It represents the function of reading signs of a certain manuscript.';


CREATE TABLE ms_auction_houses
(
  id            INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
  auction_house VARCHAR(255)                            DEFAULT NULL UNIQUE,
  created_at    TIMESTAMP                      NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at    TIMESTAMP                               DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

ALTER TABLE ms_auction_houses
  COMMENT = 'It represents the auction houses where antiquity markets were held.';


CREATE TABLE ms_manuscript_antiquity_markets
(
  id               INT PRIMARY KEY    AUTO_INCREMENT,
  manuscript_id    INT                DEFAULT NULL,
  auction_house_id INT                DEFAULT NULL,
  auction_date     DATE               DEFAULT NULL,
  price            INT                DEFAULT NULL,
  currency         VARCHAR(255)       DEFAULT NULL,
  created_at       TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at       TIMESTAMP          DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  UNIQUE unique_index (manuscript_id, auction_house_id, auction_date),

  FOREIGN KEY (manuscript_id)
  REFERENCES ms_manuscript (id)
    ON DELETE CASCADE,
  FOREIGN KEY (auction_house_id)
  REFERENCES ms_auction_houses (id)
    ON DELETE CASCADE
)
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

ALTER TABLE ms_manuscript_antiquity_markets
  COMMENT = 'It represents the exact event when a certain manuscript is auctioned.';


CREATE TABLE ms_manuscript_verssegmentations
(
  id            INT PRIMARY KEY    AUTO_INCREMENT,
  manuscript_id INT                DEFAULT NULL,
  segmentation  VARCHAR(255)       DEFAULT NULL,
  created_at    TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at    TIMESTAMP          DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  UNIQUE unique_index (manuscript_id, segmentation),

  FOREIGN KEY (manuscript_id)
  REFERENCES ms_manuscript (id)
    ON DELETE CASCADE
)
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

ALTER TABLE ms_manuscript_verssegmentations
  COMMENT = 'It represents vers segmentations of a certain manuscript.';


CREATE TABLE ms_diacritics
(
  id         INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
  diacritic  VARCHAR(255)                            DEFAULT NULL,
  created_at TIMESTAMP                      NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP                               DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

ALTER TABLE ms_diacritics
  COMMENT = 'It represents the diacritics of manuscripts.';


CREATE TABLE ms_manuscript_diacritics
(
  id            INT PRIMARY KEY    AUTO_INCREMENT,
  manuscript_id INT       NOT NULL,
  diacritic_id  INT       NOT NULL,
  created_at    TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at    TIMESTAMP          DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  FOREIGN KEY (manuscript_id)
  REFERENCES ms_manuscript (id)
    ON DELETE CASCADE,
  FOREIGN KEY (diacritic_id)
  REFERENCES ms_diacritics (id)
    ON DELETE CASCADE
)
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

ALTER TABLE ms_manuscript_diacritics
  COMMENT = 'It represents the diacritics of a certain manuscript.';


CREATE TABLE ms_manuscript_assistances
(
  id            INT PRIMARY KEY    AUTO_INCREMENT,
  manuscript_id INT       NOT NULL,
  assistance_id INT       NOT NULL,
  created_at    TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at    TIMESTAMP          DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  UNIQUE unique_index (manuscript_id, assistance_id),

  FOREIGN KEY (manuscript_id)
  REFERENCES ms_manuscript (id)
    ON DELETE CASCADE,
  FOREIGN KEY (assistance_id)
  REFERENCES cc_authors (id)
    ON DELETE CASCADE
)
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

ALTER TABLE ms_manuscript_assistances
  COMMENT = 'It represents the assistants of a certain manuscript.';


CREATE TABLE ms_manuscript_image_editors
(
  id              INT PRIMARY KEY    AUTO_INCREMENT,
  manuscript_id   INT       NOT NULL,
  image_editor_id INT       NOT NULL,
  created_at      TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at      TIMESTAMP          DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  UNIQUE unique_index (manuscript_id, image_editor_id),

  FOREIGN KEY (manuscript_id)
  REFERENCES ms_manuscript (id)
    ON DELETE CASCADE,
  FOREIGN KEY (image_editor_id)
  REFERENCES cc_authors (id)
    ON DELETE CASCADE
)
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

ALTER TABLE ms_manuscript_image_editors
  COMMENT = 'It represents the image editors of a certain manuscript.';


CREATE TABLE ms_manuscript_transliteration_authors
(
  id                        INT PRIMARY KEY    AUTO_INCREMENT,
  manuscript_id             INT       NOT NULL,
  transliteration_author_id INT       NOT NULL,
  created_at                TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at                TIMESTAMP          DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  UNIQUE unique_index (manuscript_id, transliteration_author_id),

  FOREIGN KEY (manuscript_id)
  REFERENCES ms_manuscript (id)
    ON DELETE CASCADE,
  FOREIGN KEY (transliteration_author_id)
  REFERENCES cc_authors (id)
    ON DELETE CASCADE
)
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

ALTER TABLE ms_manuscript_transliteration_authors
  COMMENT = 'It represents transliteration authors of a certain manuscript.';


CREATE TABLE ms_manuscript_authors
(
  id            INT PRIMARY KEY    AUTO_INCREMENT,
  manuscript_id INT       NOT NULL,
  author_id     INT       NOT NULL,
  created_at    TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at    TIMESTAMP          DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  UNIQUE unique_index (manuscript_id, author_id),

  FOREIGN KEY (manuscript_id)
  REFERENCES ms_manuscript (id)
    ON DELETE CASCADE,
  FOREIGN KEY (author_id)
  REFERENCES cc_authors (id)
    ON DELETE CASCADE
)
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

ALTER TABLE ms_manuscript_authors
  COMMENT = 'It represents the manuscript metadata authors of a certain manuscript.';


CREATE TABLE ms_manuscript_pages #manuskriptseiten
(
  id            INT PRIMARY KEY    AUTO_INCREMENT,
  manuscript_id INT                DEFAULT NULL,
  folio         INT                DEFAULT NULL, #folio
  page_side     VARCHAR(255)       DEFAULT NULL, #seite
  is_online     TINYINT            DEFAULT 0, #webtauglich
  created_at    TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at    TIMESTAMP          DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  # UNIQUE unique_index (manuscript_id, folio, page_side), # too many duplicates in the old table manuskriptseiten to copy

  INDEX (is_online),

  FOREIGN KEY (manuscript_id)
  REFERENCES ms_manuscript (id)
    ON DELETE CASCADE
)
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

ALTER TABLE ms_manuscript_pages
  COMMENT = 'Old table: manuskriptseiten. It represents the manuscript pages of a certain manuscript.';


CREATE TABLE ms_manuscript_pages_images #manuskriptseiten_bilder
(
  id                  INT PRIMARY KEY    AUTO_INCREMENT,
  manuscript_page_id  INT                DEFAULT NULL,
  image_link          VARCHAR(500)       DEFAULT NULL, #bildlink
  image_link_external TEXT(2083)         DEFAULT NULL, #bildlink_extern
  credit_line_image   TEXT(2083)         DEFAULT NULL, #bildlinknachweis
  is_online           TINYINT            DEFAULT 0,
  created_at          TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at          TIMESTAMP          DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  INDEX (is_online),

  #     UNIQUE unique_index (manuscript_page_id, image_link), # too many duplicates in the old table manuskriptseiten_bilder to copy

  FOREIGN KEY (manuscript_page_id)
  REFERENCES ms_manuscript_pages (id)
    ON DELETE CASCADE
)
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

ALTER TABLE ms_manuscript_pages_images
  COMMENT = 'Old table: manuskriptseiten_bilder. It represents the digilib link to a certain manuscript page image.';


CREATE TABLE ms_manuscript_pages_mapping #manuskriptseiten_mapping
(
  id                 INT PRIMARY KEY    AUTO_INCREMENT,
  manuscript_page_id INT                DEFAULT NULL,
  sure_start         DECIMAL(3, 0)      DEFAULT NULL,
  vers_start         DECIMAL(3, 0)      DEFAULT NULL,
  word_start         DECIMAL(3, 0)      DEFAULT NULL,
  sure_end           DECIMAL(3, 0)      DEFAULT NULL,
  vers_end           DECIMAL(3, 0)      DEFAULT NULL,
  word_end           DECIMAL(3, 0)      DEFAULT NULL,
  created_at         TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at         TIMESTAMP          DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  UNIQUE unique_index (manuscript_page_id, sure_start, vers_start, word_start, sure_end, vers_end, word_end),

  INDEX mapping_index (sure_start ASC, vers_start ASC, word_start ASC, sure_end ASC, vers_end ASC, word_end ASC),

  INDEX (manuscript_page_id),
  FOREIGN KEY (manuscript_page_id)
  REFERENCES ms_manuscript_pages (id)
    ON DELETE CASCADE
)
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

ALTER TABLE ms_manuscript_pages_mapping
  COMMENT = 'Old table: manuskriptseiten_mapping. It represents a mapping table for manuscript pages (Quran words mapping).';


INSERT INTO ms_original_codexes (original_codex_name, supercategory)
VALUES ('keine', NULL);
INSERT INTO ms_original_codexes (original_codex_name, supercategory)
VALUES ('Blauer Koran', NULL);

INSERT INTO ms_attributed_to (person)
VALUES ('Caliph ʿUṯmān b. ʿAffān');
INSERT INTO ms_attributed_to (person)
VALUES ('ʿAlī b. Abī Ṭālib');
INSERT INTO ms_attributed_to (person)
VALUES ('Imām Riḍāʾ');
INSERT INTO ms_attributed_to (person)
VALUES ('Imām Ḥusain');
INSERT INTO ms_attributed_to (person)
VALUES ('Imām as-Saǧǧād');
INSERT INTO ms_attributed_to (person)
VALUES ('Imām Ḥasan');


INSERT INTO ms_auction_houses (auction_house)
VALUES ('Christies');
INSERT INTO ms_auction_houses (auction_house)
VALUES ('Sotheby');
INSERT INTO ms_auction_houses (auction_house)
VALUES ('Bonham');
INSERT INTO ms_auction_houses (auction_house)
VALUES ('Drouot');
INSERT INTO ms_auction_houses (auction_house)
VALUES ('Nancy enchères');
INSERT INTO ms_auction_houses (auction_house)
VALUES ('Quarich');


INSERT INTO ms_diacritics (diacritic)
VALUES ('ʾalif one dot');
INSERT INTO ms_diacritics (diacritic)
VALUES ('ʾalif two dots');
INSERT INTO ms_diacritics (diacritic)
VALUES ('bāʾ');
INSERT INTO ms_diacritics (diacritic)
VALUES ('tāʾ');
INSERT INTO ms_diacritics (diacritic)
VALUES ('ṯāʾ');
INSERT INTO ms_diacritics (diacritic)
VALUES ('ǧīm');
INSERT INTO ms_diacritics (diacritic)
VALUES ('ḥāʾ');
INSERT INTO ms_diacritics (diacritic)
VALUES ('ḫāʾ');
INSERT INTO ms_diacritics (diacritic)
VALUES ('dāl');
INSERT INTO ms_diacritics (diacritic)
VALUES ('ḏāl');
INSERT INTO ms_diacritics (diacritic)
VALUES ('rāʾ');
INSERT INTO ms_diacritics (diacritic)
VALUES ('zāy');
INSERT INTO ms_diacritics (diacritic)
VALUES ('sīn');
INSERT INTO ms_diacritics (diacritic)
VALUES ('šīn');
INSERT INTO ms_diacritics (diacritic)
VALUES ('ṣād');
INSERT INTO ms_diacritics (diacritic)
VALUES ('ḍād');
INSERT INTO ms_diacritics (diacritic)
VALUES ('ṭāʾ');
INSERT INTO ms_diacritics (diacritic)
VALUES ('ẓāʾ');
INSERT INTO ms_diacritics (diacritic)
VALUES ('ʿain');
INSERT INTO ms_diacritics (diacritic)
VALUES ('ġain');
INSERT INTO ms_diacritics (diacritic)
VALUES ('fāʾ dot above');
INSERT INTO ms_diacritics (diacritic)
VALUES ('fāʾ dot below');
INSERT INTO ms_diacritics (diacritic)
VALUES ('qāf dot above');
INSERT INTO ms_diacritics (diacritic)
VALUES ('qāf dot below');
INSERT INTO ms_diacritics (diacritic)
VALUES ('qāf two dots above');
INSERT INTO ms_diacritics (diacritic)
VALUES ('kāf');
INSERT INTO ms_diacritics (diacritic)
VALUES ('lām');
INSERT INTO ms_diacritics (diacritic)
VALUES ('mīm');
INSERT INTO ms_diacritics (diacritic)
VALUES ('nūn');
INSERT INTO ms_diacritics (diacritic)
VALUES ('hāʾ');
INSERT INTO ms_diacritics (diacritic)
VALUES ('wāw');
INSERT INTO ms_diacritics (diacritic)
VALUES ('yāʾ');

INSERT INTO ms_funders (funder)
VALUES ('CC');
INSERT INTO ms_funders (funder)
VALUES ('Paleocoran');
INSERT INTO ms_funders (funder)
VALUES ('Irankoran');
INSERT INTO ms_funders (funder)
VALUES ('Qatarkoran');


INSERT INTO ms_provenances (provenance)
VALUES ('Kūfa');
INSERT INTO ms_provenances (provenance)
VALUES ('Baṣra');
INSERT INTO ms_provenances (provenance)
VALUES ('Madīna');
INSERT INTO ms_provenances (provenance)
VALUES ('Makka');
INSERT INTO ms_provenances (provenance)
VALUES ('Dimašq');
INSERT INTO ms_provenances (provenance)
VALUES ('al-Fusṭāṭ');
INSERT INTO ms_provenances (provenance)
VALUES ('Ḥims');
INSERT INTO ms_provenances (provenance)
VALUES ('Qairawān');


INSERT INTO ms_reading_signs (reading_sign)
VALUES ('red dots');
INSERT INTO ms_reading_signs (reading_sign)
VALUES ('green dots');
INSERT INTO ms_reading_signs (reading_sign)
VALUES ('blue dots');
INSERT INTO ms_reading_signs (reading_sign)
VALUES ('yellow dots');
INSERT INTO ms_reading_signs (reading_sign)
VALUES ('red stroke');
INSERT INTO ms_reading_signs (reading_sign)
VALUES ('green stroke');
INSERT INTO ms_reading_signs (reading_sign)
VALUES ('blue stroke');
INSERT INTO ms_reading_signs (reading_sign)
VALUES ('yellow stroke');
INSERT INTO ms_reading_signs (reading_sign)
VALUES ('no sign');


INSERT INTO ms_script_styles (style)
VALUES ('ḥiǧāzī');
INSERT INTO ms_script_styles (style)
VALUES ('ḥiǧāzī I');
INSERT INTO ms_script_styles (style)
VALUES ('ḥiǧāzī II');
INSERT INTO ms_script_styles (style)
VALUES ('ḥiǧāzī III');
INSERT INTO ms_script_styles (style)
VALUES ('ḥiǧāzī IV');
INSERT INTO ms_script_styles (style)
VALUES ('kūfī');
INSERT INTO ms_script_styles (style)
VALUES ('kūfī A I');
INSERT INTO ms_script_styles (style)
VALUES ('kūfī B I a');
INSERT INTO ms_script_styles (style)
VALUES ('kūfī B I b');
INSERT INTO ms_script_styles (style)
VALUES ('kūfī B II');
INSERT INTO ms_script_styles (style)
VALUES ('kūfī C I a');
INSERT INTO ms_script_styles (style)
VALUES ('kūfī C I b');
INSERT INTO ms_script_styles (style)
VALUES ('kūfī C II');
INSERT INTO ms_script_styles (style)
VALUES ('kūfī C III');
INSERT INTO ms_script_styles (style)
VALUES ('kūfī D');
INSERT INTO ms_script_styles (style)
VALUES ('kūfī D I');
INSERT INTO ms_script_styles (style)
VALUES ('kūfī D III');
INSERT INTO ms_script_styles (style)
VALUES ('kūfī D IV');
INSERT INTO ms_script_styles (style)
VALUES ('kūfī D V a');
INSERT INTO ms_script_styles (style)
VALUES ('kūfī D V b');
INSERT INTO ms_script_styles (style)
VALUES ('kūfī D V c');
INSERT INTO ms_script_styles (style)
VALUES ('kūfī D I / D III');
INSERT INTO ms_script_styles (style)
VALUES ('kūfī Group D');
INSERT INTO ms_script_styles (style)
VALUES ('kūfī D common');
INSERT INTO ms_script_styles (style)
VALUES ('kūfī E I');
INSERT INTO ms_script_styles (style)
VALUES ('kūfī F I');
INSERT INTO ms_script_styles (style)
VALUES ('umayyad O');
INSERT INTO ms_script_styles (style)
VALUES ('umayyad O I a');
INSERT INTO ms_script_styles (style)
VALUES ('umayyad O I b');
INSERT INTO ms_script_styles (style)
VALUES ('new style');
INSERT INTO ms_script_styles (style)
VALUES ('new style I');
INSERT INTO ms_script_styles (style)
VALUES ('new style II');
INSERT INTO ms_script_styles (style)
VALUES ('new style III');
INSERT INTO ms_script_styles (style)
VALUES ('maġribī');
INSERT INTO ms_script_styles (style)
VALUES ('nasḫ');
INSERT INTO ms_script_styles (style)
VALUES ('ṯuluṯ');
INSERT INTO ms_script_styles (style)
VALUES ('muḥaqqaq');
INSERT INTO ms_script_styles (style)
VALUES ('sūdānī');
INSERT INTO ms_script_styles (style)
VALUES ('tauqīʿ');
INSERT INTO ms_script_styles (style)
VALUES ('taliq');
INSERT INTO ms_script_styles (style)
VALUES ('nastaliq');
INSERT INTO ms_script_styles (style)
VALUES ('raiḥānī');
INSERT INTO ms_script_styles (style)
VALUES ('biḥārī');
INSERT INTO ms_script_styles (style)
VALUES ('other (non classified)');

# transfer data from 'aufbewahrungsort' to 'ms_places'
INSERT INTO ms_places (id, place, place_name, country_code, description, link, image_link, image_original_link,
                       image_description, longitude, latitude, geonames)
  SELECT
    id,
    ort,
    name,
    country_code,
    beschreibung,
    link,
    bild_link,
    bild_orig,
    bild_beschreibung,
    longitude,
    latitude,
    geonames
  FROM aufbewahrungsorte;

# transfer data from 'manuskript' to 'ms_manuscript'
INSERT INTO ms_manuscript (id, credit_line_image,
                           commentary_internal, catalogue_entry, codicology, paleography, transliteration)
  SELECT
    ID,
    Bildnachweis,
    Kommentar_intern,
    Kommentar,
    Kodikologie,
    Palaographie,
    transliteration_alt
  FROM manuskript;

# transfer data from 'manuskript_mapping' to 'ms_manuscript_mapping'
INSERT INTO ms_manuscript_mapping (id, manuscript_id, sure_start, vers_start, word_start, sure_end, vers_end,
                                   word_end)
  SELECT
    msm.id,
    msm.manuskript,
    msm.sure_start,
    msm.vers_start,
    msm.wort_start,
    msm.sure_ende,
    msm.vers_ende,
    msm.wort_ende
  FROM manuskript_mapping msm
    INNER JOIN ms_manuscript ms ON msm.manuskript = ms.id;

# copy pages with numeric folios
INSERT INTO ms_manuscript_pages (id, manuscript_id, folio, page_side)
  SELECT
    SeitenID,
    ManuskriptID,
    CAST(Folio AS UNSIGNED),
    Seite
  FROM manuskriptseiten ms
    INNER JOIN ms_manuscript m ON ms.ManuskriptID = m.id
  WHERE ms.Folio REGEXP '^[0-9]+$';

# copy pages with non-numeric folios
INSERT INTO ms_manuscript_pages (id, manuscript_id, page_side)
  SELECT
    SeitenID,
    ManuskriptID,
    Seite
  FROM manuskriptseiten ms
    INNER JOIN ms_manuscript m ON ms.ManuskriptID = m.id
  WHERE ms.Folio REGEXP '^[a-z]+$';

# transfer data from 'manuskriptseiten_mapping' to 'ms_manuscript_pages_mapping'
INSERT INTO ms_manuscript_pages_mapping (id, manuscript_page_id, sure_start, vers_start, word_start, sure_end, vers_end,
                                         word_end)
  SELECT
    msm.id,
    msm.manuskriptseite,
    msm.sure_start,
    msm.vers_start,
    msm.wort_start,
    msm.sure_ende,
    msm.vers_ende,
    msm.wort_ende
  FROM manuskriptseiten_mapping msm
    INNER JOIN ms_manuscript_pages ms ON msm.manuskriptseite = ms.id;

# transfer data from 'manuskriptseiten_bilder' to 'ms_manuscript_pages_images'
INSERT INTO ms_manuscript_pages_images (id, manuscript_page_id, image_link, image_link_external, credit_line_image)
  SELECT
    msb.id,
    msb.manuskriptseite,
    msb.Bildlink,
    msb.Bildlink_extern,
    msb.Bildlinknachweis
  FROM manuskriptseiten_bilder msb
    INNER JOIN ms_manuscript_pages m ON msb.manuskriptseite = m.id;

# INTERTEXTS


CREATE TABLE it_source_authors
(
  id                      INT PRIMARY KEY       AUTO_INCREMENT,
  author_name             VARCHAR(255) NOT NULL UNIQUE,
  source_information_text TEXT(65535)           DEFAULT NULL,
  created_at              TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at              TIMESTAMP             DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP

)
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

ALTER TABLE it_source_authors
  COMMENT = 'It represents the authors of sources.';

INSERT INTO it_source_authors (author_name)
  VALUE ('Anonymous');

CREATE TABLE it_sources
(
  id                      INT PRIMARY KEY       AUTO_INCREMENT,
  source_name             VARCHAR(255) NOT NULL UNIQUE,
  author_id               INT          NOT NULL,
  source_information_text TEXT(65535)           DEFAULT NULL,
  is_valid_source         TINYINT(1)            DEFAULT 0,
  created_at              TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at              TIMESTAMP             DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  UNIQUE unique_index (source_name, author_id),

  FOREIGN KEY (author_id)
  REFERENCES it_source_authors (id)

)
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

ALTER TABLE it_sources
  COMMENT = 'It represents the sources of intertexts. It can be a book, poetry, letter, and other types of text.';

CREATE TABLE it_source_author_information_authors
(
  id             INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
  info_author_id INT                            NOT NULL,
  author_id      INT                            NOT NULL,
  created_at     TIMESTAMP                      NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at     TIMESTAMP                               DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  UNIQUE unique_index (info_author_id, author_id),

  FOREIGN KEY (info_author_id)
  REFERENCES cc_authors (id)
    ON DELETE CASCADE,
  FOREIGN KEY (author_id)
  REFERENCES it_source_authors (id)
    ON DELETE CASCADE

)
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

ALTER TABLE it_source_author_information_authors
  COMMENT = 'It represents the authors of a certain source author information text.';

CREATE TABLE it_source_information_authors
(
  id             INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
  info_author_id INT                            NOT NULL,
  source_id      INT                            NOT NULL,
  created_at     TIMESTAMP                      NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at     TIMESTAMP                               DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  UNIQUE unique_index (info_author_id, source_id),

  FOREIGN KEY (info_author_id)
  REFERENCES cc_authors (id)
    ON DELETE CASCADE,
  FOREIGN KEY (source_id)
  REFERENCES it_sources (id)
    ON DELETE CASCADE

)
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

ALTER TABLE it_source_information_authors
  COMMENT = 'It represents the authors of a certain source information text.';

CREATE TABLE it_original_languages
(
  id                INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
  original_language VARCHAR(255)                   NOT NULL UNIQUE,
  created_at        TIMESTAMP                      NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at        TIMESTAMP                               DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP

)
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

ALTER TABLE it_original_languages
  COMMENT = 'It represents the languages of intertext original texts.';

INSERT INTO it_original_languages (original_language)
VALUES ('Arabic');
INSERT INTO it_original_languages (original_language)
VALUES ('Sabaic');
INSERT INTO it_original_languages (original_language)
VALUES ('Aramaic');
INSERT INTO it_original_languages (original_language)
VALUES ('Hebrew');
INSERT INTO it_original_languages (original_language)
VALUES ('Greek');
INSERT INTO it_original_languages (original_language)
VALUES ('Aramaic/Arabic');
INSERT INTO it_original_languages (original_language)
VALUES ('Minaic');
INSERT INTO it_original_languages (original_language)
VALUES ('Dedanic');
INSERT INTO it_original_languages (original_language)
VALUES ('Safaitic');
INSERT INTO it_original_languages (original_language)
VALUES ('Armenian');
INSERT INTO it_original_languages (original_language)
VALUES ('Georgian');
INSERT INTO it_original_languages (original_language)
VALUES ('Church Slavonic');
INSERT INTO it_original_languages (original_language)
VALUES ('Aramaic/Hebrew');
INSERT INTO it_original_languages (original_language)
VALUES ('Latin');
INSERT INTO it_original_languages (original_language)
VALUES ('Old Spanish');

CREATE TABLE it_scripts
(
  id         INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
  script     VARCHAR(255)                   NOT NULL UNIQUE,
  created_at TIMESTAMP                      NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP                               DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP

)
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

ALTER TABLE it_scripts
  COMMENT = 'It represents the languages of intertext transcriptions.';

INSERT INTO it_scripts (script)
VALUES ('Latin');
INSERT INTO it_scripts (script)
VALUES ('Greek');
INSERT INTO it_scripts (script)
VALUES ('Arabic');
INSERT INTO it_scripts (script)
VALUES ('Ancient South Arabian');
INSERT INTO it_scripts (script)
VALUES ('Nabatean');
INSERT INTO it_scripts (script)
VALUES ('Ancient North Arabian');
INSERT INTO it_scripts (script)
VALUES ('Ethiopian');
INSERT INTO it_scripts (script)
VALUES ('Armenian');
INSERT INTO it_scripts (script)
VALUES ('Georgian');
INSERT INTO it_scripts (script)
VALUES ('Cyrillic');
INSERT INTO it_scripts (script)
VALUES ('Hebrew');


CREATE TABLE it_categories #belegstellen_kategorie
(
  id                      INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
  category_name           VARCHAR(255)                   NOT NULL UNIQUE,
  classification          VARCHAR(255)                            DEFAULT NULL,
  supercategory           INT                                     DEFAULT NULL,
  source_information_text TEXT(65535)                             DEFAULT NULL,
  created_at              TIMESTAMP                      NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at              TIMESTAMP                               DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  UNIQUE unique_index (category_name, supercategory),

  FOREIGN KEY (supercategory)
  REFERENCES it_categories (id)

)
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

ALTER TABLE it_categories
  COMMENT = 'Old table: belegstellen_kategorie. It represents the category of intertexts.';

CREATE TABLE it_category_information_authors
(
  id             INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
  info_author_id INT                            NOT NULL,
  category_id    INT                            NOT NULL,
  created_at     TIMESTAMP                      NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at     TIMESTAMP                               DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  UNIQUE unique_index (info_author_id, category_id),

  FOREIGN KEY (info_author_id)
  REFERENCES cc_authors (id)
    ON DELETE CASCADE,
  FOREIGN KEY (category_id)
  REFERENCES it_categories (id)
    ON DELETE CASCADE

)
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

ALTER TABLE it_category_information_authors
  COMMENT = 'It represents the authors of a certain category information text.';

CREATE TABLE it_intertext #belegstellen
(
  id                        INT PRIMARY KEY    AUTO_INCREMENT,
  source_id                 INT                DEFAULT NULL, #Titel #should be not null. It doesn't work because of the data copy from old table
  source_chapter            VARCHAR(255)       DEFAULT NULL,
  language_id               INT                DEFAULT NULL, #Sprache
  language_direction        VARCHAR(3)         DEFAULT NULL, #Sprache_richtung
  source_text_original      TEXT(65535)        DEFAULT NULL, #Originalsprache
  source_text_transcription TEXT(65535)        DEFAULT NULL, #Transkription
  script_id                 INT                DEFAULT NULL,
  place                     VARCHAR(255)       DEFAULT NULL, #Ort
  intertext_date_start      VARCHAR(255)       DEFAULT NULL, #Datierung
  intertext_date_end        VARCHAR(255)       DEFAULT NULL, #Datierung
  source_text_edition       TEXT(65535)        DEFAULT NULL, #Edition
  explanation_about_edition TEXT(65535)        DEFAULT NULL, #HinweiseaufEdition
  tuk_reference             TEXT(65535)        DEFAULT NULL, #Identifikator
  quran_text                TEXT(65535)        DEFAULT NULL, #TextstelleKoran
  entry                     TEXT(65535)        DEFAULT NULL, #Anmerkungen
  is_online                 TINYINT            DEFAULT 0, #webtauglich
  category_id               INT                DEFAULT NULL, #kategorie
  keyword_persons           TEXT(65535)        DEFAULT NULL, #SchlagwortPersonen
  keyword_places            TEXT(65535)        DEFAULT NULL, #SchlagwortOrte
  keyword_others            TEXT(65535)        DEFAULT NULL, #SchlagwortSonst
  keyword                   TEXT(65535)        DEFAULT NULL, #Stichwort
  doi                       VARCHAR(255)       DEFAULT NULL,
  last_author               VARCHAR(255)       DEFAULT NULL, #lastAuthor
  created_at                TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at                TIMESTAMP          DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  published_at              TIMESTAMP NULL     DEFAULT NULL,

  UNIQUE unique_index (source_id, source_chapter),

  INDEX (is_online),

  FOREIGN KEY (category_id)
  REFERENCES it_categories (id),
  FOREIGN KEY (script_id)
  REFERENCES it_scripts (id),
  FOREIGN KEY (source_id)
  REFERENCES it_sources (id),
  FOREIGN KEY (language_id)
  REFERENCES it_original_languages (id)

)
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

ALTER TABLE it_intertext
  COMMENT = 'Old table: belegstellen. It represents the metadata of intertexts.';


CREATE TABLE it_intertext_source_text_original_translations
(
  id                                INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
  language_id                       INT                            NOT NULL,
  intertext_id                      INT                            NOT NULL,
  translator_id                     INT                            NOT NULL,
  source_text_translation_reference TEXT(65535)                             DEFAULT NULL,
  source_text_translation           TEXT(65535)                             DEFAULT NULL,
  created_at                        TIMESTAMP                      NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at                        TIMESTAMP                               DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  UNIQUE unique_index (language_id, intertext_id, translator_id),

  FOREIGN KEY (language_id)
  REFERENCES cc_translation_languages (id),
  FOREIGN KEY (intertext_id)
  REFERENCES it_intertext (id)
    ON DELETE CASCADE,
  FOREIGN KEY (translator_id)
  REFERENCES cc_authors (id)

)
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

ALTER TABLE it_intertext_source_text_original_translations
  COMMENT = 'It represents the translation of an original text.';

CREATE TABLE it_intertext_entry_translations
(
  id                INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
  language_id       INT                            NOT NULL,
  intertext_id      INT                            NOT NULL,
  translator_id     INT                            NOT NULL,
  #     entry_translation_reference TEXT(65535)                             DEFAULT NULL,
  entry_translation TEXT(65535)                             DEFAULT NULL,
  created_at        TIMESTAMP                      NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at        TIMESTAMP                               DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  UNIQUE unique_index (language_id, intertext_id, translator_id),

  FOREIGN KEY (language_id)
  REFERENCES cc_translation_languages (id),
  FOREIGN KEY (intertext_id)
  REFERENCES it_intertext (id)
    ON DELETE CASCADE,
  FOREIGN KEY (translator_id)
  REFERENCES cc_authors (id)

)
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

ALTER TABLE it_intertext_entry_translations
  COMMENT = 'It represents the translation of an entry text.';

CREATE TABLE it_source_information_translations
(
  id                                INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
  language_id                       INT                            NOT NULL,
  source_id                         INT                            NOT NULL,
  translator_id                     INT                            NOT NULL,
  information_translation_reference TEXT(65535)                             DEFAULT NULL,
  information_translation           TEXT(65535)                             DEFAULT NULL,
  created_at                        TIMESTAMP                      NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at                        TIMESTAMP                               DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  UNIQUE unique_index (language_id, source_id, translator_id),

  FOREIGN KEY (language_id)
  REFERENCES cc_translation_languages (id),
  FOREIGN KEY (source_id)
  REFERENCES it_sources (id)
    ON DELETE CASCADE,
  FOREIGN KEY (translator_id)
  REFERENCES cc_authors (id)

)
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

ALTER TABLE it_source_information_translations
  COMMENT = 'It represents the translation of a certain source information text.';

CREATE TABLE it_category_information_translations
(
  id                                INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
  language_id                       INT                            NOT NULL,
  category_id                       INT                            NOT NULL,
  translator_id                     INT                            NOT NULL,
  information_translation_reference TEXT(65535)                             DEFAULT NULL,
  information_translation           TEXT(65535)                             DEFAULT NULL,
  created_at                        TIMESTAMP                      NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at                        TIMESTAMP                               DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  UNIQUE unique_index (language_id, category_id, translator_id),

  FOREIGN KEY (language_id)
  REFERENCES cc_translation_languages (id),
  FOREIGN KEY (category_id)
  REFERENCES it_categories (id)
    ON DELETE CASCADE,
  FOREIGN KEY (translator_id)
  REFERENCES cc_authors (id)

)
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

ALTER TABLE it_category_information_translations
  COMMENT = 'It represents the translation of a certain category information text.';


CREATE TABLE it_source_author_information_translations
(
  id                                INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
  language_id                       INT                            NOT NULL,
  source_author_id                  INT                            NOT NULL,
  translator_id                     INT                            NOT NULL,
  information_translation_reference TEXT(65535)                             DEFAULT NULL,
  information_translation           TEXT(65535)                             DEFAULT NULL,
  created_at                        TIMESTAMP                      NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at                        TIMESTAMP                               DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  UNIQUE unique_index (language_id, source_author_id, translator_id),

  FOREIGN KEY (language_id)
  REFERENCES cc_translation_languages (id),
  FOREIGN KEY (source_author_id)
  REFERENCES it_source_authors (id)
    ON DELETE CASCADE,
  FOREIGN KEY (translator_id)
  REFERENCES cc_authors (id)

)
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

ALTER TABLE it_source_author_information_translations
  COMMENT = 'It represents the translation of a certain source author information text.';


CREATE TABLE it_intertext_authors #belegstellen_bearbeiter
(
  id           INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
  intertext_id INT                            NOT NULL,
  author_id    INT                            NOT NULL, #bearbeiter
  addition     VARCHAR(255)                            DEFAULT NULL, #zusatz
  created_at   TIMESTAMP                      NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at   TIMESTAMP                               DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  UNIQUE unique_index (intertext_id, author_id),

  FOREIGN KEY (intertext_id)
  REFERENCES it_intertext (id)
    ON DELETE CASCADE,
  FOREIGN KEY (author_id)
  REFERENCES cc_authors (id)
    ON DELETE CASCADE

)
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

ALTER TABLE it_intertext_authors
  COMMENT = 'Old table: belegstellen_bearbeiter. It represents the authors of a certain intertext.';


CREATE TABLE it_intertext_collaborators
(
  id           INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
  intertext_id INT                            NOT NULL,
  author_id    INT                            NOT NULL,
  created_at   TIMESTAMP                      NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at   TIMESTAMP                               DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  UNIQUE unique_index (intertext_id, author_id),

  FOREIGN KEY (intertext_id)
  REFERENCES it_intertext (id)
    ON DELETE CASCADE,
  FOREIGN KEY (author_id)
  REFERENCES cc_authors (id)
    ON DELETE CASCADE


)
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

ALTER TABLE it_intertext_collaborators
  COMMENT = 'It represents the collaborators of a certain intertext.';


CREATE TABLE it_intertext_updaters
(
  id           INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
  intertext_id INT                            NOT NULL,
  author_id    INT                            NOT NULL,
  created_at   TIMESTAMP                      NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at   TIMESTAMP                               DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  UNIQUE unique_index (intertext_id, author_id),

  FOREIGN KEY (intertext_id)
  REFERENCES it_intertext (id)
    ON DELETE CASCADE,
  FOREIGN KEY (author_id)
  REFERENCES cc_authors (id)
    ON DELETE CASCADE

)
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

ALTER TABLE it_intertext_updaters
  COMMENT = 'It represents the updaters of a certain intertext.';


CREATE TABLE it_intertext_text_editing
(
  id           INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
  intertext_id INT                            NOT NULL,
  author_id    INT                            NOT NULL,
  created_at   TIMESTAMP                      NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at   TIMESTAMP                               DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  UNIQUE unique_index (intertext_id, author_id),

  FOREIGN KEY (intertext_id)
  REFERENCES it_intertext (id)
    ON DELETE CASCADE,
  FOREIGN KEY (author_id)
  REFERENCES cc_authors (id)
    ON DELETE CASCADE

)
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

ALTER TABLE it_intertext_text_editing
  COMMENT = 'It represents the text editing of a certain intertext.';


CREATE TABLE it_intertext_illustrations #belegstellen_bilder
(
  id                INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
  intertext_id      INT                            NOT NULL,
  image_link        VARCHAR(255)                   NOT NULL UNIQUE, #bildlink
  licence_for_image TEXT(65535)                             DEFAULT NULL, #bildnachweis
  created_at        TIMESTAMP                      NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at        TIMESTAMP                               DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  UNIQUE unique_index (intertext_id, image_link),

  FOREIGN KEY (intertext_id)
  REFERENCES it_intertext (id)

)
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

ALTER TABLE it_intertext_illustrations
  COMMENT = 'Old table: belegstellen_bilder. It represents the image of a certain intertext.';

CREATE TABLE it_intertext_mapping #belegstellen_mapping
(
  id           INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
  intertext_id INT                            NOT NULL,
  sure_start   DECIMAL(3, 0)                  NOT NULL,
  vers_start   DECIMAL(3, 0)                  NOT NULL,
  sure_end     DECIMAL(3, 0)                  NOT NULL,
  vers_end     DECIMAL(3, 0)                  NOT NULL,
  created_at   TIMESTAMP                      NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at   TIMESTAMP                               DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  UNIQUE unique_index (intertext_id, sure_start, vers_start, sure_end, vers_end),

  INDEX mapping_index (sure_start ASC, vers_start ASC, sure_end ASC, vers_end ASC),

  FOREIGN KEY (intertext_id)
  REFERENCES it_intertext (id)

)
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

ALTER TABLE it_intertext_mapping
  COMMENT = 'Old table: belegstellen_mapping. It represents the mapping of a certain intertext. (Quran verses mapping)';


INSERT INTO it_categories (id, category_name, supercategory) VALUE (1, 'Super Category', NULL);

# transfer data from 'belegstellen_kategorie' to 'it_categories'
INSERT INTO it_categories (id, category_name, classification, supercategory, created_at, updated_at)
  SELECT
    id + 1,
    name,
    classification,
    supercategory + 1,
    created_at,
    updated_at
  FROM belegstellen_kategorie
  WHERE belegstellen_kategorie.id = 1;

INSERT INTO it_categories (id, category_name, classification, supercategory, created_at, updated_at)
  SELECT
    id + 1,
    name,
    classification,
    supercategory + 1,
    created_at,
    updated_at
  FROM belegstellen_kategorie
  WHERE belegstellen_kategorie.id > 1;

# transfer data from 'belegstellen' to 'it_intertext'
INSERT INTO it_intertext (id, language_direction, source_text_original, source_text_transcription, place,
                          source_text_edition,
                          explanation_about_edition, tuk_reference, quran_text, entry, keyword_persons, keyword_places,
                          keyword_others, keyword, last_author, category_id, created_at, updated_at)
  SELECT
    ID,
    Sprache_richtung,
    Originalsprache,
    Transkription,
    Ort,
    Edition,
    HinweiseaufEdition,
    Identifikator,
    TextstelleKoran,
    Anmerkungen,
    SchlagwortPersonen,
    SchlagwortOrte,
    SchlagwortSonst,
    Stichwort,
    lastAuthor,
    kategorie + 1,
    created_at,
    updated_at
  FROM belegstellen;

# transfer data from 'belegstellen_bilder' to 'it_intertext_illustrations'
INSERT INTO it_intertext_illustrations (id, intertext_id, image_link, licence_for_image, created_at, updated_at)
  SELECT
    id,
    belegstelle,
    bildlink,
    bildnachweis,
    created_at,
    updated_at
  FROM belegstellen_bilder bb
  WHERE EXISTS
  (
      SELECT id
      FROM it_intertext it
      WHERE it.id = bb.belegstelle
  );

# transfer data from 'belegstellen_mapping' to 'it_intertext_mapping'
INSERT INTO it_intertext_mapping (intertext_id, sure_start, vers_start, sure_end, vers_end)
  SELECT DISTINCT
    belegstelle,
    sure_start,
    vers_start,
    sure_ende,
    vers_ende
  FROM belegstellen_mapping bm
  WHERE EXISTS
  (
      SELECT id
      FROM it_intertext it
      WHERE it.id = bm.belegstelle
  );
