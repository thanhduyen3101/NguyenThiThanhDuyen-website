import React, { useState, useEffect } from "react";

import axios from "axios";

import Table from "../components/table/Table";
import { ToastContainer, toast } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";

import { apiUrl } from '../context/Constants'

const Customer = () => {
  const [value, setValue] = useState(false);
  const [loading, setLoading] = useState(false);
  const [listcustomer, setListcustomer] = useState();

  const customerTableHead = [
    "ID",
    "Tên giáo viên",
    "Email",
    "SĐT",
    "Địa chỉ"
  ];

  const renderHead = (item, index) => <th key={index}>{item}</th>;

  async function fetchData() {
    setListcustomer(null);
    const response = await axios.get(`${apiUrl}/admin/teacher/list`);
    setListcustomer(response.data.data);
    setValue(false);
  }
  

  const renderBody = (item, index) => {
    return (
      <tr key={index}>
        <td>{item.user_id}</td>
        <td>{item.name}</td>
        <td>{item.email}</td>
        <td>{item.tel}</td>
        <td>{item.address}</td>
      </tr>
    );
  };

  useEffect(() => {
    const isTeacher = localStorage.getItem("isTeacher");
    if (isTeacher == 1) {
      window.location.href = '/admin/users';
    }
    fetchData();
  }, [value]);
  return (
    <div>
      <h2 className="page-header">Giáo viên</h2>
      <div className="row">
        <div className="col-12">
          <div className="card">
            <div className="card__body">
              {listcustomer ? (
                <Table
                  limit="5"
                  headData={customerTableHead}
                  renderHead={(item, index) => renderHead(item, index)}
                  bodyData={listcustomer}
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
      {/* Same as */}
      <ToastContainer />
    </div>
  );
};

export default Customer;
