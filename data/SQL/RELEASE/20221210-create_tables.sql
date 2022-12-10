CREATE SEQUENCE IF NOT EXISTS public.user_id_seq
    INCREMENT 1 MINVALUE 1
    MAXVALUE 999999999999999 START 1;


CREATE TABLE usuarios (
    id INTEGER DEFAULT nextval('public.user_id_seq'::regclass) NOT NULL,,
    nome VARCHAR (50) UNIQUE NOT NULL,
    cpf VARCHAR (30) NOT NULL ,
    senha VARCHAR (50) NOT NULL,
    tipo VARCHAR (20) NOT NULL
);