import React from "react";

import { Route, Switch, BrowserRouter as Router } from "react-router-dom";

import Dashboard from "../pages/Dashboard";
import Users from "../pages/Users";
import Orders from "../pages/Orders";
import Categories from "../pages/Categories";
import Products from "../pages/Products";
import Order_Detail from "../pages/Order_Detail";
import Saleman_Revenue from "../pages/Saleman_Revenue";
import Admin from "../pages/Admin";
import Kpi from "../pages/Kpi";
import Kpi_Detail from "../pages/Kpi_Detail";
import Checkin from "../pages/Checkin";
import Customer from "../pages/Customer";
import AuthContextProvider from "../context/AuthContext";
import Layout from "./layout/Layout";
import LoginAdmin from "../pages/Login/LoginAdmin";


const Routes = () => {
    return (
        <Switch>
            <Route path="/admin/users" exact component={Users} />
            <Route path="/admin/orders" component={Orders} />
            <Route path="/admin/score" component={Kpi} />
            <Route path="/admin/teachers" component={Customer} />
            <Route path="/admin/score_detail" component={Kpi_Detail} />
            <Route path='/admin/course/detail/:id' render={(props) => <Products {...props} />} />
            <Route path="/admin/course" component={Categories} />
        </Switch>
    );
};

export default Routes;
