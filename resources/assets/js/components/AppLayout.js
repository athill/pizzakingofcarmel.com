import React, { Fragment } from 'react';

const AppLayout = ({ children }) => (
	<Fragment>
        <header id="header">
           <div className=""> 
                Pizza King me!
           </div>
           <div className=""> 
                &nbsp;
           </div>
           <div className=""> 
                Pizza King of Carmel
           </div>
           <div className=""> 
                We deliver!
           </div>
           <div className=""> 
                &nbsp;
           </div>
           <div className=""> 
                Pizza King Me!
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