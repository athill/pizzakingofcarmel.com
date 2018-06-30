import React, { Fragment } from 'react';
import { Router, Route } from 'react-router-dom';

import AppLayout from './AppLayout';
import history from '../history';
import Home from './pages/home';

const Page = ({ message }) => (
    <Router history={history}>  
        <Fragment>  
            <AppLayout>
                <Route path="/" component={Home}/>
            </AppLayout>
        </Fragment>
    </Router>
);

export default Page;