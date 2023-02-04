insert into QUESTIONNAIRE values (1, "Dark Souls III"),
                                 (2, "Elden Ring"),
                                 (3, "Minecraft");

insert into QUESTION values (1, 1, "Quelle est la date de sortie du jeu ?", "date", 1, 1),
                            (4, 2, "Quel est le premier boss que l'on affronte ?", "text", 1, 1),
                            (2, 1, "Quelle est la date de sortie du jeu ?", "date", 1, 2),
                            (3, 1, "Quelle est la date de sortie du jeu ?", "date", 1, 3),
                            (5, 3, "Parmis les armes suivantes laquelle est un ultra espadon ?","radio", 1, 1),
                            (6, 4, "Parmis ces personnages, lesquels ne sont pas présents dans Dark Souls III ?", "checkbox", 2, 1),
                            (7, 5, "Combien y'a-t-il de boss ?", "number", 1, 1);

insert into REPONSE values (1, "2016-03-24", true, 1),
                           (2, "2022-02-25", true, 2),
                           (3, "2011-11-18", true, 3),
                           (4, "Iudex Gundyr", true, 4),
                           (5, "Épée droite d'Irithyll", false, 5),
                           (6, "Grand marteau de Vordt", false, 5),
                           (7, "Espadon de Chevalier de la Cathédrale", true, 5),
                           (8, "Greirat", false, 6),
                           (9, "Siegward de catarina", false, 6),
                           (10, "Ranni la Sorcière", true, 6),
                           (11, "Karla", false, 6),
                           (12, "Smough", true, 6),
                           (13, "25", true, 7);

insert into CLASSEMENT values (1, 3),
                             (2,  2),
                             (3,  1);

insert into SCORE values (1, 1, "Bryan", 1),
                         (2, 0, "Constantin", 1),
                         (3, 1, "Bryan", 2),
                         (4, 1, "Constantin", 2),
                         (5, 0, "Bryan", 3),
                         (6, 2, "Constantin", 3);