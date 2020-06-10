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
  `date_inserted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `dve_users`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `dve_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;



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
  `id_elementmenu_entree` int(11) NOT NULL,
  `id_elementmenu_plat` int(11) NOT NULL,
  `id_elementmenu_dessert` int(11) NOT NULL,
  `prix` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `dve_menus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_elementmenu_entree` (`id_elementmenu_entree`),
  ADD KEY `id_elementmenu_plat` (`id_elementmenu_plat`),
  ADD KEY `id_elementmenu_dessert` (`id_elementmenu_dessert`);

ALTER TABLE `dve_menus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `dve_menus`
  ADD CONSTRAINT `dve_menus_ibfk_1` FOREIGN KEY (`id_elementmenu_entree`) REFERENCES `dve_elementmenus` (`id`),
  ADD CONSTRAINT `dve_menus_ibfk_2` FOREIGN KEY (`id_elementmenu_plat`) REFERENCES `dve_elementmenus` (`id`),
  ADD CONSTRAINT `dve_menus_ibfk_3` FOREIGN KEY (`id_elementmenu_dessert`) REFERENCES `dve_elementmenus` (`id`);