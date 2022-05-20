import React from "react";
import ReactDOM from "react-dom";
import reportWebVitals from "./reportWebVitals";

import { createStore } from "redux";

import { Provider } from "react-redux";

import rootReducer from "./redux/reducers";

import {
  BrowserRouter,
  Route,
  Switch,
  Redirect,
  useLocation,
} from "react-router-dom";
import "bootstrap/dist/css/bootstrap.min.css";

import "./assets/boxicons-2.0.7/css/boxicons.min.css";
import "./assets/css/grid.css";
import "./assets/css/theme.css";
import "./assets/css/index.css";
// import 'semantic-ui-css/semantic.min.css';
import Layout from "./components/layout/Layout.jsx";
// import Routes from "./components/Routes";
import RootRoutes from "./components/RootRoutes";
// import AuthContextProvider from "../src/context/AuthContext";
// import Login from "../src/pages/Login/Login";
import Home from '../src/pages/Home/Home';

const store = createStore(rootReducer);

document.title = "Metrol Dashboard";
ReactDOM.render(
  <Provider store={store}>
    <React.StrictMode>
      <BrowserRouter>
        {
          (window.location.pathname.indexOf("/admin") < 0 || window.location.pathname === "/admin/login") ? (
            <Switch>
              <Route path='/'>
                <Home />
              </Route>
            </Switch>
          ) : <Layout />}


      </BrowserRouter>
    </React.StrictMode>
  </Provider>,
  document.getElementById("root")
);

// If you want to start measuring performance in your app, pass a function
// to log results (for example: reportWebVitals(console.log))
// or send to an analytics endpoint. Learn more: https://bit.ly/CRA-vitals
reportWebVitals();
