select
    c.nome,
    c.cpf,
    count(i.cliente_id) as qtd
from public.usuarios u
         inner join public.imc i on i.profissional_id = u.id
         inner join public.usuarios c on c.id = i.cliente_id
where u.id = :id
group by c.nome, c.cpf