select
    c.cidadeid,
    c.nome,
    c.estadoid,
    c.datacriacao,
    c.dataalteracao
    from public.cidades c
        where c.nome ilike '%' || :nome || '%'
