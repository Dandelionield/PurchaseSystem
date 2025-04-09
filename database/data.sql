\c expenses

INSERT INTO super.user(

	user_dni,
	name,
	email

) VALUES (

	'1111111111',
	'Dante',
	'dante.alighieri@unicolombo.edu.co'

),(

	'2222222222',
	'Maomao',
	'maomao@unicolombo.edu.co'

),(

	'3333333333',
	'Alex',
	'alex@unicolombo.edu.co'

),(

	'4444444444',
	'Danielle',
	'danielle@unicolombo'

),(

	'5555555555',
	'Doe',
	'doe@unicolombo.edu.co'

);

INSERT INTO super.employee(

	employee_code,
	user_dni,
	password,
	admin

) VALUES (

	'1110010001',
	'1111111111',
	'lambda73',
	true

),(

	'2220020002',
	'2222222222',
	'maomao123',
	false

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