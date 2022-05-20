import React, { useState, useEffect } from "react";

import Table from "../components/table/Table";

import axios from "axios";

import { ToastContainer, toast } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";

// import orderList from '../assets/JsonData/orders-list.json'

import { DateTimePicker } from "react-rainbow-components";

import { Dropdown } from "react-bootstrap";

import { apiUrl } from '../context/Constants'

const orderTableHead = [
  "Order id",
  "Student name",
  "status",
  "confirm",
];

const Orders = () => {
  const [value, setValue] = useState(false);
  const [orderlist, setOrderlist] = useState();

  async function fetchData() {
    setOrderlist(null);
    const response = await axios.get(
      `${apiUrl}/admin/order/list`
    );
    setOrderlist(response.data.data);
    setValue(false);
  }
  const confirm = async (id, st) => {
    try {
      const status = st == 1 ? "STT4" : "STT3"
      const res = await axios.post(
        `${apiUrl}/order/update/status/${id}`,
        {
          status: status,
        }
      );
      if (res.data) {
        toast(res.data.message);
        setTimeout(() => {
          setValue(!value);
        }, 1000);
      }
    } catch (error) {
      toast(error.response.data.message);
    }
  };

  const renderHead = (item, index) => <th key={index}>{item}</th>;

  const viewDetail = (id) => {
    window.location.href = "/admin/order/detail/?id=" + id;
  };

  const renderBody = (item, index) => {
    let colorBtn = item.status_name;
    return (
      <tr key={index}>
        <td>{item.order_id}</td>
        <td>{item.student_name}</td>
        <td>
          <div className="status">
            <button className={`status-button color-${colorBtn}`}>
              {item.status_name}
            </button>
          </div>
        </td>
        <td>
          {item.status == "STT2" ? (
            <div className="d-flex">
              <div className="confirm" style={{marginRight: "10px"}}>
                <button onClick={() => confirm(item.id, 1)}>Confirm</button>
              </div>
              <div >
                <button className="status-button color-Canceled" onClick={() => confirm(item.id, 2)}>Reject</button>
              </div>
            </div>
          ) : null}
        </td>
      </tr>
    );
  };

  useEffect(() => {
    fetchData();
  }, [value]);

  const initialState = {
    value: new Date("2021-10-25 10:44"),
    // locale: { name: 'en-US', label: 'English (US)' },
  };

  const [state, setState] = useState(initialState);

  const containerStyles = {
    maxWidth: 250,
  };

  return (
    <div>
      <h2 className="page-header">Danh sách học viên đăng ký khóa học</h2>
      <div className="row">
        <div className="col-12">
          <div className="card">
            <div className="card__body">
              {orderlist ? (
                <Table
                  limit="5"
                  headData={orderTableHead}
                  renderHead={(item, index) => renderHead(item, index)}
                  bodyData={orderlist}
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

export default Orders;
