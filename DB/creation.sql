create table QUESTIONNAIRE(
    idQuestionnaire int,
    nom varchar(20),
    primary key (idQuestionnaire)
);

create table QUESTION(
    idQuestion int,
    numero int,
    question varchar(50),
    typeQuestion varchar(10),
    valeurQuestion int,
    idQuestionnaire int,
    primary key (idQuestion)
);

create table REPONSE(
    idReponse int,
    reponse varchar(20),
    idQuestion int,
    primary key (idReponse)
);

create table CLASSEMENT(
    idClassement int,
    nomPersonne varchar(30),
    scorePersonne int,
    idQuestionnaire int,
    primary key (idClassement)
);

alter table REPONSE add foreign key (idQuestion) references QUESTION(idQuestion);
alter table QUESTION add foreign key (idQuestionnaire) references QUESTIONNAIRE(idQuestionnaire);
alter table CLASSEMENT add foreign key (idQuestionnaire) references QUESTIONNAIRE(idQuestionnaire);