create table QUESTIONNAIRE(
    idQuestionnaire int,
    nom varchar(20),
    primary key (idQuestionnaire)
);

create table QUESTION(
    idQuestion int,
    numero int,
    question varchar(500),
    typeQuestion varchar(10),
    valeurQuestion int,
    idQuestionnaire int,
    primary key (idQuestion)
);

create table REPONSE(
    idReponse int,
    reponse varchar(100),
    estBonne boolean,
    idQuestion int,
    primary key (idReponse)
);

create table CLASSEMENT(
    idClassement int,
    idQuestionnaire int,
    primary key (idClassement)
);

create table SCORE(
    idScore int,
    scorePersonne int,
    nomPersonne varchar(30),
    idClassement int,
    primary key (idScore)
);

create table UTILISATEUR(
    idUtilisateur int,
    nom varchar(30),
    mdp varchar(30),
    primary key (idUtilisateur)
);


alter table REPONSE add foreign key (idQuestion) references QUESTION(idQuestion);
alter table QUESTION add foreign key (idQuestionnaire) references QUESTIONNAIRE(idQuestionnaire);
alter table CLASSEMENT add foreign key (idQuestionnaire) references QUESTIONNAIRE(idQuestionnaire);
alter table SCORE add foreign key (idClassement) references CLASSEMENT(idClassement);