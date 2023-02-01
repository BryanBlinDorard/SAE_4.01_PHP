create table QUESTIONNAIRE(
    idQuestionnaire int,
    nom varchar(20),
    primary key (idQuestionnaire)
);

create table QUESTION(
    idQuestion int,
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

alter table REPONSE add foreign key (idQuestion) references QUESTION(idQuestion);
alter table QUESTION add foreign key (idQuestionnaire) references QUESTIONNAIRE(idQuestionnaire);