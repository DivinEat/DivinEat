  --
  -- Structure de la table `tdd_users`
  --
  CREATE TABLE `dve_roles` (
    `id` int(11) NOT NULL,
    `libelle` varchar(50) NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

  ALTER TABLE `dve_roles`
    ADD PRIMARY KEY (`id`);

  ALTER TABLE `dve_roles`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

  INSERT INTO `dve_roles` (`id`, `libelle`) VALUES
    (0, 'Membre'),
    (1, 'Administrateur'),
    (2, 'Moderateur');



  --
  -- Structure de la table `tdd_users`
  --
  CREATE TABLE `dve_users` (
    `id` int(11) NOT NULL,
    `firstname` varchar(50),
    `lastname` varchar(100),
    `email` varchar(255) NOT NULL,
    `pwd` varchar(255),
    `status` tinyint(1) NOT NULL DEFAULT '0',
    `role` int(11) NOT NULL DEFAULT '0',
    `dateInserted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `dateUpdated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

  ALTER TABLE `dve_users`
    ADD PRIMARY KEY (`id`),
    ADD KEY `role` (`role`);

  ALTER TABLE `dve_users`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
    
  ALTER TABLE `dve_users`
    ADD CONSTRAINT `dve_users_ibfk_1` FOREIGN KEY (`role`) REFERENCES `dve_roles` (`id`);



  --
  -- Structure de la table `elementmenus`
  --
  CREATE TABLE `dve_elementmenus` (
    `id` int(11) NOT NULL,
    `categorie` varchar(15) NOT NULL,
    `nom` varchar(45) NOT NULL,
    `description` text NOT NULL,
    `prix` double NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

  ALTER TABLE `dve_elementmenus`
    ADD PRIMARY KEY (`id`);

  ALTER TABLE `dve_elementmenus`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;



  --
  -- Structure de la table `dve_menus`
  --
  CREATE TABLE `dve_menus` (
    `id` int(11) NOT NULL,
    `nom` varchar(45) NOT NULL,
    `entree` int(11),
    `plat` int(11),
    `dessert` int(11),
    `prix` double NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

  ALTER TABLE `dve_menus`
    ADD PRIMARY KEY (`id`),
    ADD KEY `entree` (`entree`),
    ADD KEY `plat` (`plat`),
    ADD KEY `dessert` (`dessert`);

  ALTER TABLE `dve_menus`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

  ALTER TABLE `dve_menus`
    ADD CONSTRAINT `dve_menus_ibfk_1` FOREIGN KEY (`entree`) REFERENCES `dve_elementmenus` (`id`),
    ADD CONSTRAINT `dve_menus_ibfk_2` FOREIGN KEY (`plat`) REFERENCES `dve_elementmenus` (`id`),
    ADD CONSTRAINT `dve_menus_ibfk_3` FOREIGN KEY (`dessert`) REFERENCES `dve_elementmenus` (`id`);



  --
  -- Structure de la table `articles`
  --
  CREATE TABLE `dve_articles` (
    `id` int(11) NOT NULL,
    `title` varchar(15) NOT NULL,
    `slug` varchar(15) NOT NULL,
    `content` text NOT NULL,
    `author` int(11) NOT NULL,
    `date_inserted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `date_updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

  ALTER TABLE `dve_articles`
    ADD PRIMARY KEY (`id`);

  ALTER TABLE `dve_articles`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

  ALTER TABLE `dve_articles`
    ADD CONSTRAINT `dve_articles_ibfk_1` FOREIGN KEY (`author`) REFERENCES `dve_users` (`id`);



--
-- Structure de la table `horaires`
--
CREATE TABLE `dve_horaires` (
  `id` int(11) NOT NULL,
  `horaire` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `dve_horaires`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `dve_horaires`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;



--
-- Structure de la table `orders`
--
CREATE TABLE `dve_orders` (
  `id` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `horaire` int(11) NOT NULL,
  `date` date NOT NULL,
  `prix` double NOT NULL,
  `surPlace` boolean NOT NULL,
  `status` varchar(45) NOT NULL DEFAULT 'En cours'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `dve_orders`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `dve_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `dve_orders`
  ADD CONSTRAINT `dve_orders_ibfk_1` FOREIGN KEY (`user`) REFERENCES `dve_users` (`id`),
  ADD CONSTRAINT `dve_orders_ibfk_2` FOREIGN KEY (`horaire`) REFERENCES `dve_horaires` (`id`);



--
-- Structure de la table `menu_order`
--
CREATE TABLE `dve_menu_order` (
  `id` int(11) NOT NULL,
  `menu` int(11) NOT NULL,
  `order` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `dve_menu_order`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `dve_menu_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `dve_menu_order`
  ADD CONSTRAINT `dve_menu_order_ibfk_1` FOREIGN KEY (`menu`) REFERENCES `dve_menus` (`id`),
  ADD CONSTRAINT `dve_menu_order_ibfk_2` FOREIGN KEY (`order`) REFERENCES `dve_orders` (`id`);



--
-- Structure de la table `menu_order`
--
CREATE TABLE `dve_configurations` (
  `id` int(11) NOT NULL,
  `libelle` varchar(45) NOT NULL,
  `info` varchar(255)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `dve_configurations`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `dve_configurations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

INSERT INTO `dve_configurations` (`libelle`) VALUES
('nom_du_site'),
('email'),
('facebook'),
('instagram'),
('linkedin');



--
-- Structure de la table `images`
--
CREATE TABLE `dve_images` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `dve_images`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `dve_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;