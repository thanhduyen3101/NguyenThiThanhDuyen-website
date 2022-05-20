import React, { useState, useEffect } from "react";

import StatusCard from "../components/status-card/StatusCard";

import Chart from "react-apexcharts";

import { useSelector } from "react-redux";

// import { Link } from "react-router-dom";

import Table from "../components/table/Table";

import statusCards from "../assets/JsonData/status-card-data.json";

import { DateTimePicker } from "react-rainbow-components";

import { Dropdown } from "react-bootstrap";

import axios from "axios";
import { apiUrl } from '../context/Constants'

const salemanTableHead = [
  "ID",
  "user_id",
  "name",
  "email",
  "tel",
  "address",
  // "area_name",
  // "action",
  "revenue",
];

const renderSalemanHead = (item, index) => <th key={index}>{item}</th>;

const renderBody = (item, index) => {
  return (
    <tr>
      <td>{item.id}</td>
      <td>{item.user_id}</td>
      <td>{item.name}</td>
      <td>{item.email}</td>
      <td>{item.tel}</td>
      <td>{item.address}</td>
      <td>{item.revenue}</td>
      {/* <td>{item.area_name}</td> */}
      {/* <td>
      <div className="view-action">
        <button>
          <i
            className="bx bx-show"
            style={{ fontSize: "20px", lineHeight: 1.5}}
          />
        </button>
      </div>
      </td> */}
    </tr>
  );
};

const Dashboard = () => {
  const [value, setValue] = useState(false);
  const [smlist, setSmlist] = useState();
  const [total, setTotal] = useState([]);
  const [chart, setChart] = useState([
    {
      name: "Salesman revenue",
      data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
    },
  ]);

  const chartOptions = {
    series: [
      {
        name: "Salesman revenue",
        data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
      },
    ],
    options: {
      color: ["#6ab04c", "#2980b9"],
      chart: {
        background: "transparent",
      },
      dataLabels: {
        enabled: false,
      },
      stroke: {
        curve: "smooth",
      },
      xaxis: {
        categories: [
          "Jan",
          "Feb",
          "Mar",
          "Apr",
          "May",
          "Jun",
          "Jul",
          "Aug",
          "Sep",
          "Oct",
          "Nov",
          "Dec",
        ],
      },
      legend: {
        position: "top",
      },
      grid: {
        show: false,
      },
    },
  };
  // let chart = [
  //   {
  //     name: "Salesman revenue",
  //     data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
  //   },
  // ];
  // async function fetchData() {
  //   const response = await axios.get(
  //     `${apiUrl}/admin/user/salesman/list`
  //   );
  //   const response1 = await axios.get(
  //     `${apiUrl}/admin/order/order_detail/list`
  //   );
  //   const response2 = await axios.get(
  //     `${apiUrl}/admin/dashboard/total`
  //   );
  //   setTotal(response2.data.data ? response2.data.data[0] : []);
  //   const data = response1.data.data;
  //   let t1 = 0;
  //   let t2 = 0;
  //   let t3 = 0;
  //   let t4 = 0;
  //   let t5 = 0;
  //   let t6 = 0;
  //   let t7 = 0;
  //   let t8 = 0;
  //   let t9 = 0;
  //   let t10 = 0;
  //   let t11 = 0;
  //   let t12 = 0;
  //   for (let k = 0; k < data.length; k++) {
  //     const month = new Date(data[k].created_at).getMonth();
  //     if (month == 0) {
  //       t1 = t1 + data[k].quantity * data[k].price;
  //     } else if (month == 0) {
  //       t1 = t1 + data[k].quantity * data[k].price;
  //     } else if (month == 1) {
  //       t2 = t2 + data[k].quantity * data[k].price;
  //     } else if (month == 2) {
  //       t3 = t3 + data[k].quantity * data[k].price;
  //     } else if (month == 3) {
  //       t4 = t4 + data[k].quantity * data[k].price;
  //     } else if (month == 4) {
  //       t5 = t5 + data[k].quantity * data[k].price;
  //     } else if (month == 5) {
  //       t6 = t6 + data[k].quantity * data[k].price;
  //     } else if (month == 6) {
  //       t7 = t7 + data[k].quantity * data[k].price;
  //     } else if (month == 7) {
  //       t8 = t8 + data[k].quantity * data[k].price;
  //     } else if (month == 8) {
  //       t9 = t9 + data[k].quantity * data[k].price;
  //     } else if (month == 9) {
  //       t10 = t10 + data[k].quantity * data[k].price;
  //     } else if (month == 10) {
  //       t11 = t11 + data[k].quantity * data[k].price;
  //     } else if (month == 11) {
  //       t12 = t12 + data[k].quantity * data[k].price;
  //     }
  //   }
  //   setChart([
  //     {
  //       name: "Salesman revenue",
  //       data: [t1, t2, t3, t4, t5, t6, t7, t8, t9, t10, t11, t12],
  //     },
  //   ]);
  //   console.log(chartOptions.series[0].data);

  //   const revenue_temp = [];
  //   // for (let i = 0; i < response.data.data.length; i++) {
  //   //   let count = 0;
  //   //   for (let j = 0; j < data.length; j++) {
  //   //     if (response.data.data[i].user_id == data[j].salesman_id) {
  //   //       count = count + data[j].quantity * data[j].price;
  //   //     }
  //   //   }
  //   //   revenue_temp.push(count);
  //   // }
  //   // let newObject = [];
  //   // for (let index = 0; index < response.data.data.length; index++) {
  //   //   newObject.push({
  //   //     id: response.data.data[index].id,
  //   //     user_id: response.data.data[index].user_id,
  //   //     name: response.data.data[index].name,
  //   //     email: response.data.data[index].email,
  //   //     tel: response.data.data[index].tel,
  //   //     address: response.data.data[index].address,
  //   //     revenue: revenue_temp[index],
  //   //   });
  //   // }

  //   setSmlist(newObject);
  //   setValue(false);
  // }
  // useEffect(() => {
  //   fetchData();
  // }, [value]);

  const initialState = {
    value: new Date("2021-10-25 10:44"),
  };

  const [state, setState] = useState(initialState);
  const themeReducer = useSelector((state) => state.ThemeReducer.mode);

  const containerStyles = {
    maxWidth: 250,
  };

  //   [
  //     {
  //         "icon": "bx bx-user-circle",
  //         "count": "1,995",
  //         "title": "Total Salesman"
  //     },
  //     {
  //         "icon": "bx bx-cart",
  //         "count": "2,001",
  //         "title": "Total orders in cart"
  //     },
  //     {
  //         "icon": "bx bx-dollar-circle",
  //         "count": "$2,632",
  //         "title": "Total revenue"
  //     },
  //     {
  //         "icon": "bx bx-receipt",
  //         "count": "1,711",
  //         "title": "Total orders"
  //     }
  // ]

  return (
    <div>
      <h2 className="page-header">Trang chủ</h2>
      
    </div>
  );
};

export default Dashboard;
