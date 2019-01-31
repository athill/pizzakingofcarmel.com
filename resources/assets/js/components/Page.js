import React, { Fragment } from 'react';
import { Router, Route } from 'react-router-dom';

import AppLayout from './AppLayout';
import history from '../history';

// pages
import AboutUs from './pages/aboutus';
import Catering from './pages/catering';
import ContactUs from './pages/contactus';
import Delivery from './pages/delivery';
import Directions from './pages/directions';
import FamilyStores from './pages/familystores';
import Home from './pages/home';
import Hours from './pages/hours';
import Menu, { PrintMenu } from './pages/menu';
import Pictures from './pages/pictures';

const Page = ({ children, message }) => (
    <Router history={history}>  
        <Fragment>
        
        <AppLayout show={!location.pathname.includes('/print')}>
            <Route path="/" exact component={Home}/>
            <Route path="/aboutus" component={AboutUs}/>
            <Route path="/catering" component={Catering}/>       
            <Route path="/contactus" component={ContactUs}/>
            <Route path="/delivery" component={Delivery}/>
            <Route path="/directions" component={Directions}/>
            <Route path="/familystores" component={FamilyStores}/>
            <Route path="/hours" component={Hours}/>
            <Route path="/menu" exact component={Menu}/>
            <Route path="/pictures" component={Pictures}/>
        </AppLayout>
        <Route 
            path="/print" 
            render={(props) => <Menu {...props} print={true} />}/>
        </Fragment>
    </Router>
);


export default Page;
