import React, { useState, useEffect } from "react";

import Table from "../components/table/Table";
import axios from "axios";

import { apiUrl } from '../context/Constants'

import { ToastContainer, toast } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";

// import orderList from '../assets/JsonData/orders-list.json'

import orderdetailList from "../assets/JsonData/order-detail-list.json";
import "../assets/css/index.css";
const orderdetailTableHead = [
  "ID",
  "order_detail_id",
  "product_id",
  "order_id",
  "quantity",
  "title",
  "price",
];

const renderHead = (item, index) => <th key={index}>{item}</th>;

const renderBody = (item, index) => (
  <tr key={index}>
    <td>{item.id}</td>
    <td>{item.order_detail_id}</td>
    <td>{item.product_id}</td>
    <td>{item.order_id}</td>
    <td>{item.quantity}</td>
    <td>{item.title}</td>
    <td>{item.price}</td>
  </tr>
);

// function Info ({
//   salesman_name,
//   customer_name,
//   address_customer,
//   created_at,
//   salesman_id,
//   customer_id,
//   phone_customer,
//   status
// });

const Order_Detail = () => {
  const [orderdetaillist, setOrderdetaillist] = useState();
  const [info, setInfo] = useState({
    id: "",
    order_id: "",
    salesman_id: "",
    customer_id: "",
    status: "",
    created_at: "",
    updated_at: "",
    salesman_name: "",
    customer_name: "",
    address_customer: "",
    phone_customer: "",
  });

  async function fetchData(order_id) {
    try {
      const response = await axios.get(
        `${apiUrl}/order/order_detail/${order_id}`
      );
      if (response.data.success) {
        setOrderdetaillist(response.data.data);
      }
    } catch (error) {
      toast(error.response.data.message);
      // setTimeout(() => {
      //   window.location.href = "/orders";
      // }, 1000);
    }
  }

  async function fetchDataInfo(order_id) {
    try {
      const response = await axios.get(
        `${apiUrl}/order/information/${order_id}`
      );
      if (response.data.success) {
        setInfo(response.data.data);
      }
    } catch (error) {
      console.log(error);
    }
  }

  // async function infoOrder() {
  //   await axios
  //     .get(`http://192.168.1.129:81/api/order/information/${order_id}`)
  //     .then(async (response) => {
  //           await fetchData();

  //   const response = await axios.get(
  //     `http://192.168.1.129:81/api/order/information/${order_id}`
  //   );
  //   infoOrder(response.data.data);
  //   setValue(false);
  // }

  useEffect(() => {
    const fullPath = new URLSearchParams(window.location.search);
    const order_id = fullPath.get("id");
    fetchData(order_id);
    fetchDataInfo(order_id);
  }, []);

  return (
    <div>
      <h2 className="page-header">List orders : Order_ID: {info.order_id}</h2>
      <div className="orderDetail__header">
        <p className="orderDetail__header-label">
          Customer_name:
          <span className="orderDetail__header-title">
            {info.customer_name}
          </span>
        </p>
        <p className="orderDetail__header-label">
          Salesman_Name:
          <span className="orderDetail__header-title">
            {info.salesman_name}
          </span>
        </p>

        <p className="orderDetail__header-label">
          Created_At:
          <span className="orderDetail__header-title">{info.created_at}</span>
        </p>
      </div>
      <div className="orderDetail__header">
        <p className="orderDetail__header-label">
          Customer_id:
          <span className="orderDetail__header-title">{info.customer_id}</span>
        </p>
        <p className="orderDetail__header-label">
          Salesman_id:
          <span className="orderDetail__header-title">{info.salesman_id}</span>
        </p>
        <p className="orderDetail__header-label">
          Customer_phone:
          <span className="orderDetail__header-title">
            {info.phone_customer}
          </span>
        </p>
      </div>
      <div className="orderDetail__header">
        <p className="orderDetail__header-label">
          Customer_address:
          <span className="orderDetail__header-title">
            {info.address_customer}
          </span>
        </p>
        <p className="orderDetail__header-label">
          Status:
          <span className="orderDetail__header-title">{info.status}</span>
        </p>
      </div>
      {/* <h2 className="page-header">List orders : Order_ID: </h2>
      <div className="orderDetail__header">
        <p>
          Salesman_Name<span className="orderDetail__header-title">1</span>
        </p>
        <p>
          Customer_name<span className="orderDetail__header-title">1</span>
        </p>
        <p>
          Address_customer<span className="orderDetail__header-title">1</span>
        </p>
        <p>
          Created_At<span className="orderDetail__header-title">1</span>
        </p>
      </div>
      <div className="orderDetail__header">
        <p>
          Salesman_id<span className="orderDetail__header-title">1</span>
        </p>
        <p>
          Customer_id<span className="orderDetail__header-title">1</span>
        </p>
        <p>
          Phone_customer<span className="orderDetail__header-title">1</span>
        </p>
        <p>
          Status<span className="orderDetail__header-title"></span>1
        </p>
      </div> */}

      <div className="row">
        <div className="col-12">
          <div className="card">
            <div className="card__body">
              {orderdetaillist ? (
                <Table
                  limit="5"
                  headData={orderdetailTableHead}
                  renderHead={(item, index) => renderHead(item, index)}
                  bodyData={orderdetaillist}
                  renderBody={(item, index) => renderBody(item, index)}
                />
              ) : null}
            </div>
          </div>
        </div>
      </div>
      {/* <ToastContainer
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
      <ToastContainer /> */}
    </div>
  );
};

export default Order_Detail;
