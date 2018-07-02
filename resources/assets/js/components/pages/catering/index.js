import React from 'react';

const sections = [
	{ title: 'PIZZA', descr: '16 inch pizzas feed aprx. 5-6 people (count on 6 if including salad or breadsticks)  Prices and varieties are the same as listed on our regular menu.' },
	{ title: 'BREADSTICKS', descr: '$4.25: 5 sticks per order.  We include plenty of extra nacho cheese and marinara for dipping, based on number of people.' },
	{ title: 'SALAD BOWL', descr: '$35.00 Feeds aprx. 15 people. Our own fleshly chopped mixture of lettuce, carrots, and red cabbage.  Assortment of dressings included.' },
	{ title: 'PASTA BOWL', descr: '$30.00  Enough for 10-15 people. Delicious Baked Spaghetti topped with our pizza cheese.' },
	{ title: 'SANDWICH TRAY', descr: '$35.00  Feeds aprx. 8 people. Includes four hot, 11 inch sandwiches cut into pieces. Beef Boat, Submarine, Original Stromboli, and BBQ Stromboli.' },
	{ title: 'COOKIE TRAY', descr: '$25.00 aprx. 3 dozen cookies. <strong>Must order 24 hours in advance.</strong>  Chocolate chunk, white chocolate macadamia, and oatmeal raisin, everyone\'s favorites.' },
	{ title: 'DRINKS', descr: 'We offer prechilled 2 liters of Pepsi products:  Pepsi, Diet Pepsi, Mt. Dew, and Sierra Mist.' },
	{ title: 'ICE', descr: 'Bags of ice  available only with <strong>24 hour advanced ordering.</strong>' },
];

const Catering = () => (
	<div id="catering">
		<ul>
			<li>We can feed your group for as little as $4.00 per person.</li>
			<li>Groups of any size; 50 or more people please call at least <strong>24 hours</strong> ahead.</li>
			<li>***FREE DELIVERY*** available within limited area.</li>
			<li>Plates, cups, and napkins available upon request.</li>
			<li>10% discount for orders over $150.00 before tax.</li>
		</ul>
		{
			sections.map(section => (
				<div className="catering-section" key={section.title}>
					<span className="catering-label">{section.title} - </span>
					{ section.descr }
				</div>
			))
		}
	</div>
);

export default Catering;
