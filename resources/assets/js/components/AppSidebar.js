import React from 'react';

const Sidebar = () => (
	<ul id="navigation">
		<li className="active"><a href="/">Home</a></li>
		<li><a href="/menu/">Menu</a></li>
		<li><a href="/hours/">Hours</a></li>
		<li><a href="/directions/">Directions</a></li>
		<li><a href="/delivery.php">Delivery</a></li>
		<li><a href="/catering.php">Catering</a></li>
		<li><a href="/family.php">Other Family Stores</a></li>
		<li><a href="/pictures/">Pictures</a></li>
	</ul>
);

export default Sidebar;