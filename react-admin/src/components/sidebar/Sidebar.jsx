import React, { useState, useEffect } from "react";

import "./sidebar.css";

import { Link } from "react-router-dom";

import logo from "../../assets/images/metrollogo.png";

import sidebar_items from "../../assets/JsonData/sidebar_routes.json";

const SidebarItem = (props) => {
  const active = props.active ? "active" : "";
  return (
    <div className="sidebar__item">
      <div className={`sidebar__item-inner ${active}`}>
        <i className={props.icon}></i>
        <span>{props.title}</span>
      </div>
    </div>
  );
};

const Sidebar = (props) => {
  const activeItem = sidebar_items.findIndex(
    (item) => item.route === props.location.pathname
  );
  const [isSupperAdmin, setIsSupperAdmin] = useState(false);

  const checkSupperAdmin = () => {
    const isAdmin = localStorage.getItem("isTeacher");
    if (isAdmin == 0) {
      setIsSupperAdmin(true);
    }
  };

  useEffect(() => {
    checkSupperAdmin();
  }, []);
  return (
    <div className="sidebar">
      <div className="sidebar__logo">
        {/* <img src={logo} alt={"company logo"} /> */}
      </div>
      {isSupperAdmin
        ? sidebar_items.map((item, index) => (
            <Link to={item.route} key={index}>
              <SidebarItem
                title={item.display_name}
                icon={item.icon}
                active={index === activeItem}
              />
            </Link>
          ))
        : sidebar_items.map((item, index) => {
            return item.route !== "/admin/teachers" ? (
              <Link to={item.route} key={index}>
                <SidebarItem
                  title={item.display_name}
                  icon={item.icon}
                  active={index === activeItem}
                />
              </Link>
            ) : (
              ""
            );
          })}
    </div>
  );
};

export default Sidebar;
