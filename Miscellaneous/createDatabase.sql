CREATE TABLE Theme(
   id_theme INT AUTO_INCREMENT,
   name VARCHAR(50) NOT NULL UNIQUE,
   PRIMARY KEY(id_theme)
);

CREATE TABLE Grade(
   id_grade INT AUTO_INCREMENT,
   label VARCHAR(50) NOT NULL UNIQUE,
   can_lock BOOLEAN NOT NULL,
   can_ban BOOLEAN NOT NULL,
   PRIMARY KEY(id_grade)
);

CREATE TABLE Client(
   id_client INT AUTO_INCREMENT,
   nickname VARCHAR(50) NOT NULL UNIQUE,
   email VARCHAR(50) NOT NULL UNIQUE,
   pw VARCHAR(50) NOT NULL,
   signedup DATETIME NOT NULL,
   avatar VARCHAR(70),
   signature VARCHAR(2000),
   about VARCHAR(2000),
   is_banned TINYINT NOT NULL,
   grade_id INT NOT NULL,
   PRIMARY KEY(id_client),
   FOREIGN KEY(grade_id) REFERENCES Grade(id_grade)
);

CREATE TABLE Thread(
   id_thread INT AUTO_INCREMENT,
   title VARCHAR(50) NOT NULL,
   creation DATETIME NOT NULL,
   locked BOOLEAN NOT NULL,
   lattest_edit DATE,
   theme_id INT NOT NULL,
   client_id INT NOT NULL,
   PRIMARY KEY(id_thread),
   FOREIGN KEY(theme_id) REFERENCES Theme(id_theme),
   FOREIGN KEY(client_id) REFERENCES Client(id_client)
);

CREATE TABLE Post(
   id_post INT AUTO_INCREMENT,
   body VARCHAR(2000) NOT NULL,
   creation TIME NOT NULL,
   lattest_edit DATE,
   thread_id INT NOT NULL,
   client_id INT NOT NULL,
   PRIMARY KEY(id_post),
   FOREIGN KEY(thread_id) REFERENCES Thread(id_thread),
   FOREIGN KEY(client_id) REFERENCES Client(id_client)
);
