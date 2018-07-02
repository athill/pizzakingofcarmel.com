import React from 'react';

const stores = [ 
	{ name: 'Carmel', 
		addr: '301 E. Carmel Dr., Suite A-800 ',
		addr2: 'Carmel, IN 46032',
		phone: '317-848-7449'				
	},
	{ name: 'Rushville', 
		addr: '211 N. Perkins St.',
		addr2: 'Rushville, IN 46173',
		phone: '756-932-2212'				
	},
	{ name: 'Rushville North', 
		addr: '1554 N. Main St.',
		addr2: 'Rushville, IN 46173',
		phone: '756-932-4243'				
	},	
	{ name: 'Greensburg', 
		addr: '1005 N. Lincoln St.',
		addr2: 'Greensburg, IN 47240',
		phone: '812-663-7677'				
	},	
	{ name: 'Greensburg Bypass', 
		addr: '915 Kathy\'s Way Ste. A',
		addr2: 'Greensburg, IN 47240',
		phone: '812-662-9677'				
	},		
	{ name: 'Liberty', 
		addr: '201 N. Main St.',
		addr2: 'Liberty, IN 47353',
		phone: '765-458-5775',
		'email': 'pizzakingliberty@frontier.com'				
	},		
	{ name: 'Batesville', 
		addr: '18 Saratoga Drive',
		addr2: 'Batesville, IN 47006',
		phone: '812-932-5464'
	},
];

const ContactUs = () => (
	<div id="familystores" className="container">
		{
			stores.map(({ name, addr, addr2, phone, email }) => (
				<div className="row familystore" key={name}>
					<div className="col-sm label">{name}:</div>
					<div className="col-sm">{ addr }<br />{ addr2 }<br />Phone: { phone } { email && <div>Email: <a href={`mailto:${email}`}>{ email }</a></div>  }</div>
				</div>				
			))
		}
	</div>
);

export default ContactUs;
