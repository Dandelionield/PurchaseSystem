\c expenses

INSERT INTO super.user(

	user_dni,
	name,
	email

) VALUES (

	'1111111111',
	'Dante',
	'dante.alighieri@unicolombo.edu.co'

);

INSERT INTO super.employee(

	employee_code,
	user_dni,
	password

) VALUES (

	'1110010001',
	'1111111111',
	'lambda73'

);

INSERT INTO storage.item(

	item_code,
	name,
	price,
	stock

) VALUES (

	'FT-M',
	'Manzana',
	5000,
	30

),(

	'FT-P',
	'Pera',
	2000,
	50

) RETURNING item_id;

SELECT * FROM storage.item;

CALL expense.commit_purchase('1110010001','1111111111', ARRAY[

	ROW(1, 2),
	ROW(2, 10)

]::expense.purchased_item[], null);

SELECT * FROM storage.item;
SELECT * FROM expense.purchase;
SELECT * FROM expense.buyout;