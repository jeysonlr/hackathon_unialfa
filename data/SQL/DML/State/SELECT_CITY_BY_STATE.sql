select
    c.nome as cidade,
    e.nome as estado,
    e.abreviacao as uf
    from public.cidades c
    inner join public.estados e on e.estadoid = c.estadoid
        where c.estadoid = :estadoid
