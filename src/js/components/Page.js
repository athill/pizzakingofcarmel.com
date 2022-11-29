import React from 'react';
import { BrowserRouter, Route, Routes } from 'react-router-dom';

import AppLayout from './AppLayout';

// pages
import AboutUs from './pages/aboutus';
import Catering from './pages/catering';
import ContactUs from './pages/contactus';
import Delivery from './pages/delivery';
import Directions from './pages/directions';
import FamilyStores from './pages/familystores';
import Home from './pages/home';
import Hours from './pages/hours';
import Menu from './pages/menu';
import Pictures from './pages/pictures';

// eslint-disable-next-line no-restricted-globals
const isPrint = location.pathname.includes('/print');

const AppView = ({ show }) => (
    <AppLayout show={ !isPrint }>
        <Routes>
            <Route path="/" exact element={<Home />}/>
            <Route path="/aboutus" element={<AboutUs />}/>
            <Route path="/catering" element={<Catering />}/>    
            <Route path="/contactus" element={<ContactUs />}/>
            <Route path="/delivery" element={<Delivery />}/>
            <Route path="/directions" element={<Directions />}/>
            <Route path="/familystores" element={<FamilyStores />}/>
            <Route path="/hours" element={<Hours />}/>
            <Route path="/menu" exact element={<Menu />}/>
            <Route path="/pictures" element={<Pictures />}/>
        </Routes>
    </AppLayout>
);

const Page = ({ children, message }) => (
    <BrowserRouter> 
        <Routes>
            <Route path="/print" element={<Menu print={true} />} />
            <Route path="*" element={<AppView />} />
        </Routes> 
    </BrowserRouter>
);


export default Page;
