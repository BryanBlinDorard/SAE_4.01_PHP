insert into QUESTIONNAIRE values (1, "Dark Souls III"),
                                 (2, "Elden Ring"),
                                 (3, "Minecraft");

insert into QUESTION values (1, 1, "Quelle est la date de sortie du jeu ?", "date", 1, 1),
                            (4, 2, "Quel est le premier boss que l'on affronte ?", "text", 1, 1),
                            (2, 1, "Quelle est la date de sortie du jeu ?", "date", 1, 2),
                            (3, 1, "Quelle est la date de sortie du jeu ?", "date", 1, 3);

insert into REPONSE value (1, "2016-03-24", 1),
                          (2, "2022-02-25", 2),
                          (3, "2011-11-18", 3),
                          (4, "Iudex Gundyr", 4);