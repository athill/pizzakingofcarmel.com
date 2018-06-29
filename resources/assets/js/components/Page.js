import React, { Fragment } from 'react';
import { Router, Route } from 'react-router-dom';

import AppLayout from './AppLayout';
import history from '../history';
import Home from './pages/home';
// import Items from './pages/items';
// import PasswordReset from './pages/password-reset';
// import PasswordReset2 from './pages/reset-password-2';
// import PrivateRoute from './PrivateRoute';
// import PublicRoute from './PublicRoute';
// import Register from './pages/register';
// import Import from './pages/import';

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