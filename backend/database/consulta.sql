-- Query A: Listar os usuários com mais produtos

Select
	u.id,
	u.nome,
	COUNT(p.id) as total_produtos
From usuarios u
Left join produtos p on p.usuario_id = u.id
Group by u.id, u.nome
Order by total_produtos desc;

-- Query B: Buscar o produto mais caro por usuário

Select
	u.id as usuario_id,
	u.nome as nome_usuario,
	p.nome as nome_produto,
	p.preco
From produtos p
Inner join usuarios u on u.id = p.usuario_id 
Where p.preco = (
	Select max(p2.preco)
	From produtos p2
	Where p2.usuario_id = u.id
)
Order by preco desc