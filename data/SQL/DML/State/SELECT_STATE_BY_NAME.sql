select
    e.estadoid,
    e.nome,
    e.abreviacao,
    e.datacriacao,
    e.dataalteracao
    from public.estados e
        where e.nome ilike '%' || :nome || '%'