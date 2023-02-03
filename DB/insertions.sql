insert into QUESTIONNAIRE values (1, "Dark Souls III"),
                                 (2, "Elden Ring"),
                                 (3, "Minecraft");

insert into QUESTION values (1, 1, "Quelle est la date de sortie du jeu ?", "date", 1, 1),
                            (4, 2, "Quel est le premier boss que l'on affronte ?", "text", 1, 1),
                            (2, 1, "Quelle est la date de sortie du jeu ?", "date", 1, 2),
                            (3, 1, "Quelle est la date de sortie du jeu ?", "date", 1, 3);

insert into REPONSE values (1, "2016-03-24", 1),
                          (2, "2022-02-25", 2),
                          (3, "2011-11-18", 3),
                          (4, "Iudex Gundyr", 4);

insert into CLASSEMENT values (1, 3),
                             (2,  2),
                             (3,  1);

insert into SCORE values (1, "Bryan", 1, 1),
                         (2, "Constantin", 0, 1),
                         (3, "Bryan", 1, 2),
                         (4, "Constantin", 1, 2),
                         (5, "Bryan", 0, 3),
                         (6, "Constantin", 2, 3);