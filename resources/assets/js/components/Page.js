import React, { Fragment } from 'react';
import { Router, Route } from 'react-router-dom';

import AppLayout from './AppLayout';
import history from '../history';
import Home from './pages/home';
// pages
import AboutUs from './pages/aboutus';
import Catering from './pages/catering';
import ContactUs from './pages/contactus';
import Delivery from './pages/delivery';
import Directions from './pages/directions';
import FamilyStores from './pages/familystores';
import Hours from './pages/hours';
import Menu from './pages/menu';
import Pictures from './pages/pictures';

const Page = ({ message }) => (
    <Router history={history}>  
        <Fragment>  
            <AppLayout>
                <Route path="/" exact component={Home}/>
                <Route path="/aboutus" component={AboutUs}/>
                <Route path="/catering" component={Catering}/>       
                <Route path="/contactus" component={ContactUs}/>
                <Route path="/delivery" component={Delivery}/>
                <Route path="/directions" component={Directions}/>
                <Route path="/familystores" component={FamilyStores}/>
                <Route path="/hours" component={Hours}/>
                <Route path="/menu" component={Menu}/>
                <Route path="/pictures" component={Pictures}/>
            </AppLayout>
        </Fragment>
    </Router>
);

export default Page;
