import React, { Fragment } from 'react';

const AppLayout = ({ children }) => (
	<Fragment>
        <header id="header" className="d-flex justify-content-between">
           <div className="d-none d-sm-block"> 
                <img src="/images/pizzakingme.png" />
           </div>
           <div className="d-flex justify-content-center">
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
        <aside id="left-sidebar">sidebar</aside>
        <main id="main" className="py-4">
            { children }
        </main>
        <footer id="footer"> © Pizza King of Carmel, { new Date().getFullYear() } | About Us | Contact Us</footer>
    </Fragment>
);

export default AppLayout;