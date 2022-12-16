CREATE SEQUENCE IF NOT EXISTS public.user_id_seq
    INCREMENT 1 MINVALUE 1
    MAXVALUE 999999999999999 START 1;


CREATE TABLE usuarios (
    id INTEGER DEFAULT nextval('public.user_id_seq'::regclass) NOT NULL,
    nome VARCHAR (50) UNIQUE NOT NULL,
    cpf VARCHAR (30) NOT NULL ,
    senha VARCHAR (500) NOT NULL,
    tipo VARCHAR (20) NOT NULL
);

CREATE TABLE imc (
                     id SERIAL PRIMARY KEY,
                     cliente_id integer NOT NULL,
                     profissional_id integer NOT NULL,
                     peso float NOT NULL,
                     altura float  NOT NULL,
                     data_hora DATE NOT NULL DEFAULT NOW()
);