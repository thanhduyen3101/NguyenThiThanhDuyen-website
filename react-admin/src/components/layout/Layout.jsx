import React, { useEffect, useReducer, useState } from "react";

import "./layout.css";

import { ToastContainer, toast } from "react-toastify";

import Sidebar from "../sidebar/Sidebar";
import TopNav from "../topnav/TopNav";
import Routes from "../Routes";
import Login from "../../pages/Login/Login";

import { BrowserRouter, Route, Switch } from "react-router-dom";

import { useSelector, useDispatch } from "react-redux";

import ThemeAction from "../../redux/actions/ThemeAction";

import axios from "axios";
import { authReducers } from "../../redux/reducers/authReducers";

import { apiUrl, TOKEN } from "../../context/Constants";
import setAuthToken from "../../redux/utils/setAuthToken";

const Layout = () => {
  const themeReducer = useSelector((state) => state.ThemeReducer);

  const dispatch = useDispatch();

  const [isLogin, setIsLogin] = useState(false);

  const checkLogin = async () => {
    if (localStorage[TOKEN]) {
      setAuthToken(localStorage[TOKEN]);
    }

    if (localStorage.getItem("isAdmin") === "1" && localStorage.getItem("token")) {
      setIsLogin(true);
    } else {
      window.location.href = "/admin/login";
      localStorage.removeItem("token");
      localStorage.removeItem("isAdmin");
      localStorage.removeItem("isTeacher");
    }
  };

  useEffect(() => {
    checkLogin();

    const themeClass = localStorage.getItem("themeMode", "theme-mode-light");

    const colorClass = localStorage.getItem("colorMode", "theme-mode-light");

    dispatch(ThemeAction.setMode(themeClass));

    dispatch(ThemeAction.setColor(colorClass));
  }, [dispatch]);
  if (isLogin) {
    return (
      <BrowserRouter>
        <Route
          render={(props) => (
            <div
              className={`layout ${themeReducer.mode} ${themeReducer.color}`}
            >
              <Sidebar {...props} />
              <div className="layout__content">
                <TopNav />
                <div className="layout__content-main">
                  <Routes />
                </div>
              </div>
              <ToastContainer
                position="top-right"
                autoClose={2000}
                hideProgressBar={false}
                newestOnTop={false}
                closeOnClick
                rtl={false}
                pauseOnFocusLoss
                draggable
                pauseOnHover
              />
              {/* Same as */}
              <ToastContainer />
            </div>
          )}
        />
      </BrowserRouter>
    );
  } else {
    return <></>;
  }
};

export default Layout;
