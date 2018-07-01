import React, { Component, Fragment } from 'react';

import Sidebar from './AppSidebar';

const MenuToggle = ({ onClick }) => (
	<i id="menu-toggle" className="fa fa-bars" onClick={onClick}></i>
);


class AppLayout extends Component {
	constructor(props) {
		super(props);
		this.menuToggle = React.createRef();
		this._onMenuToggleClick = this._onMenuToggleClick.bind(this);
	}

	_onMenuToggleClick(e) {
		 this.menuToggle.current.style.display = this.menuToggle.current.style.display === 'block' ? 'none' : 'block';
	}

	render() {
		const { children } = this.props;
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
			           <div className="d-none d-sm-block"> 
			                <img src="/images/pizzakingme.png" />
			           </div>
			        </header>
			        <MenuToggle onClick={this._onMenuToggleClick} />
		        </div>
		        <div id="middle">
			        <aside id="left-sidebar" ref={this.menuToggle}>
			        	<nav>
			        		<Sidebar />
			        	</nav>
			        </aside>
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
		        		About Us&nbsp;|&nbsp;Contact Us
		        	</div>
		        </footer>
		    </Fragment>
		  );
	}
}

export default AppLayout;