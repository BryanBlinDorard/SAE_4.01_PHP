insert into QUESTIONNAIRE values (1, "Dark Souls III"),
                                 (2, "Elden Ring"),
                                 (3, "Minecraft");

insert into QUESTION values (1, 1, "Quelle est la date de sortie du jeu ?", "date", 1, 1),
                            (4, 2, "Quel est le premier boss que l'on affronte ?", "text", 1, 1),
                            (2, 1, "Quelle est la date de sortie du jeu ?", "date", 1, 2),
                            (3, 1, "Quelle est la date de sortie du jeu ?", "date", 1, 3),
                            (5, 3, "Parmis les armes suivantes laquelle est un ultra espadon ?","radio", 1, 1),
                            (6, 4, "Parmis ces personnages, lesquels ne sont pas présents dans Dark Souls III ?", "checkbox", 2, 1),
                            (7, 5, "Combien y'a-t-il de boss ?", "number", 1, 1),
                            (8, 2, "Quel est la créature la plus puissante du jeu ?", "radio", 1, 3),
                            (9, 3, "En quelle version le style de PvP a beaucoup changé ?", "text", 1, 3),
                            (10, 4, "Combien de lingots de fer sont nécessaires pour frabriquer un set d'armure complet en fer ?", "number", 1, 3),
                            (11, 5, "Qui est le créateur de Minecraft ?", "text", 1, 3),
                            (12, 2, "Quel est le nom du boss le plus dur du jeu ?", "text", 1, 2),
                            (13, 3, "Quelles sont les formes de magies présentes dans le jeu ?", "checkbox", 2, 2),
                            (14, 4, "Combien y'a-t-il de boss dans le jeu ?", "number", 2, 2),
                            (15, 5, "Quel personnage non joueur fait des calins gratuitement à la Table Ronde ?", "text", 1, 2);

insert into REPONSE values (1, "2016-03-24", true, 1),
                           (2, "2022-02-25", true, 2),
                           (3, "2011-11-18", true, 3),
                           (4, "Iudex Gundyr", true, 4),
                           (5, "Epee droite d'Irithyll", false, 5),
                           (6, "Grand marteau de Vordt", false, 5),
                           (7, "Espadon de Chevalier de la Cathedrale", true, 5),
                           (8, "Greirat", false, 6),
                           (9, "Siegward de catarina", false, 6),
                           (10, "Ranni la Sorcière", true, 6),
                           (11, "Karla", false, 6),
                           (12, "Smough", true, 6),
                           (13, "25", true, 7),
                           (14, "Le Lapin", false, 8),
                           (15, "Le Wither", false, 8),
                           (16, "L'Ancien Gardien", false, 8),
                           (17, "Le Warden", true, 8),
                           (18, "Le Dragon de l'Ender", false, 8),
                           (19, "1.9", true, 9),
                           (20, "24", true, 10),
                           (21, "Notch", true, 11),
                           (22, "Malenia", true, 12),
                           (23, "Pyromancie", false, 13),
                           (24, "Sorcellerie", true, 13),
                           (25, "Miracle", false, 13),
                           (26, "Incantation", true, 13),
                           (27, "Invocation", false, 13),
                           (28, "Nécromancie", false, 13),
                           (29, "83", true, 14),
                           (30, "Fia", true, 15);

insert into CLASSEMENT values (1, 3),
                             (2,  2),
                             (3,  1);

insert into SCORE values (1, 1, "Bryan", 1),
                         (2, 0, "Constantin", 1),
                         (3, 1, "Bryan", 2),
                         (4, 1, "Constantin", 2),
                         (5, 0, "Bryan", 3),
                         (6, 2, "Constantin", 3);

insert into UTILISATEUR values (1, "Bryan", "1234"),
                               (2, "Constantin", "4321");