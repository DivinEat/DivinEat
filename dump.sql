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



  --
  -- Structure de la table `tdd_users`
  --
  CREATE TABLE `dve_users` (
    `id` int(11) NOT NULL,
    `firstname` varchar(50) NOT NULL,
    `lastname` varchar(100) NOT NULL,
    `email` varchar(255) NOT NULL,
    `pwd` varchar(16) NOT NULL,
    `status` tinyint(1) NOT NULL DEFAULT '0',
    `role` int(11) NOT NULL DEFAULT '0',
    `date_inserted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `date_updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
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