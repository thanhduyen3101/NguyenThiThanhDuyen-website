import React, { useState, useEffect, useReducer } from "react";
import { Switch, Route } from "react-router-dom/cjs/react-router-dom.min";
import Aboutus from "./Body/Aboutus/Aboutus";
import Intro from "./Body/Intro/Intro";
import Footer from "./Footer/Footer";
import Header from "./Header/Header";
import Contact from "./Body/contact/Contact";
import Course from "./Body/course/Course";
import Login from "../Login/Login";
import LoginAdmin from "../Login/LoginAdmin";
import SignupForm from './component/Signup/Signup';
import Admin from "../../pages/Admin";

function Home() {

    return (
        <>
            {
                (window.location.pathname === "/login" || window.location.pathname === "/admin/login") ? '' : <Header />}
            <Switch>
                <Route exact path='/' component={Intro} />
                <Route path='/course/detail/:id' render={(props) => <Course {...props} />} />
                <Route path='/aboutus' component={Aboutus} />
                <Route path='/contact' component={Contact} />
                <Route path="/login" component={Login} />
                <Route path="/signup" component={SignupForm} />
                <Route path="/admin/login" component={LoginAdmin} />
                <Route path="/admin" component={Admin} />
            </Switch>
            {
                (window.location.pathname === "/login" || window.location.pathname === "/admin/login") ? '' : <Footer />}
        </>
    )
}

export default Home;