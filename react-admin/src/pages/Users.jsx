import React, { useState, useEffect } from "react";

import Table from "../components/table/Table";
import { apiUrl } from '../context/Constants'
import axios from "axios";
import { ToastContainer, toast } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";

// import userList from "../assets/JsonData/users-list.json";

import { Dropdown } from "react-bootstrap";

// import { withRouter } from "react-router-dom";

const userTableHead = [
  "ID",
  // "user_id",
  "Tên học viên",
  "email",
  "SĐT",
  "Địa chỉ",
  // "area_id",
  // "type_id",
  // "confirm",
  "Thao tác",
];

const Users = () => {
  const [value, setValue] = useState(false);
  const [userlist, setUserlist] = useState();
  const [courses, setListCourse] = useState();

  async function fetchData() {
    await setUserlist(null);
    const response1 = await axios.get(
      `${apiUrl}/admin/category/list`
    );
    setListCourse(response1.data.data);
    const response = await axios.get(
      `${apiUrl}/admin/user/list`
    );
    setUserlist(response.data.data);
  }

  const renderHead = (item, index) => <th key={index}>{item}</th>;

  const confirm = async (user_id) => {
    try {
      const res = await axios.post(
        `${apiUrl}/admin/user/confirm/${user_id}`
      );
      if (res.data) {
        toast(res.data.message);
        setValue(!value);
      }
    } catch (error) {
      toast(error.response.data.message);
    }
  };
  const deluser = async (id) => {
    try {
      const res = await axios.post(
        `${apiUrl}/admin/user/delete/${id}`
      );
      if (res.data) {
        toast(res.data.message);
        setValue(true);
      }
    } catch (error) {
      toast(error.response.data.message);
    }
  };


  const renderBody = (item, index) => {
    return (
      <tr >
        <td style={{ color: "gray" }}>{item.user_id}</td>
        <td style={{ textAlign: "left" }}>{item.name}</td>
        <td style={{ textAlign: "left", textTransform: "lowercase" }}>{item.email}</td>
        <td>{item.tel}</td>
        <td style={{ textAlign: "left" }}>{item.address}</td>
        <td><div className="delete-action">
            <button onClick={()=>deleteCate(item.id)}
                >
              <i className="bx bx-trash" style={{ fontSize: "20px",lineHeight: 1.5}} />
            </button>
          </div></td>
      </tr>
    );
  };

  async function deleteCate(id) {
    await axios
      .post(`${apiUrl}/admin/user/delete/${id}`)
      .then(async (response) => {
        toast(response.data.message);
        if (response.data.success) {
          setValue(true);
        }
      })
      .catch((error) => {
        if (error.response) {
          toast(error.response.data.message);
        } else {
          toast("Error");
        }
      });
  }

  useEffect(() => {
    fetchData();
  }, [value]);

  return (
    <div>
      <h2 className="page-header">Học viên</h2>
      <div className="row">
        <div className="col-12">
          <div className="card">
            {/* <div className="card__header"> 
              <select
              className="select-course"
              name="course"
              onChange={(event) => {
                // onChangeArea(event, item.id);
              }}
            >
            <option value="">Khóa học:</option> 
              {courses &&
                courses.map((e) => {
                  return (
                    <option key={e.category_id} value={e.category_id}>
                      {e.name}
                    </option>
                  );
                })}
            </select>
           </div>  */}
            <div className="card__body">
              {userlist ? (
                <Table
                  limit="10"
                  headData={userTableHead}
                  renderHead={(item, index) => renderHead(item, index)}
                  bodyData={userlist}
                  renderBody={(item, index) => renderBody(item, index)}
                />
              ) : (
                <div className="w-100 text-center">
                  <div className="spinner-border text-dark" role="status"></div>
                </div>
              )}
            </div>
          </div>
        </div>
      </div>
      <ToastContainer
        position="top-right"
        autoClose={3000}
        hideProgressBar={false}
        newestOnTop={false}
        closeOnClick
        rtl={false}
        pauseOnFocusLoss
        draggable
        pauseOnHover
      />
      <ToastContainer />
    </div>
  );
};

export default Users;
