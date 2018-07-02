import React from 'react';
import { NavLink } from 'react-router-dom';

const MenuLink = props => (
	<NavLink {...props} activeClassName="active" />
);

const Navigation = () => (
	<ul id="navigation">
		<li><MenuLink exact to="/">Home</MenuLink></li>
		<li><a href="/menu/">Menu</a></li>
		<li><MenuLink to="/hours">Hours</MenuLink></li>
		<li><MenuLink to="/directions">Directions</MenuLink></li>
		<li><MenuLink to="/delivery">Delivery</MenuLink></li>
		<li><MenuLink to="/catering">Catering</MenuLink></li>
		<li><MenuLink to="/familystores">Other Family Stores</MenuLink></li>
		<li><MenuLink to="/pictures">Pictures</MenuLink></li>
	</ul>
);

export default Navigation;