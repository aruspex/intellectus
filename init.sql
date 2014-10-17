CREATE TABLE IF NOT EXISTS `users`(
    `id` int AUTO_INCREMENT,
    `login` varchar(30) NOT NULL UNIQUE,
    `password` char(128) NOT NULL,
    `is_admin` boolean DEFAULT false
    PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;


/* admin with password 'admin' */
INSERT INTO users (login, password, is_admin) VALUES
('admin', "c7ad44cbad762a5da0a452f9e854fdc1e0e7a52a38015f23f3eab1d80b931dd472634dfac71cd34ebc35d16ab7fb8a90c81f975113d6c7538dc69dd8de9077ec", true);

/* user with password 'user' */
INSERT INTO users (login, password, is_admin) VALUES
('user', "b14361404c078ffd549c03db443c3fede2f3e534d73f78f77301ed97d4a436a9fd9db05ee8b325c0ad36438b43fec8510c204fc1c1edb21d0941c00e9e2c1ce2", false);
