import React, { Component, Fragment } from 'react';
import { Link } from 'react-router-dom';

import Navigation from './Navigation';

const MenuToggle = ({ onClick }) => (
	<i id="menu-toggle" className="fa fa-bars" onClick={onClick}></i>
);

const MAX_MOBILE_WIDTH = 768;

class AppLayout extends Component {
	constructor(props) {
		super(props);
		this._onMenuToggleClick = this._onMenuToggleClick.bind(this);
		this._updateWindowDimensions = this._updateWindowDimensions.bind(this);
		this._mobile = this._mobile.bind(this);
		this._closeMenu = this._closeMenu.bind(this);
		this.state = {
			showMobile: false,
			width: window.innerWidth,
			height: window.innerHeight
		};
	}

	// https://stackoverflow.com/questions/36862334/get-viewport-window-height-in-reactjs
	componentDidMount() {
	  this._updateWindowDimensions();
	  window.addEventListener('resize', this._updateWindowDimensions);
	}

	componentWillUnmount() {
	  window.removeEventListener('resize', this._updateWindowDimensions);
	}

	_updateWindowDimensions() {
	  this.setState({ 
	  	width: window.innerWidth, 
	  	height: window.innerHeight,
	  });
	}	

	// mobile basically means a landscape phone for this app
	_mobile(width) {
		width = width || this.state.width; // default is state
		return width < MAX_MOBILE_WIDTH;
	}

	_onMenuToggleClick(e) {
		this.setState({
			showMobile: !this.state.showMobile
		});		 
	}

	_closeMenu() {
		this.setState({
			showMobile: false
		});		 
	}

	render() {
		const { children } = this.props;
		const { showMobile, width } = this.state;

		const showMenu = !this._mobile() || showMobile;
		return (
			<Fragment>
				<div id="header-wrapper">
			        <header id="header">
			           <div className="d-none d-sm-block"> 
			                <img src="/images/pizzakingme.png" />
			           </div>
			           <div className="center-block">
				           <div className=""> 
				                <img src="/images/header_logo.png" />
				           </div>
				           <div id="we-deliver-block"> 
				                <div className="we-deliver">WE DELIVER!</div>
				                <div className="food-types">PIZZA - SANDWICHES<br />SALADS - MEXICAN FOOD</div>
				                <div className="phone">317-848-7994</div>
				                <div className="address">301 E. Carmel Drive</div>
				           </div>
			           </div>
			           <div className="d-none d-md-block"> 
			                <img src="/images/pizzakingme.png" />
			           </div>
			        </header>
			        <MenuToggle onClick={this._onMenuToggleClick} />
		        </div>
		        <div id="middle">
		        	{ showMenu && (
			        <aside id="left-sidebar">
			        	
				        	<nav>
				        		<Navigation onClick={this._closeMenu} />
				        	</nav>
			        	
			        </aside>
			        )}
			        <main id="main" className="py-4">
			            { children }
			        </main>
		        </div>
		        <footer id="footer">
		        	<div className="d-block d-sm-inline">
		        		© Pizza King of Carmel, { new Date().getFullYear() }
		        	</div>
		        	<div className="d-none d-sm-inline">
		        	 &nbsp;|&nbsp; 
		        	</div>
		        	 <div className="d-block d-sm-inline">
		        		<Link to="/aboutus">About Us</Link>&nbsp;|&nbsp;<Link to="/contactus">Contact Us</Link>
		        	</div>
		        </footer>
		    </Fragment>
		  );
	}
}

export default AppLayout;